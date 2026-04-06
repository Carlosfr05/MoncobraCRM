@extends('adminlte::page')

@section('title', 'Mi Perfil - MoncobraCRM')

@section('header-title')
    <i class="fas fa-user"></i> Mi Perfil
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Información del Perfil</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
                    </div>
                    <div class="form-group">
                        <label>Registrado desde</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->created_at->format('d/m/Y H:i') }}" disabled>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Editar Perfil
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Seguridad</h3>
                </div>
                <div class="card-body">
                    <p>Última sesión: <strong>{{ now()->format('d/m/Y H:i') }}</strong></p>
                    <button class="btn btn-warning btn-block" data-toggle="modal" data-target="#changePasswordModal">
                        <i class="fas fa-lock"></i> Cambiar Contraseña
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cambiar Contraseña -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cambiar Contraseña</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('profile.update-password') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Contraseña Actual</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Nueva Contraseña</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
