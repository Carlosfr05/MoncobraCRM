@extends('adminlte::page')

@section('title', 'Proveedores - MoncobraCRM')

@section('header-title')
    <i class="fas fa-building"></i> Gestión de Proveedores
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de Proveedores</h3>
            <div class="card-tools">
                <a href="{{ route('proveedores.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nuevo Proveedor
                </a>
            </div>
        </div>
        <div class="card-body">
            <p class="text-muted">Módulo en desarrollo...</p>
        </div>
    </div>
@endsection