@extends('adminlte::page')

@section('title', 'Gestión de Clientes - MoncobraCRM')

@section('header-title')
    <i class="fas fa-users"></i> Gestión de Clientes
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de Clientes</h3>
            <div class="card-tools">
                <a href="{{ route('clientes.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nuevo Cliente
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Empresa</th>
                            <th>CIF/NIF</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Localidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente->empresa_nombre }}</td>
                                <td>{{ $cliente->cif_nif }}</td>
                                <td>{{ $cliente->email }}</td>
                                <td>{{ $cliente->telefono }}</td>
                                <td>{{ $cliente->localidad }}</td>
                                <td>
                                    <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No hay clientes registrados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
