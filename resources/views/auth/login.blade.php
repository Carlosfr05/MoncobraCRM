<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar Sesión — MoncobraCRM</title>
 
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('node_modules/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <!-- Custom CSS via Vite -->
    @vite(['resources/css/login.css'])
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
        <h1 class="form-title">Bienvenido de vuelta</h1>
        <p class="form-subtitle">Introduce tus credenciales para continuar.</p>
    </div>
 
    <!-- Formulario -->
    <form action="{{ route('login') }}" method="POST" novalidate>
        @csrf
 
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
                <label class="field-label" for="password">Contraseña</label>
                <div class="field-input-wrap">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="custom-input @error('password') is-invalid @enderror"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                    >
                    <span class="field-icon fas fa-lock"></span>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>
 
        </div>
 
        <!-- Recuérdame + ¿Olvidaste? -->
        <div class="form-options">
            <label class="remember-wrap">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <span class="remember-label">Recuérdame</span>
            </label>
            <a href="{{ route('password.request') }}" class="forgot-link">¿Olvidaste tu contraseña?</a>
        </div>
 
        <!-- Botón -->
        <button type="submit" class="submit-btn">
            Iniciar sesión
            <span class="submit-btn-icon fas fa-arrow-right"></span>
        </button>
 
    </form>
</div>
 
</body>
</html>
