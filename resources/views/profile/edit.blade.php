@extends('adminlte::page')

@section('title', 'Editar Perfil - MoncobraCRM')

@push('css')
    @vite(['resources/css/show_profile.css'])
@endpush

@section('content')

<div class="profile-wrapper" style="margin: 0 auto; padding: 20px;">

    <!-- Banner superior -->
    <div class="profile-banner"></div>

    <!-- Tarjeta principal -->
    <div class="profile-card">

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Fila avatar + botones -->
            <div class="avatar-row">
                <div class="avatar-wrapper" style="position: relative; cursor: pointer;" onclick="document.getElementById('avatar-input').click();">
                    @if (Auth::user()->avatar)
                        <img
                            src="{{ asset('storage/' . Auth::user()->avatar) }}"
                            alt="{{ Auth::user()->name }}"
                            class="avatar-image"
                            id="avatar-preview"
                        >
                    @else
                        <div class="avatar-placeholder" id="avatar-preview">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}{{ strtoupper(substr(strstr(Auth::user()->name, ' '), 1, 1)) }}
                        </div>
                    @endif
                    <div style="position: absolute; bottom: 0; right: 0; background: #2563EB; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; border: 3px solid white; cursor: pointer;">
                        <i class="fas fa-camera"></i>
                    </div>
                </div>

                <input type="file" id="avatar-input" name="avatar" accept="image/*" style="display: none;" onchange="previewAvatar(this)">

                <div class="avatar-actions">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Dashboard
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </div>

            <!-- Nombre y email (editables) -->
            <div style="margin-top: 1.5rem; margin-bottom: 0.75rem;">
                <input type="text" name="name" class="form-input-inline @error('name') error @enderror"
                       value="{{ old('name', Auth::user()->name) }}" required style="width: 100%; font-size: 1.625rem; font-weight: 600; color: #0D1B36; padding: 0.5rem;">
                @error('name')
                    <div style="color: #DC2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-bottom: 1rem;">
                <input type="email" name="email" class="form-input-inline @error('email') error @enderror"
                       value="{{ old('email', Auth::user()->email) }}" required style="width: 100%; font-size: 0.9rem; color: #0D1B36; padding: 0.5rem;">
                @error('email')
                    <div style="color: #DC2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                @enderror
            </div>

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

            <!-- Información Personal Editable -->
            <div class="section-label">Información personal</div>

            <!-- Teléfono -->
            <div class="info-grid" style="margin-bottom: 1rem;">
                <div class="info-item">
                    <div class="info-label">Teléfono</div>
                    <input type="tel" name="telefono" class="form-input-inline @error('telefono') error @enderror"
                           value="{{ old('telefono', Auth::user()->telefono) }}"
                           placeholder="Ej: 956123456" style="width: 100%; border: 1px solid #E2EAF4; border-radius: 8px; padding: 0.5rem; font-size: 0.95rem; font-family: 'Plus Jakarta Sans', sans-serif;">
                    @error('telefono')
                        <div style="color: #DC2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="info-item">
                    <div class="info-label">Proyecto / Sucursal</div>
                    <div class="info-value" style="padding: 0.5rem; color: #6B7280;">
                        {{ Auth::user()->proyecto?->nombre ?? 'Acceso a todos los proyectos' }}
                    </div>
                </div>
            </div>

            <!-- Descripción (editable) -->
            <div class="section-divider"></div>
            <div class="section-label">Descripción</div>

            <textarea name="descripcion" class="description-box-input @error('descripcion') error @enderror"
                      placeholder="Breve descripción sobre ti (opcional)"
                      style="width: 100%; border: 1px solid #E2EAF4; border-radius: 8px; padding: 0.75rem; font-size: 0.95rem; font-family: 'Plus Jakarta Sans', sans-serif; resize: vertical; min-height: 80px;">{{ old('descripcion', Auth::user()->descripcion) }}</textarea>
            <div style="font-size: 0.8rem; color: #9CA3AF; margin-top: 0.5rem;">Máximo 500 caracteres</div>
            @error('descripcion')
                <div style="color: #DC2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror

            <!-- Divider -->
            <div class="section-divider"></div>

            <!-- Información de Cuenta (Solo lectura) -->
            <div class="section-label">Información de cuenta</div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Rol</div>
                    <div class="stat-value" style="font-size: 0.9rem;">
                        @if (Auth::user()->role === 'superadmin')
                            Super Administrador
                        @elseif (Auth::user()->role === 'admin')
                            Administrador
                        @else
                            Usuario
                        @endif
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Cuenta creada</div>
                    <div class="stat-value">{{ Auth::user()->created_at->format('d/m/Y H:i') }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-label">Última actualización</div>
                    <div class="stat-value">{{ Auth::user()->updated_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>

            <!-- Nota informativa -->
            <div style="margin-top: 1.5rem; padding: 1rem; background: #F0F9FF; border: 1px solid #BAE6FD; border-radius: 8px; color: #0369A1; font-size: 0.9rem;">
                <i class="fas fa-info-circle" style="margin-right: 0.5rem;"></i>
                <strong>Nota:</strong> Algunos campos como Rol y Proyecto son gestionados por un administrador.
            </div>

        </form>

    </div><!-- /.profile-card -->

</div><!-- /.profile-wrapper -->

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatar-preview');
            if (preview.tagName === 'IMG') {
                preview.src = e.target.result;
            } else {
                preview.style.backgroundImage = 'url(' + e.target.result + ')';
                preview.style.backgroundSize = 'cover';
                preview.style.backgroundPosition = 'center';
                preview.textContent = '';
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection
