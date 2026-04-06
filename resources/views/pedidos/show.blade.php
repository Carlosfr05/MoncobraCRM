@extends('adminlte::page')

@section('title', 'Detalle del Pedido - MoncobraCRM')

@section('header-title')
    <i class="fas fa-file-invoice-dollar"></i> Detalle del Pedido
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Información del Pedido</h3>
                <div class="card-tools">
                    <a href="{{ route('pedidos.edit', $id) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a href="{{ route('pedidos.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted">Número de Pedido</h6>
                        <p>-</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Fecha</h6>
                        <p>-</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted">Proveedor</h6>
                        <p>-</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Estado</h6>
                        <p><span class="badge badge-secondary">Pendiente</span></p>
                    </div>
                </div>
                <hr>
                <h6 class="text-muted">Descripción</h6>
                <p>-</p>
            </div>
        </div>
    </div>
</div>
@endsection
