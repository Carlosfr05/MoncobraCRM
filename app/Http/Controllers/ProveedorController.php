<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('proveedores.index');
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('proveedores.index')->with('success', 'Proveedor creado');
    }

    public function show($id)
    {
        return view('proveedores.show');
    }

    public function edit($id)
    {
        return view('proveedores.edit');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado');
    }

    public function destroy($id)
    {
        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado');
    }
}
