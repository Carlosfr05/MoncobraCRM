<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BolsaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('bolsa.index');
    }

    public function create()
    {
        return view('bolsa.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('bolsa.index')->with('success', 'Registro creado');
    }

    public function show($id)
    {
        return view('bolsa.show');
    }

    public function edit($id)
    {
        return view('bolsa.edit');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('bolsa.index')->with('success', 'Registro actualizado');
    }

    public function destroy($id)
    {
        return redirect()->route('bolsa.index')->with('success', 'Registro eliminado');
    }
}
