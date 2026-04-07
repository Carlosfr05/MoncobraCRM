<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registro — MoncobraCRM</title>
 
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('node_modules/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <!-- Custom CSS via Vite -->
    @vite(['resources/css/register.css'])
</head>
<body>
<div class="register-card">
 
    <!-- Logo -->
    <div class="register-logo">
        <div class="logo-icon">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
            </svg>
        </div>
        <span class="logo-text">Moncobra<span>CRM</span></span>
    </div>
 
    <!-- Cabecera -->
    <div class="form-header">
        <h1 class="form-title">Crear una cuenta</h1>
        <p class="form-subtitle">Únete a MoncobraCRM hoy mismo.</p>
    </div>
 
    <!-- Formulario -->
    <form action="{{ route('register') }}" method="POST" novalidate>
        @csrf
 
        <div class="field-group">
 
            <!-- Nombre -->
            <div class="field-wrapper">
                <label class="field-label" for="name">Nombre completo</label>
                <div class="field-input-wrap">
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="custom-input @error('name') is-invalid @enderror"
                        placeholder="Juan Pérez"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name"
                    >
                    <span class="field-icon fas fa-user"></span>
                </div>
                @error('name')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>
 
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
                <label class="field-label" for="password">Contraseña</label>
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
 
            <!-- Confirmar Contraseña -->
            <div class="field-wrapper">
                <label class="field-label" for="password_confirmation">Confirmar contraseña</label>
                <div class="field-input-wrap">
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="custom-input"
                        placeholder="••••••••"
                        required
                        autocomplete="new-password"
                    >
                    <span class="field-icon fas fa-lock"></span>
                </div>
            </div>
 
        </div>
 
        <!-- Aceptar términos -->
        <div class="terms-wrap">
            <label class="terms-check">
                <input type="checkbox" name="terms" id="terms" required>
                <span class="terms-label">Acepto los <a href="#" class="terms-link">términos de servicio</a> y la <a href="#" class="terms-link">política de privacidad</a></span>
            </label>
            @error('terms')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>
 
        <!-- Botón -->
        <button type="submit" class="submit-btn">
            Crear cuenta
            <span class="submit-btn-icon fas fa-arrow-right"></span>
        </button>
 
    </form>
 
    <!-- Divider + Login -->
    <div class="form-divider">
        <div class="form-divider-line"></div>
        <span class="form-divider-text">¿Ya tienes cuenta?</span>
        <div class="form-divider-line"></div>
    </div>
 
    <div class="login-wrap">
        <p>
            <a href="{{ route('login') }}" class="login-link">Inicia sesión aquí →</a>
        </p>
    </div>
 
</div>

</body>
</html>