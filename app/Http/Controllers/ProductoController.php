<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('productos.index', [
            'titulo' => 'Productos',
            'breadcrumb' => 'Gestión de Productos'
        ]);
    }
}
