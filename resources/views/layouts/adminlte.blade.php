<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MoncobraCRM')</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('node_modules/admin-lte/dist/css/adminlte.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('node_modules/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('node_modules/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    @yield('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- User Account Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-user-circle"></i>
                        <span>{{ Auth::user()->name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{ route('profile.show') }}" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i> Mi Perfil
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}" class="dropdown-item"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Left side column. contains the sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('dashboard') }}" class="brand-link">
                <img src="https://via.placeholder.com/40" alt="MoncobraCRM Logo" class="brand-image img-circle elevation-3"
                     style="opacity: 0.8">
                <span class="brand-text font-weight-light">MoncobraCRM</span>
            </a>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Panel de Control (Dashboard) -->
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-th-large"></i>
                            <p>Panel de Control</p>
                        </a>
                    </li>

                    <!-- Área Clientes -->
                    <li class="nav-item {{ request()->is('clientes*', 'albaranes*', 'presupuestos*', 'bolsa*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('clientes*', 'albaranes*', 'presupuestos*', 'bolsa*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Área Clientes
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('clientes.index') }}" class="nav-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Gestión Clientes</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('albaranes.index') }}" class="nav-link {{ request()->routeIs('albaranes.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Albaranes Clientes</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('presupuestos.index') }}" class="nav-link {{ request()->routeIs('presupuestos.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Presupuestos</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('bolsa.index') }}" class="nav-link {{ request()->routeIs('bolsa.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Bolsa Clientes</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Área Proveedores -->
                    <li class="nav-item {{ request()->is('proveedores*', 'albaranes-proveedores*', 'pedidos*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('proveedores*', 'albaranes-proveedores*', 'pedidos*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-building"></i>
                            <p>
                                Área Proveedores
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('proveedores.index') }}" class="nav-link {{ request()->routeIs('proveedores.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Gestión de Proveedores</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('albaranes-proveedores.index') }}" class="nav-link {{ request()->routeIs('albaranes-proveedores.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Albaranes de Proveedores</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('pedidos.index') }}" class="nav-link {{ request()->routeIs('pedidos.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Pedidos</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Productos -->
                    <li class="nav-item">
                        <a href="{{ route('productos.index') }}" class="nav-link {{ request()->routeIs('productos.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-boxes"></i>
                            <p>Productos</p>
                        </a>
                    </li>

                    <!-- Histórico -->
                    <li class="nav-item">
                        <a href="{{ route('historico.index') }}" class="nav-link {{ request()->routeIs('historico.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-history"></i>
                            <p>Histórico</p>
                        </a>
                    </li>

                    <!-- Inventario -->
                    <li class="nav-item">
                        <a href="{{ route('inventario.index') }}" class="nav-link {{ request()->routeIs('inventario.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-warehouse"></i>
                            <p>Inventario</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('header-title')</h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error:</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                <b>Version</b> 1.0.0
            </div>
            <strong>MoncobraCRM</strong> &copy; 2026. Todos los derechos reservados.
        </footer>
    </div>

    <!-- AdminLTE JS -->
    <script src="{{ asset('node_modules/admin-lte/dist/js/adminlte.min.js') }}"></script>
    <!-- jQuery -->
    <script src="{{ asset('node_modules/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('node_modules/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Font Awesome (si lo necesitas para más iconos) -->
    <script src="{{ asset('node_modules/@fortawesome/fontawesome-free/js/all.min.js') }}"></script>

    @yield('scripts')
</body>
</html>
