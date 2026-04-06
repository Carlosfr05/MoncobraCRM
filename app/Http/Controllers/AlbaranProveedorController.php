<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlbaranProveedorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('albaranes-proveedores.index');
    }

    public function create()
    {
        return view('albaranes-proveedores.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('albaranes-proveedores.index')->with('success', 'Registro creado');
    }

    public function show($id)
    {
        return view('albaranes-proveedores.show');
    }

    public function edit($id)
    {
        return view('albaranes-proveedores.edit');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('albaranes-proveedores.index')->with('success', 'Registro actualizado');
    }

    public function destroy($id)
    {
        return redirect()->route('albaranes-proveedores.index')->with('success', 'Registro eliminado');
    }
}
