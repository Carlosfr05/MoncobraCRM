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
use App\Http\Controllers\UserController;
use App\Http\Controllers\GestionProyectoController;
use App\Http\Controllers\ProyectoContextController;

// 1. CAMBIO: Nombre de ruta único para la página de bienvenida.
// Antes se llamaba 'dashboard', ahora 'welcome'.
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Authentication Routes
Auth::routes(['register' => false]);

// Protected Routes (Require Authentication)
Route::middleware('auth')->group(function () {
    
    // 2. Dashboard Real
    // Esta es la ruta a la que apunta el RouteServiceProvider que cambiamos antes.
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/panel-order', [DashboardController::class, 'updatePanelOrder'])->name('dashboard.panel-order.update');
    Route::get('/proyectos/{proyecto}/seleccionar', [ProyectoContextController::class, 'seleccionar'])
        ->name('proyectos.seleccionar');
    Route::get('/herramientas/gestion-proyectos', [GestionProyectoController::class, 'index'])
        ->middleware('can:manage-projects')
        ->name('herramientas.proyectos.index');
    Route::get('/herramientas/gestion-proyectos/crear', [GestionProyectoController::class, 'create'])
        ->middleware('can:manage-projects')
        ->name('herramientas.proyectos.create');
    Route::get('/herramientas/gestion-proyectos/{proyecto}/editar', [GestionProyectoController::class, 'edit'])
        ->middleware('can:manage-projects')
        ->name('herramientas.proyectos.edit');
    Route::get('/herramientas/gestion-proyectos/{proyecto}', [GestionProyectoController::class, 'show'])
        ->middleware('can:manage-projects')
        ->name('herramientas.proyectos.show');
    Route::post('/herramientas/gestion-proyectos', [GestionProyectoController::class, 'store'])
        ->middleware('can:manage-projects')
        ->name('herramientas.proyectos.store');
    Route::put('/herramientas/gestion-proyectos/{proyecto}', [GestionProyectoController::class, 'update'])
        ->middleware('can:manage-projects')
        ->name('herramientas.proyectos.update');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/change-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    
    // Recursos CRUD
    Route::resource('clientes', ClienteController::class);
    Route::get('albaranes/{albaran}/pdf', [AlbaranClienteController::class, 'pdfViewer'])->name('albaranes.pdf');
    Route::get('albaranes/{albaran}/pdf/file', [AlbaranClienteController::class, 'streamPdf'])->name('albaranes.pdf.file');
    Route::patch('albaranes/{albaran}/estado', [AlbaranClienteController::class, 'updateEstado'])->name('albaranes.estado.update');
    Route::resource('albaranes', AlbaranClienteController::class);
    Route::get('presupuestos/{presupuesto}/pdf', [PresupuestoController::class, 'viewPdf'])->name('presupuestos.pdf');
    Route::resource('presupuestos', PresupuestoController::class);
    Route::resource('bolsa', BolsaController::class);
    Route::resource('proveedores', ProveedorController::class);
    Route::resource('albaranes-proveedores', AlbaranProveedorController::class);
    Route::resource('pedidos', PedidoController::class);
    Route::get('pedidos-clientes/{pedidoCliente}', [PedidoController::class, 'showCliente'])->name('pedidos-clientes.show');
    
    // Nota: 'only' limita las rutas generadas para optimizar el sistema.
    Route::resource('productos', ProductoController::class)->only(['index']);
    Route::resource('inventario', InventarioController::class);
    Route::resource('historico', HistoricoController::class)->only(['index']);
    
    // Gestión de Usuarios (Solo admin y superadmin)
    Route::resource('users', UserController::class);
    Route::post('users/{user}/change-role', [UserController::class, 'changeRole'])->name('users.changeRole');
    Route::post('users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggleActive');
    
});