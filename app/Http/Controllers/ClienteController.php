<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\PedidoCliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proyectoId = $this->resolveActiveProyectoId(request());

        $buscar = trim((string) request('buscar', ''));
        $estado = (string) request('estado', 'todos');

        $clientesQuery = Cliente::query()
            ->where('proyecto_id', $proyectoId)
            ->withCount(['albaranes', 'presupuestos', 'pedidosClientes']);

        if ($buscar !== '') {
            $clientesQuery->where(function ($query) use ($buscar) {
                $query->where('empresa_nombre', 'like', '%' . $buscar . '%')
                    ->orWhere('cif_nif', 'like', '%' . $buscar . '%')
                    ->orWhere('localidad', 'like', '%' . $buscar . '%')
                    ->orWhere('persona_contacto', 'like', '%' . $buscar . '%');
            });
        }

        if ($estado === 'activas') {
            $clientesQuery->where(function ($query) {
                $query->whereNotNull('email')->where('email', '!=', '')
                    ->orWhereNotNull('telefono')->where('telefono', '!=', '');
            });
        } elseif ($estado === 'inactivas') {
            $clientesQuery->where(function ($query) {
                $query
                    ->where(function ($subQuery) {
                        $subQuery->whereNull('email')->orWhere('email', '=', '');
                    })
                    ->where(function ($subQuery) {
                        $subQuery->whereNull('telefono')->orWhere('telefono', '=', '');
                    });
            });
        }

        $clientes = $clientesQuery
            ->orderBy('empresa_nombre')
            ->paginate(8)
            ->withQueryString();

        return view('clientes.index', compact('clientes', 'buscar', 'estado'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $proyectoId = $this->resolveActiveProyectoId($request);

        $validated = $request->validate([
            'empresa_nombre' => 'required|string|max:255',
            'cif_nif' => 'required|unique:clientes,cif_nif|max:20',
            'direccion' => 'required|string|max:255',
            'localidad' => 'required|string|max:100',
            'codigo_postal' => 'required|string|max:10',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'persona_contacto' => 'nullable|string|max:100',
        ]);

        $validated['proyecto_id'] = $proyectoId;

        Cliente::create($validated);

        return redirect()->route('clientes.index')->with('success', 'Cliente creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        $proyectoId = $this->resolveActiveProyectoId(request());

        if ((int) $cliente->proyecto_id !== $proyectoId) {
            abort(404);
        }

        $estadoFiltro = (string) request('estado', 'todos');
        $hoy = now();
        $limitePendiente = $hoy->copy()->subDays(15)->toDateString();
        $limiteEntregado = $hoy->copy()->subDays(45)->toDateString();

        $presupuestosQuery = $cliente->presupuestos()
            ->orderByDesc('fecha')
            ->orderByDesc('id');

        if ($estadoFiltro === 'pendiente') {
            $presupuestosQuery->whereDate('fecha', '>=', $limitePendiente);
        } elseif ($estadoFiltro === 'recibido') {
            $presupuestosQuery->whereBetween('fecha', [$limiteEntregado, $hoy->copy()->subDays(16)->toDateString()]);
        } elseif ($estadoFiltro === 'entregado') {
            $presupuestosQuery->whereDate('fecha', '<', $limiteEntregado);
        }

        $presupuestos = $presupuestosQuery->paginate(5)->withQueryString();

        $pedidosPorOt = PedidoCliente::query()
            ->where('id_cliente', $cliente->id)
            ->whereNotNull('ot')
            ->get()
            ->keyBy(fn (PedidoCliente $pedido) => trim((string) $pedido->ot));

        $resolverTotalDesdeArticulos = static function (?array $listaArticulos): ?float {
            if (!is_array($listaArticulos) || $listaArticulos === []) {
                return null;
            }

            $total = 0.0;
            $hayValores = false;

            foreach ($listaArticulos as $articulo) {
                if (!is_array($articulo)) {
                    continue;
                }

                if (isset($articulo['total']) && is_numeric($articulo['total'])) {
                    $total += (float) $articulo['total'];
                    $hayValores = true;
                    continue;
                }

                $cantidad = (float) ($articulo['cantidad'] ?? $articulo['qty'] ?? 0);
                $precio = (float) ($articulo['precio_unitario'] ?? $articulo['precio'] ?? $articulo['price'] ?? 0);

                if ($cantidad > 0 && $precio > 0) {
                    $total += $cantidad * $precio;
                    $hayValores = true;
                }
            }

            return $hayValores ? round($total, 2) : null;
        };

        $presupuestos->getCollection()->transform(function ($presupuesto) use ($hoy, $pedidosPorOt, $resolverTotalDesdeArticulos) {
            $dias = $presupuesto->fecha ? $presupuesto->fecha->diffInDays($hoy) : 999;

            if ($dias <= 15) {
                $presupuesto->ui_estado = 'pendiente';
                $presupuesto->ui_estado_label = 'PENDIENTE';
            } elseif ($dias <= 45) {
                $presupuesto->ui_estado = 'recibido';
                $presupuesto->ui_estado_label = 'RECIBIDO';
            } else {
                $presupuesto->ui_estado = 'entregado';
                $presupuesto->ui_estado_label = 'ENTREGADO';
            }

            $total = null;
            $ot = trim((string) ($presupuesto->ot ?? ''));

            if ($ot !== '' && $pedidosPorOt->has($ot)) {
                $total = $resolverTotalDesdeArticulos($pedidosPorOt->get($ot)?->lista_articulos);
            }

            $presupuesto->ui_total = $total;

            return $presupuesto;
        });

        return view('clientes.show', compact('cliente', 'presupuestos', 'estadoFiltro'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        $proyectoId = $this->resolveActiveProyectoId(request());

        if ((int) $cliente->proyecto_id !== $proyectoId) {
            abort(404);
        }

        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $proyectoId = $this->resolveActiveProyectoId($request);

        if ((int) $cliente->proyecto_id !== $proyectoId) {
            abort(404);
        }

        $validated = $request->validate([
            'empresa_nombre' => 'required|string|max:255',
            'cif_nif' => 'required|unique:clientes,cif_nif,' . $cliente->id . '|max:20',
            'direccion' => 'required|string|max:255',
            'localidad' => 'required|string|max:100',
            'codigo_postal' => 'required|string|max:10',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'persona_contacto' => 'nullable|string|max:100',
        ]);

        $cliente->update($validated);

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        $proyectoId = $this->resolveActiveProyectoId(request());

        if ((int) $cliente->proyecto_id !== $proyectoId) {
            abort(404);
        }

        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado exitosamente');
    }
}
