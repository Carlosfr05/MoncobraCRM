<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AlbaranClienteController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\BolsaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\AlbaranProveedorController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\HistoricoController;

// 1. CAMBIO: Nombre de ruta único para la página de bienvenida.
// Antes se llamaba 'dashboard', ahora 'welcome'.
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Authentication Routes
Auth::routes();

// Protected Routes (Require Authentication)
Route::middleware('auth')->group(function () {
    
    // 2. Dashboard Real
    // Esta es la ruta a la que apunta el RouteServiceProvider que cambiamos antes.
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/change-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    
    // Recursos CRUD
    Route::resource('clientes', ClienteController::class);
    Route::resource('albaranes', AlbaranClienteController::class);
    Route::resource('presupuestos', PresupuestoController::class);
    Route::resource('bolsa', BolsaController::class);
    Route::resource('proveedores', ProveedorController::class);
    Route::resource('albaranes-proveedores', AlbaranProveedorController::class);
    Route::resource('pedidos', PedidoController::class);
    
    // Nota: 'only' limita las rutas generadas para optimizar el sistema.
    Route::resource('productos', ProductoController::class)->only(['index']);
    Route::resource('inventario', InventarioController::class);
    Route::resource('historico', HistoricoController::class)->only(['index']);
    
});