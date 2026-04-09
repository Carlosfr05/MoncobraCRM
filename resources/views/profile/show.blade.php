@extends('adminlte::page')

@section('title', 'Mi Perfil - MoncobraCRM')

@push('css')
    @vite(['resources/css/show_profile.css'])
@endpush

@section('content')

<div class="profile-wrapper" style="margin: 0 auto; padding: 20px;">

    <!-- Banner superior -->
    <div class="profile-banner"></div>

    <!-- Tarjeta principal -->
    <div class="profile-card">

        <!-- Fila avatar + botones -->
        <div class="avatar-row">
            <div class="avatar-wrapper">
                @if (Auth::user()->avatar)
                    <img
                        src="{{ asset('storage/' . Auth::user()->avatar) }}"
                        alt="{{ Auth::user()->name }}"
                        class="avatar-image"
                    >
                @else
                    <div class="avatar-placeholder">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strtoupper(substr(strstr(Auth::user()->name, ' '), 1, 1)) }}
                    </div>
                @endif
            </div>

            <div class="avatar-actions">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Dashboard
                </a>
                <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                    <i class="fas fa-pen"></i> Editar perfil
                </a>
            </div>
        </div>

        <!-- Nombre y email -->
        <div class="profile-name">{{ Auth::user()->name }}</div>
        <div class="profile-email">{{ Auth::user()->email }}</div>

        <!-- Badges de rol, estado y proyecto -->
        <div class="badges-row">

            @if (Auth::user()->role === 'superadmin')
                <span class="badge badge-role-superadmin">
                    <i class="fas fa-crown" style="font-size:11px"></i> Super Admin
                </span>
            @elseif (Auth::user()->role === 'admin')
                <span class="badge badge-role-admin">
                    <i class="fas fa-user-shield" style="font-size:11px"></i> Administrador
                </span>
            @else
                <span class="badge badge-role-user">
                    <i class="fas fa-user" style="font-size:11px"></i> Usuario
                </span>
            @endif

            @if (Auth::user()->activo)
                <span class="badge badge-active">
                    <i class="fas fa-circle" style="font-size:8px"></i> Activo
                </span>
            @else
                <span class="badge badge-inactive">
                    <i class="fas fa-circle" style="font-size:8px"></i> Inactivo
                </span>
            @endif

            @if (Auth::user()->proyecto)
                <span class="badge badge-project">
                    <i class="fas fa-building" style="font-size:10px"></i>
                    {{ Auth::user()->proyecto->nombre }}
                </span>
            @endif

        </div>

        <!-- Divider -->
        <div class="section-divider"></div>

        <!-- Información Personal -->
        <div class="section-label">Información personal</div>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Nombre completo</div>
                <div class="info-value">{{ Auth::user()->name }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">Correo electrónico</div>
                <div class="info-value">{{ Auth::user()->email }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">Teléfono</div>
                @if (Auth::user()->telefono)
                    <div class="info-value">{{ Auth::user()->telefono }}</div>
                @else
                    <div class="info-value muted">No especificado</div>
                @endif
            </div>

            <div class="info-item">
                <div class="info-label">Proyecto / Sucursal</div>
                <div class="info-value">
                    {{ Auth::user()->proyecto?->nombre ?? 'Acceso a todos los proyectos' }}
                </div>
            </div>
        </div>

        <!-- Descripción (condicional) -->
        @if (Auth::user()->descripcion)
            <div class="section-divider"></div>
            <div class="section-label">Descripción</div>
            <div class="description-box">{{ Auth::user()->descripcion }}</div>
        @endif

        <!-- Divider -->
        <div class="section-divider"></div>

        <!-- Información de Cuenta -->
        <div class="section-label">Información de cuenta</div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Cuenta creada</div>
                <div class="stat-value">{{ Auth::user()->created_at->format('d/m/Y H:i') }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Última actualización</div>
                <div class="stat-value">{{ Auth::user()->updated_at->format('d/m/Y H:i') }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Último acceso</div>
                <div class="stat-value">
                    {{ Auth::user()->ultimo_acceso?->format('d/m/Y H:i') ?? 'Primera sesión' }}
                </div>
            </div>
        </div>

    </div><!-- /.profile-card -->

</div><!-- /.profile-wrapper -->

@endsection
