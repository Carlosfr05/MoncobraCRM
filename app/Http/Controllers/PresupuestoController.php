<?php

namespace App\Http\Controllers;

use App\Models\Presupuesto;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PresupuestoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $proyectoId = $this->resolveActiveProyectoId(request());
        $presupuestos = Presupuesto::with('cliente')
            ->where('proyecto_id', $proyectoId)
            ->paginate(15);

        return view('presupuestos.index', compact('presupuestos'));
    }

    public function create(Request $request)
    {
        $proyectoId = $this->resolveActiveProyectoId($request);
        $clientes = Cliente::where('proyecto_id', $proyectoId)->orderBy('empresa_nombre')->get();

        return view('presupuestos.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $proyectoId = $this->resolveActiveProyectoId($request);

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
        ]);

        $validated['proyecto_id'] = $proyectoId;

        Presupuesto::create($validated);
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
        ]);

        $validated['proyecto_id'] = $proyectoId;

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
