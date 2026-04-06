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
        $inventarios = Inventario::paginate(15);
        return view('inventario.index', compact('inventarios'));
    }

    public function create()
    {
        return view('inventario.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|unique:inventario,codigo',
            'descripcion' => 'required|string',
            'stock_actual' => 'required|integer|min:0',
            'stock_minimo' => 'nullable|integer|min:0',
            'nivel_critico' => 'nullable|integer|min:0',
        ]);

        Inventario::create($request->all());
        return redirect()->route('inventario.index')->with('success', 'Producto creado');
    }

    public function show(Inventario $inventario)
    {
        return view('inventario.show', compact('inventario'));
    }

    public function edit(Inventario $inventario)
    {
        return view('inventario.edit', compact('inventario'));
    }

    public function update(Request $request, Inventario $inventario)
    {
        $inventario->update($request->all());
        return redirect()->route('inventario.index')->with('success', 'Producto actualizado');
    }

    public function destroy(Inventario $inventario)
    {
        $inventario->delete();
        return redirect()->route('inventario.index')->with('success', 'Producto eliminado');
    }
}
