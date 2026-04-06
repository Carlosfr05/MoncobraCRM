@extends('adminlte::page')

@section('title', 'Editar Pedido - MoncobraCRM')

@section('header-title')
    <i class="fas fa-edit"></i> Editar Pedido
@endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Formulario de Edición de Pedido</h3>
            </div>
            <form method="POST" action="{{ route('pedidos.update', $id) }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="numero">Número de Pedido</label>
                        <input type="text" class="form-control @error('numero') is-invalid @enderror" 
                               id="numero" name="numero" required>
                        @error('numero')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="proveedor_id">Proveedor</label>
                        <select class="form-control @error('proveedor_id') is-invalid @enderror" 
                                id="proveedor_id" name="proveedor_id" required>
                            <option value="">Seleccionar proveedor...</option>
                        </select>
                        @error('proveedor_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <input type="date" class="form-control @error('fecha') is-invalid @enderror" 
                               id="fecha" name="fecha" required>
                        @error('fecha')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                  id="descripcion" name="descripcion" rows="4"></textarea>
                        @error('descripcion')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Actualizar Pedido
                    </button>
                    <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
