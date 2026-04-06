@extends('adminlte::page')

@section('title', 'Albaranes Clientes - MoncobraCRM')

@section('header-title')
    <i class="fas fa-file-alt"></i> Albaranes Clientes
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de Albaranes</h3>
            <div class="card-tools">
                <a href="{{ route('albaranes.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nuevo Albarán
                </a>
            </div>
        </div>
        <div class="card-body">
            <p class="text-muted">Módulo en desarrollo...</p>
        </div>
    </div>
@endsection