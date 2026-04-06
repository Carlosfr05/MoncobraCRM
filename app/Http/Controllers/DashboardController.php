<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\AlbaranCliente;
use App\Models\Presupuesto;
use App\Models\Inventario;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $totalClientes = Cliente::count();
        $totalAlbaranes = AlbaranCliente::whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->count();
        $totalPresupuestos = Presupuesto::where('created_at', '>=', now()->subDays(30))->count();
        $stockBajo = Inventario::whereRaw('stock_actual <= stock_minimo')->count();

        return view('dashboard', [
            'totalClientes' => $totalClientes,
            'totalAlbaranes' => $totalAlbaranes,
            'totalPresupuestos' => $totalPresupuestos,
            'stockBajo' => $stockBajo,
        ]);
    }
}
