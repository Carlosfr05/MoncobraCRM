@extends('adminlte::page')

@section('title', 'Nuevo Albarán - MoncobraCRM')

@section('content_header')
    <div class="d-flex flex-wrap justify-content-between align-items-center">
        <h1 class="mb-2 mb-md-0">Nuevo Albarán</h1>
        <a href="{{ route('albaranes.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left mr-1" aria-hidden="true"></i>
            Volver
        </a>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <strong>No se pudo crear el albarán.</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('albaranes.store') }}" method="POST" novalidate>
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="documento">Documento</label>
                        <input type="text" id="documento" name="documento" class="form-control" required value="{{ old('documento', $defaults['documento'] ?? 'ALBARAN') }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="numero">Número</label>
                        <input type="text" id="numero" name="numero" class="form-control" required value="{{ old('numero', $defaults['numero'] ?? '') }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="fecha">Fecha</label>
                        <input type="date" id="fecha" name="fecha" class="form-control" required value="{{ old('fecha', $defaults['fecha'] ?? now()->toDateString()) }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="cliente_id">Cliente</label>
                        <select id="cliente_id" name="cliente_id" class="form-control" required>
                            <option value="">Seleccione...</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ (string) old('cliente_id', $defaults['cliente_id'] ?? '') === (string) $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->empresa_nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="ot">OT</label>
                        <input type="text" id="ot" name="ot" class="form-control" value="{{ old('ot', $defaults['ot'] ?? '') }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="pedido_cliente">Pedido cliente</label>
                        <input type="text" id="pedido_cliente" name="pedido_cliente" class="form-control" value="{{ old('pedido_cliente', $defaults['pedido_cliente'] ?? '') }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="titulo">Título</label>
                        <input type="text" id="titulo" name="titulo" class="form-control" value="{{ old('titulo', $defaults['titulo'] ?? '') }}">
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1" aria-hidden="true"></i>
                        Crear albarán
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
