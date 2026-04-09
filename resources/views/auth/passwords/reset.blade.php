<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Restablecer Contraseña — MoncobraCRM</title>
 
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('node_modules/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <!-- Custom CSS via Vite -->
    @vite(['resources/css/reset-password.css'])
</head>
<body>
 
<div class="login-card">
 
    <!-- Logo -->
    <div class="login-logo">
        <div class="logo-icon">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
            </svg>
        </div>
        <span class="logo-text">Moncobra<span>CRM</span></span>
    </div>
 
    <!-- Cabecera -->
    <div class="form-header">
        <h1 class="form-title">Restablecer Contraseña</h1>
        <p class="form-subtitle">Introduce tu email y la nueva contraseña para reestablecerla.</p>
    </div>
 
    <!-- Formulario -->
    <form action="{{ route('password.update') }}" method="POST" novalidate>
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
 
        <div class="field-group">
 
            <!-- Email -->
            <div class="field-wrapper">
                <label class="field-label" for="email">Correo electrónico</label>
                <div class="field-input-wrap">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="custom-input @error('email') is-invalid @enderror"
                        placeholder="tu@empresa.com"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                    >
                    <span class="field-icon fas fa-envelope"></span>
                </div>
                @error('email')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>
 
            <!-- Contraseña -->
            <div class="field-wrapper">
                <label class="field-label" for="password">Nueva Contraseña</label>
                <div class="field-input-wrap">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="custom-input @error('password') is-invalid @enderror"
                        placeholder="••••••••"
                        required
                        autocomplete="new-password"
                    >
                    <span class="field-icon fas fa-lock"></span>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>
 
            <!-- Confirmación Contraseña -->
            <div class="field-wrapper">
                <label class="field-label" for="password_confirmation">Confirmar Contraseña</label>
                <div class="field-input-wrap">
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="custom-input @error('password_confirmation') is-invalid @enderror"
                        placeholder="••••••••"
                        required
                        autocomplete="new-password"
                    >
                    <span class="field-icon fas fa-lock"></span>
                </div>
                @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>
 
        </div>
 
        <!-- Botón -->
        <button type="submit" class="submit-btn">
            Restablecer Contraseña
            <span class="submit-btn-icon fas fa-check"></span>
        </button>
 
    </form>
 
    <!-- Enlace de volver al login -->
    <div class="register-wrap">
        <p>
            <a href="{{ route('login') }}" class="forgot-link">Volver al inicio de sesión</a>
        </p>
    </div>
 
</div>
 
</body>
</html>