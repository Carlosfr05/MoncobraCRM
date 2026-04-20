<?php

namespace App\Http\Controllers;

use App\Models\AlbaranCliente;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AlbaranClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $proyectoId = $this->resolveActiveProyectoId(request());
        $albaranes = AlbaranCliente::with('cliente')
            ->where('proyecto_id', $proyectoId)
            ->paginate(15);

        return view('albaranes.index', compact('albaranes'));
    }

    public function create(Request $request)
    {
        $proyectoId = $this->resolveActiveProyectoId($request);
        $clientes = Cliente::where('proyecto_id', $proyectoId)->orderBy('empresa_nombre')->get();

        return view('albaranes.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $proyectoId = $this->resolveActiveProyectoId($request);

        $validated = $request->validate([
            'documento' => 'required|string',
            'numero' => 'required|string',
            'fecha' => 'required|date',
            'cliente_id' => [
                'required',
                Rule::exists('clientes', 'id')->where(fn ($query) => $query->where('proyecto_id', $proyectoId)),
            ],
            'ot' => 'nullable|string|max:255',
            'pedido_cliente' => 'nullable|string|max:255',
            'titulo' => 'nullable|string|max:255',
        ]);

        $validated['proyecto_id'] = $proyectoId;

        AlbaranCliente::create($validated);
        return redirect()->route('albaranes.index')->with('success', 'Albarán creado');
    }

    public function show(AlbaranCliente $albaran)
    {
        $proyectoId = $this->resolveActiveProyectoId(request());

        if ((int) $albaran->proyecto_id !== $proyectoId) {
            abort(404);
        }

        return view('albaranes.show', compact('albaran'));
    }

    public function edit(Request $request, AlbaranCliente $albaran)
    {
        $proyectoId = $this->resolveActiveProyectoId($request);

        if ((int) $albaran->proyecto_id !== $proyectoId) {
            abort(404);
        }

        $clientes = Cliente::where('proyecto_id', $proyectoId)->orderBy('empresa_nombre')->get();

        if ($albaran->cliente && !$clientes->contains('id', $albaran->cliente_id)) {
            $clientes->prepend($albaran->cliente);
        }

        return view('albaranes.edit', compact('albaran', 'clientes'));
    }

    public function update(Request $request, AlbaranCliente $albaran)
    {
        $proyectoId = $albaran->proyecto_id ?: $this->resolveActiveProyectoId($request);

        if ((int) $albaran->proyecto_id !== (int) $proyectoId) {
            abort(404);
        }

        $validated = $request->validate([
            'documento' => 'required|string',
            'numero' => 'required|string',
            'fecha' => 'required|date',
            'cliente_id' => [
                'required',
                Rule::exists('clientes', 'id')->where(fn ($query) => $query->where('proyecto_id', $proyectoId)),
            ],
            'ot' => 'nullable|string|max:255',
            'pedido_cliente' => 'nullable|string|max:255',
            'titulo' => 'nullable|string|max:255',
        ]);

        $validated['proyecto_id'] = $proyectoId;

        $albaran->update($validated);
        return redirect()->route('albaranes.index')->with('success', 'Albarán actualizado');
    }

    public function destroy(AlbaranCliente $albaran)
    {
        $proyectoId = $this->resolveActiveProyectoId(request());

        if ((int) $albaran->proyecto_id !== $proyectoId) {
            abort(404);
        }

        $albaran->delete();
        return redirect()->route('albaranes.index')->with('success', 'Albarán eliminado');
    }
}
