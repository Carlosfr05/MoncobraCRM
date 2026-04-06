<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pedidos.index', [
            'titulo' => 'Pedidos a Proveedores',
            'breadcrumb' => 'Gestión de Pedidos'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pedidos.create', [
            'titulo' => 'Crear Nuevo Pedido',
            'breadcrumb' => 'Nuevo Pedido'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('pedidos.show', [
            'id' => $id,
            'titulo' => 'Detalle del Pedido',
            'breadcrumb' => 'Ver Pedido'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('pedidos.edit', [
            'id' => $id,
            'titulo' => 'Editar Pedido',
            'breadcrumb' => 'Editar Pedido'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
