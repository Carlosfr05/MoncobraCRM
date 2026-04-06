@extends('adminlte::page')

@section('title', 'Presupuestos - MoncobraCRM')

@section('header-title')
    <i class="fas fa-file-invoice-dollar"></i> Presupuestos
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de Presupuestos</h3>
            <div class="card-tools">
                <a href="{{ route('presupuestos.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nuevo Presupuesto
                </a>
            </div>
        </div>
        <div class="card-body">
            <p class="text-muted">Módulo en desarrollo...</p>
        </div>
    </div>
@endsection