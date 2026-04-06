<?php

namespace App\Http\Controllers;

use App\Models\AlbaranCliente;
use App\Models\Cliente;
use Illuminate\Http\Request;

class AlbaranClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $albaranes = AlbaranCliente::with('cliente')->paginate(15);
        return view('albaranes.index', compact('albaranes'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        return view('albaranes.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'documento' => 'required|string',
            'numero' => 'required|string',
            'fecha' => 'required|date',
            'cliente_id' => 'required|exists:clientes,id',
        ]);

        AlbaranCliente::create($request->all());
        return redirect()->route('albaranes.index')->with('success', 'Albarán creado');
    }

    public function show(AlbaranCliente $albaran)
    {
        return view('albaranes.show', compact('albaran'));
    }

    public function edit(AlbaranCliente $albaran)
    {
        $clientes = Cliente::all();
        return view('albaranes.edit', compact('albaran', 'clientes'));
    }

    public function update(Request $request, AlbaranCliente $albaran)
    {
        $albaran->update($request->all());
        return redirect()->route('albaranes.index')->with('success', 'Albarán actualizado');
    }

    public function destroy(AlbaranCliente $albaran)
    {
        $albaran->delete();
        return redirect()->route('albaranes.index')->with('success', 'Albarán eliminado');
    }
}
