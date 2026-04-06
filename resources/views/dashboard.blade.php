@extends('adminlte::page')

@section('title', 'Panel de Control - MoncobraCRM')

@section('header-title')
    <i class="fas fa-th-large"></i> Panel de Control
@endsection

@section('content')
    <div class="row">
        <!-- Total Clientes -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalClientes ?? 0 }}</h3>
                    <p>Clientes Registrados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('clientes.index') }}" class="small-box-footer">
                    Ver más <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Total Albaranes -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalAlbaranes ?? 0 }}</h3>
                    <p>Albaranes este Mes</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <a href="{{ route('albaranes.index') }}" class="small-box-footer">
                    Ver más <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Total Presupuestos -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalPresupuestos ?? 0 }}</h3>
                    <p>Presupuestos Pendientes</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <a href="{{ route('presupuestos.index') }}" class="small-box-footer">
                    Ver más <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Total Stock Bajo -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $stockBajo ?? 0 }}</h3>
                    <p>Productos Stock Bajo</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <a href="{{ route('inventario.index') }}" class="small-box-footer">
                    Ver más <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Bienvenida -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Bienvenido a MoncobraCRM</h3>
                </div>
                <div class="card-body">
                    <p>
                        Hola <strong>{{ Auth::user()->name }}</strong>, bienvenido a MoncobraCRM. 
                        Este es tu panel de control principal donde puedes gestionar clientes, 
                        albaranes, presupuestos e inventario.
                    </p>
                    <hr>
                    <p>Accesos rápidos:</p>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('clientes.index') }}"><i class="fas fa-users"></i> Gestión de Clientes</a></li>
                        <li><a href="{{ route('albaranes.index') }}"><i class="fas fa-file-alt"></i> Albaranes Clientes</a></li>
                        <li><a href="{{ route('presupuestos.index') }}"><i class="fas fa-file-invoice-dollar"></i> Presupuestos</a></li>
                        <li><a href="{{ route('inventario.index') }}"><i class="fas fa-boxes"></i> Inventario</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
