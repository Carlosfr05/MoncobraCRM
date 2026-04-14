@extends('adminlte::page')

@section('title', 'Crear Usuario')

@section('css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/usuarios-create.css'])
@endsection

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Crear Usuario</h1>
            <p class="page-subtitle">Alta de nuevo personal en el sistema.</p>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Panel de Usuarios</a></li>
                <li class="breadcrumb-item active">Crear</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="usuarios-create-page">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Datos del Nuevo Usuario</h3>
                    </div>

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Contraseña</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                        @error('password')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirmar Contraseña</label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="role">Rol</label>
                                <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                                    <option value="user" {{ old('role', 'user') === 'user' ? 'selected' : '' }}>Usuario</option>
                                    <option value="admin" {{ old('role', 'user') === 'admin' ? 'selected' : '' }}>Admin</option>
                                    @if(auth()->user()->role === 'superadmin')
                                        <option value="superadmin" {{ old('role', 'user') === 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                                    @endif
                                </select>
                                @error('role')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">Si eliges rol Usuario, debes asignar al menos un proyecto.</small>
                            </div>

                            <div class="form-group">
                                <label for="proyecto_ids">Proyectos asignados</label>
                                <div class="project-selector @error('proyecto_ids') is-invalid @enderror @error('proyecto_ids.*') is-invalid @enderror">
                                    <div class="project-selector-header">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="select-all-proyectos">
                                            <label class="custom-control-label" for="select-all-proyectos">Seleccionar todos</label>
                                        </div>
                                    </div>

                                    <div class="project-options">
                                        @foreach($proyectos as $proyecto)
                                            <label class="project-option" for="proyecto_{{ $proyecto->id }}">
                                                <input
                                                    type="checkbox"
                                                    id="proyecto_{{ $proyecto->id }}"
                                                    name="proyecto_ids[]"
                                                    value="{{ $proyecto->id }}"
                                                    {{ in_array($proyecto->id, old('proyecto_ids', [])) ? 'checked' : '' }}
                                                >
                                                <span>{{ $proyecto->nombre }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                @error('proyecto_ids')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                @error('proyecto_ids.*')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="form-text text-muted">Puedes seleccionar uno, varios o todos los proyectos.</small>
                            </div>

                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="text" class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" value="{{ old('telefono') }}">
                                @error('telefono')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="activo" name="activo" value="1" {{ old('activo', 1) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="activo">Usuario activo</label>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                            <button type="submit" class="btn btn-primary float-right">
                                <i class="fas fa-save"></i> Guardar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Ayuda rápida</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Roles:</strong></p>
                        <ul class="mb-3">
                            <li><strong>Usuario:</strong> Operativa diaria.</li>
                            <li><strong>Admin:</strong> Gestión operativa y usuarios.</li>
                            <li><strong>Super Admin:</strong> Control total.</li>
                        </ul>
                        <p><strong>Proyectos:</strong></p>
                        <p class="mb-0">Si no asignas proyectos, el usuario tendrá acceso general.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        (function () {
            const selectAll = document.getElementById('select-all-proyectos');
            const projectCheckboxes = Array.from(document.querySelectorAll('input[name="proyecto_ids[]"]'));

            if (!selectAll || projectCheckboxes.length === 0) {
                return;
            }

            const syncSelectAll = () => {
                selectAll.checked = projectCheckboxes.every(checkbox => checkbox.checked);
                selectAll.indeterminate = !selectAll.checked && projectCheckboxes.some(checkbox => checkbox.checked);
            };

            selectAll.addEventListener('change', function () {
                projectCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                syncSelectAll();
            });

            projectCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', syncSelectAll);
            });

            syncSelectAll();
        })();
    </script>
@endsection