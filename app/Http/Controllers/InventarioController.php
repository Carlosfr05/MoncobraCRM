<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $proyectoId = $this->resolveActiveProyectoId(request());
        $inventarios = Inventario::where('proyecto_id', $proyectoId)->paginate(15);

        return view('inventario.index', compact('inventarios'));
    }

    public function create()
    {
        return view('inventario.create');
    }

    public function store(Request $request)
    {
        $proyectoId = $this->resolveActiveProyectoId($request);

        $validated = $request->validate([
            'codigo' => 'required|unique:inventario,codigo',
            'descripcion' => 'required|string',
            'referencia_proveedor' => 'nullable|string|max:255',
            'clase' => 'nullable|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'almacen' => 'nullable|string|max:255',
            'stock_actual' => 'required|integer|min:0',
            'stock_minimo' => 'nullable|integer|min:0',
            'nivel_critico' => 'nullable|integer|min:0',
        ]);

        $validated['proyecto_id'] = $proyectoId;

        Inventario::create($validated);
        return redirect()->route('inventario.index')->with('success', 'Producto creado');
    }

    public function show(Inventario $inventario)
    {
        $proyectoId = $this->resolveActiveProyectoId(request());

        if ((int) $inventario->proyecto_id !== $proyectoId) {
            abort(404);
        }

        return view('inventario.show', compact('inventario'));
    }

    public function edit(Inventario $inventario)
    {
        $proyectoId = $this->resolveActiveProyectoId(request());

        if ((int) $inventario->proyecto_id !== $proyectoId) {
            abort(404);
        }

        return view('inventario.edit', compact('inventario'));
    }

    public function update(Request $request, Inventario $inventario)
    {
        $proyectoId = $this->resolveActiveProyectoId($request);

        if ((int) $inventario->proyecto_id !== $proyectoId) {
            abort(404);
        }

        $validated = $request->validate([
            'codigo' => 'required|unique:inventario,codigo,' . $inventario->id,
            'descripcion' => 'required|string',
            'referencia_proveedor' => 'nullable|string|max:255',
            'clase' => 'nullable|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'almacen' => 'nullable|string|max:255',
            'stock_actual' => 'required|integer|min:0',
            'stock_minimo' => 'nullable|integer|min:0',
            'nivel_critico' => 'nullable|integer|min:0',
        ]);

        $inventario->update($validated);
        return redirect()->route('inventario.index')->with('success', 'Producto actualizado');
    }

    public function destroy(Inventario $inventario)
    {
        $proyectoId = $this->resolveActiveProyectoId(request());

        if ((int) $inventario->proyecto_id !== $proyectoId) {
            abort(404);
        }

        $inventario->delete();
        return redirect()->route('inventario.index')->with('success', 'Producto eliminado');
    }
}
