@extends('adminlte::page')

@section('title', 'Panel de Usuarios')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Panel de Usuarios</h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Éxito:</strong> {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error:</strong> {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Gestión de Usuarios del Sistema</h3>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-primary">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Proyecto</th>
                                    <th>Teléfono</th>
                                    <th>Estado</th>
                                    <th width="200">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>
                                            <strong>{{ $user->name }}</strong>
                                            @if(auth()->id() === $user->id)
                                                <span class="badge badge-secondary ml-2">Tú</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->role === 'superadmin')
                                                <span class="badge badge-danger">Super Admin</span>
                                            @elseif($user->role === 'admin')
                                                <span class="badge badge-warning">Admin</span>
                                            @else
                                                <span class="badge badge-info">Usuario</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->proyecto)
                                                <small>{{ $user->proyecto->nombre }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->telefono ?? '-' }}</td>
                                        <td>
                                            @if($user->activo)
                                                <span class="badge badge-success">Activo</span>
                                            @else
                                                <span class="badge badge-secondary">Inactivo</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(auth()->id() !== $user->id)
                                                @can('edit-user', $user)
                                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-info" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @else
                                                    <button class="btn btn-sm btn-secondary disabled" title="No puedes editar este usuario">
                                                        <i class="fas fa-lock"></i>
                                                    </button>
                                                @endcan
                                                
                                                @can('edit-user', $user)
                                                    <button class="btn btn-sm btn-warning toggle-active-btn" data-user-id="{{ $user->id }}" title="Cambiar estado">
                                                        <i class="fas fa-power-off"></i>
                                                    </button>
                                                @endif
                                                
                                                @can('delete-user', $user)
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Estás seguro?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            @else
                                                <span class="text-muted">Perfil Personal</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            No hay usuarios disponibles.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($users->hasPages())
                        <div class="mt-3">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.querySelectorAll('.toggle-active-btn').forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.dataset.userId;
                const button = this;

                if (!confirm('¿Cambiar el estado de este usuario?')) {
                    return;
                }

                fetch(`/users/${userId}/toggle-active`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Recargar la página
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al cambiar el estado del usuario.');
                });
            });
        });
    </script>
@endsection
