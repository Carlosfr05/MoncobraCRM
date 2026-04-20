<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
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
        $clientes = Cliente::where('proyecto_id', $proyectoId)->paginate(15);

        return view('clientes.index', compact('clientes'));
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

        return view('clientes.show', compact('cliente'));
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
