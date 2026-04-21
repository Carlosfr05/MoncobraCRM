<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Presupuesto;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PresupuestoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $proyectoId = $this->resolveActiveProyectoId($request);
        $search = trim((string) $request->input('search', ''));

        $presupuestosQuery = Presupuesto::with('cliente')
            ->where('proyecto_id', $proyectoId);

        if ($search !== '') {
            $like = '%' . $search . '%';
            $dateValue = null;

            try {
                $dateValue = Carbon::parse($search)->toDateString();
            } catch (\Throwable $exception) {
                $dateValue = null;
            }

            $presupuestosQuery->where(function ($query) use ($like, $dateValue) {
                $query->where('documento', 'like', $like)
                    ->orWhere('numero', 'like', $like)
                    ->orWhere('ot', 'like', $like)
                    ->orWhereHas('cliente', function ($clienteQuery) use ($like) {
                        $clienteQuery->where('empresa_nombre', 'like', $like);
                    });

                if ($dateValue) {
                    $query->orWhereDate('fecha', $dateValue);
                }
            });
        }

        $presupuestos = $presupuestosQuery
            ->orderByDesc('fecha')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('presupuestos.index', compact('presupuestos', 'search'));
    }

    public function create(Request $request)
    {
        $proyectoId = $this->resolveActiveProyectoId($request);
        $clientes = Cliente::where('proyecto_id', $proyectoId)->orderBy('empresa_nombre')->get();

        $clienteSeleccionadoId = (int) $request->query('cliente_id', 0);
        if ($clienteSeleccionadoId > 0 && !$clientes->contains('id', $clienteSeleccionadoId)) {
            $clienteSeleccionadoId = 0;
        }

        $volverACliente = $request->boolean('volver_cliente') && $clienteSeleccionadoId > 0;

        $modo = (string) $request->query('modo', 'nuevo');

        return view('presupuestos.create', compact('clientes', 'clienteSeleccionadoId', 'volverACliente', 'modo'));
    }

    public function store(Request $request)
    {
        $proyectoId = $this->resolveActiveProyectoId($request);

        $redirectClienteId = (int) $request->input('redirect_cliente_id', 0);
        $modo = (string) $request->input('modo', 'nuevo');
        $archivoPdfRule = $modo === 'carga' ? 'required' : 'nullable';

        $validated = $request->validate([
            'documento' => 'required|string|max:50',
            'numero' => 'required|string|max:50',
            'fecha' => 'required|date',
            'cliente_id' => [
                'required',
                Rule::exists('clientes', 'id')->where(fn ($query) => $query->where('proyecto_id', $proyectoId)),
            ],
            'titulo' => 'nullable|string|max:255',
            'ot' => 'nullable|string|max:255',
            'archivo_pdf' => [$archivoPdfRule, 'file', 'mimes:pdf', 'max:10240'],
            'lista_articulos' => 'nullable|json',
        ]);

        $validated['proyecto_id'] = $proyectoId;

        if ($request->hasFile('archivo_pdf')) {
            $validated['archivo_pdf'] = $request->file('archivo_pdf')->store('presupuestos', 'public');
        }

        $listaArticulos = json_decode((string) ($validated['lista_articulos'] ?? '[]'), true);
        $validated['lista_articulos'] = collect(is_array($listaArticulos) ? $listaArticulos : [])
            ->filter(fn ($item) => is_array($item) && !empty(trim((string) ($item['descripcion'] ?? ''))))
            ->map(function (array $item) {
                $cantidad = max(0, (float) ($item['cantidad'] ?? 0));
                $precioUnitario = max(0, (float) ($item['precio_unitario'] ?? 0));
                $margen = max(0, (float) ($item['margen'] ?? 0));
                $total = max(0, (float) ($item['total'] ?? 0));

                return [
                    'articulo' => trim((string) ($item['articulo'] ?? '')),
                    'descripcion' => trim((string) ($item['descripcion'] ?? '')),
                    'cantidad' => round($cantidad, 2),
                    'precio_unitario' => round($precioUnitario, 2),
                    'margen' => round($margen, 2),
                    'total' => round($total, 2),
                ];
            })
            ->values()
            ->all();

        if ($validated['lista_articulos'] === []) {
            $validated['lista_articulos'] = null;
        }

        $validated['total'] = collect($validated['lista_articulos'] ?? [])->sum(function (array $item) {
            return (float) ($item['total'] ?? 0);
        });
        $validated['estado'] = 'pendiente';

        Presupuesto::create($validated);

        if ($redirectClienteId > 0 && $redirectClienteId === (int) $validated['cliente_id']) {
            return redirect()->route('clientes.show', $redirectClienteId)->with('success', 'Presupuesto cargado correctamente');
        }

        return redirect()->route('presupuestos.index')->with('success', 'Presupuesto creado');
    }

    public function show(Presupuesto $presupuesto)
    {
        $proyectoId = $this->resolveActiveProyectoId(request());

        if ((int) $presupuesto->proyecto_id !== $proyectoId) {
            abort(404);
        }

        return view('presupuestos.show', compact('presupuesto'));
    }

    public function viewPdf(Presupuesto $presupuesto)
    {
        $proyectoId = $this->resolveActiveProyectoId(request());

        if ((int) $presupuesto->proyecto_id !== $proyectoId) {
            abort(404);
        }

        if (!$presupuesto->archivo_pdf) {
            abort(404);
        }

        $disk = Storage::disk('public');
        if (!$disk->exists($presupuesto->archivo_pdf)) {
            abort(404);
        }

        $path = $disk->path($presupuesto->archivo_pdf);
        $fileName = basename((string) $presupuesto->archivo_pdf);

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $fileName . '"',
        ]);
    }

    public function edit(Request $request, Presupuesto $presupuesto)
    {
        $proyectoId = $this->resolveActiveProyectoId($request);

        if ((int) $presupuesto->proyecto_id !== $proyectoId) {
            abort(404);
        }

        $clientes = Cliente::where('proyecto_id', $proyectoId)->orderBy('empresa_nombre')->get();

        if ($presupuesto->cliente && !$clientes->contains('id', $presupuesto->cliente_id)) {
            $clientes->prepend($presupuesto->cliente);
        }

        return view('presupuestos.edit', compact('presupuesto', 'clientes'));
    }

    public function update(Request $request, Presupuesto $presupuesto)
    {
        $proyectoId = $presupuesto->proyecto_id ?: $this->resolveActiveProyectoId($request);

        if ((int) $presupuesto->proyecto_id !== (int) $proyectoId) {
            abort(404);
        }

        $validated = $request->validate([
            'documento' => 'required|string|max:50',
            'numero' => 'required|string|max:50',
            'fecha' => 'required|date',
            'cliente_id' => [
                'required',
                Rule::exists('clientes', 'id')->where(fn ($query) => $query->where('proyecto_id', $proyectoId)),
            ],
            'titulo' => 'nullable|string|max:255',
            'ot' => 'nullable|string|max:255',
            'total' => 'nullable|numeric|min:0',
            'estado' => ['nullable', Rule::in(['pendiente', 'aceptado', 'rechazado', 'pendiente pedido'])],
        ]);

        $validated['proyecto_id'] = $proyectoId;
        $validated['total'] = isset($validated['total']) ? round((float) $validated['total'], 2) : (float) $presupuesto->total;
        $validated['estado'] = $validated['estado'] ?? ($presupuesto->estado ?: 'pendiente');

        $presupuesto->update($validated);
        return redirect()->route('presupuestos.index')->with('success', 'Presupuesto actualizado');
    }

    public function destroy(Presupuesto $presupuesto)
    {
        $proyectoId = $this->resolveActiveProyectoId(request());

        if ((int) $presupuesto->proyecto_id !== $proyectoId) {
            abort(404);
        }

        $presupuesto->delete();
        return redirect()->route('presupuestos.index')->with('success', 'Presupuesto eliminado');
    }
}
