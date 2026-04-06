<?php

namespace App\Http\Controllers;

use App\Models\Presupuesto;
use App\Models\Cliente;
use Illuminate\Http\Request;

class PresupuestoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $presupuestos = Presupuesto::with('cliente')->paginate(15);
        return view('presupuestos.index', compact('presupuestos'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        return view('presupuestos.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        Presupuesto::create($request->all());
        return redirect()->route('presupuestos.index')->with('success', 'Presupuesto creado');
    }

    public function show(Presupuesto $presupuesto)
    {
        return view('presupuestos.show', compact('presupuesto'));
    }

    public function edit(Presupuesto $presupuesto)
    {
        $clientes = Cliente::all();
        return view('presupuestos.edit', compact('presupuesto', 'clientes'));
    }

    public function update(Request $request, Presupuesto $presupuesto)
    {
        $presupuesto->update($request->all());
        return redirect()->route('presupuestos.index')->with('success', 'Presupuesto actualizado');
    }

    public function destroy(Presupuesto $presupuesto)
    {
        $presupuesto->delete();
        return redirect()->route('presupuestos.index')->with('success', 'Presupuesto eliminado');
    }
}
