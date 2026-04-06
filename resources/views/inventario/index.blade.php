@extends('adminlte::page')

@section('title', 'Inventario - MoncobraCRM')

@section('header-title')
    <i class="fas fa-boxes"></i> Inventario
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Gestión de Inventario</h3>
            <div class="card-tools">
                <a href="{{ route('inventario.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nuevo Producto
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Stock Actual</th>
                            <th>Stock Mínimo</th>
                            <th>Almacén</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($inventarios as $producto)
                            <tr class="{{ $producto->stock_actual <= $producto->stock_minimo ? 'table-warning' : '' }}">
                                <td>{{ $producto->codigo }}</td>
                                <td>{{ $producto->descripcion }}</td>
                                <td>{{ $producto->stock_actual }}</td>
                                <td>{{ $producto->stock_minimo }}</td>
                                <td>{{ $producto->almacen }}</td>
                                <td>
                                    <a href="{{ route('inventario.show', $producto->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('inventario.edit', $producto->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No hay productos en inventario</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection