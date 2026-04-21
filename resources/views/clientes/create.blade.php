@extends('adminlte::page')

@section('title', 'Nuevo Cliente - MoncobraCRM')

@section('content')
    <section class="cliente-create-ui">
        <header class="cliente-create-topbar">
            <nav aria-label="breadcrumb" class="cliente-breadcrumbs">
                <a href="{{ route('dashboard') }}">Inicio</a>
                <span><i class="fas fa-chevron-right" aria-hidden="true"></i></span>
                <a href="{{ route('clientes.index') }}">Clientes</a>
                <span><i class="fas fa-chevron-right" aria-hidden="true"></i></span>
                <strong>Nuevo Cliente</strong>
            </nav>
            <div class="cliente-top-actions">
                <button type="button" aria-label="Notificaciones"><i class="far fa-bell"></i></button>
                <button type="button" aria-label="Ayuda"><i class="far fa-question-circle"></i></button>
            </div>
        </header>

        <section class="cliente-page-head">
            <h1>Añadir Nuevo Cliente</h1>
            <p>Complete los datos de contacto y facturación para registrar una nueva entidad en el sistema.</p>
        </section>

        @if ($errors->any())
            <div class="alert alert-danger cliente-errors" role="alert">
                <strong>No se pudo guardar el cliente.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <article class="cliente-create-card">
            <header>
                <i class="fas fa-building" aria-hidden="true"></i>
                <h2>Información de la Empresa</h2>
            </header>

            <form action="{{ route('clientes.store') }}" method="POST" novalidate>
                @csrf

                <div class="cliente-form-grid empresa-grid">
                    <div class="field-group field-lg">
                        <label for="empresa_nombre">Nombre de la Empresa</label>
                        <input type="text" id="empresa_nombre" name="empresa_nombre" value="{{ old('empresa_nombre') }}" placeholder="Ej: Aladdin Software S.L." class="@error('empresa_nombre') is-invalid @enderror" required>
                    </div>

                    <div class="field-group field-sm">
                        <label for="cif_nif">CIF / NIF</label>
                        <input type="text" id="cif_nif" name="cif_nif" value="{{ old('cif_nif') }}" placeholder="B12345678" class="@error('cif_nif') is-invalid @enderror" required>
                    </div>

                    <div class="field-group field-full">
                        <label for="direccion">Dirección</label>
                        <input type="text" id="direccion" name="direccion" value="{{ old('direccion') }}" placeholder="Calle, número, piso, oficina..." class="@error('direccion') is-invalid @enderror" required>
                    </div>

                    <div class="field-group field-md">
                        <label for="localidad">Localidad</label>
                        <input type="text" id="localidad" name="localidad" value="{{ old('localidad') }}" placeholder="Madrid" class="@error('localidad') is-invalid @enderror" required>
                    </div>

                    <div class="field-group field-md">
                        <label for="codigo_postal">Código Postal</label>
                        <input type="text" id="codigo_postal" name="codigo_postal" value="{{ old('codigo_postal') }}" placeholder="28001" class="@error('codigo_postal') is-invalid @enderror" required>
                    </div>
                </div>

                <section class="contacto-section">
                    <h3>
                        <i class="far fa-id-card" aria-hidden="true"></i>
                        Contacto Principal
                    </h3>

                    <div class="cliente-form-grid contacto-grid">
                        <div class="field-group with-icon">
                            <label for="telefono">Teléfono</label>
                            <div class="input-icon-wrap">
                                <i class="fas fa-phone-alt" aria-hidden="true"></i>
                                <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}" placeholder="+34 900 000 000" class="@error('telefono') is-invalid @enderror">
                            </div>
                        </div>

                        <div class="field-group with-icon">
                            <label for="email">Email</label>
                            <div class="input-icon-wrap">
                                <i class="far fa-envelope" aria-hidden="true"></i>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="contacto@empresa.com" class="@error('email') is-invalid @enderror">
                            </div>
                        </div>

                        <div class="field-group with-icon">
                            <label for="persona_contacto">Persona de Contacto</label>
                            <div class="input-icon-wrap">
                                <i class="far fa-user" aria-hidden="true"></i>
                                <input type="text" id="persona_contacto" name="persona_contacto" value="{{ old('persona_contacto') }}" placeholder="Nombre completo" class="@error('persona_contacto') is-invalid @enderror">
                            </div>
                        </div>
                    </div>
                </section>

                <footer class="cliente-form-actions">
                    <a href="{{ route('clientes.index') }}" class="btn-cancelar">Cancelar</a>
                    <button type="submit" class="btn-guardar">Guardar</button>
                </footer>
            </form>
        </article>

        <footer class="cliente-bottom-note">
            © 2024 ALADDIN 2.0 · Sistema de Gestión Empresarial Avanzado
        </footer>
    </section>
@endsection

@section('css')
    <style>
        .content-wrapper {
            background: #f3f6fb;
        }

        .cliente-create-ui {
            max-width: 980px;
            margin: 0 auto;
            color: #223248;
            font-family: "Segoe UI", "Source Sans Pro", sans-serif;
            padding-bottom: 1rem;
        }

        .cliente-create-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.25rem 0 1rem;
            border-bottom: 1px solid #d9e5f5;
            margin-bottom: 1.25rem;
        }

        .cliente-breadcrumbs {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: #7a8ea9;
        }

        .cliente-breadcrumbs a {
            color: #6f86a6;
            text-decoration: none;
        }

        .cliente-breadcrumbs strong {
            color: #3f546f;
            font-weight: 700;
        }

        .cliente-breadcrumbs i {
            font-size: 0.6rem;
            color: #9caec4;
        }

        .cliente-top-actions {
            display: flex;
            align-items: center;
            gap: 0.55rem;
        }

        .cliente-top-actions button {
            width: 2rem;
            height: 2rem;
            border: 1px solid #d4dfee;
            border-radius: 0.65rem;
            color: #7e92ad;
            background: #fff;
        }

        .cliente-page-head h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.1;
            color: #1e2d43;
        }

        .cliente-page-head p {
            margin: 0.45rem 0 1.25rem;
            color: #7488a2;
            font-size: 0.95rem;
        }

        .cliente-errors {
            border-radius: 0.75rem;
            margin-bottom: 1rem;
        }

        .cliente-errors ul {
            margin: 0.5rem 0 0;
            padding-left: 1.25rem;
        }

        .cliente-create-card {
            background: #fff;
            border: 1px solid #d5e0ee;
            border-radius: 0.8rem;
            overflow: hidden;
            box-shadow: 0 15px 28px -28px rgba(28, 67, 122, 0.95);
        }

        .cliente-create-card > header {
            padding: 1rem 1.15rem;
            border-bottom: 1px solid #e4ebf4;
            display: flex;
            align-items: center;
            gap: 0.55rem;
            background: #fbfdff;
        }

        .cliente-create-card > header i {
            color: #425d7d;
            font-size: 0.88rem;
        }

        .cliente-create-card > header h2 {
            margin: 0;
            font-size: 1.05rem;
            font-weight: 700;
            color: #2a3b53;
        }

        .cliente-create-card form {
            padding: 1.25rem 1.4rem 1.15rem;
        }

        .cliente-form-grid {
            display: grid;
            gap: 0.9rem 1rem;
        }

        .empresa-grid {
            grid-template-columns: repeat(12, 1fr);
        }

        .contacto-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .field-group {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .field-group label {
            margin: 0;
            font-size: 0.84rem;
            color: #3d516b;
            font-weight: 700;
        }

        .field-group input {
            width: 100%;
            border: 1px solid #d5dfec;
            border-radius: 0.5rem;
            background: #fff;
            height: 2.55rem;
            padding: 0 0.75rem;
            color: #334b68;
            font-size: 0.9rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .field-group input:focus {
            outline: none;
            border-color: #6aa8f4;
            box-shadow: 0 0 0 3px rgba(76, 146, 236, 0.15);
        }

        .field-group input.is-invalid {
            border-color: #d94c5f;
        }

        .field-lg {
            grid-column: span 8;
        }

        .field-sm {
            grid-column: span 4;
        }

        .field-full {
            grid-column: span 8;
        }

        .field-md {
            grid-column: span 4;
        }

        .contacto-section {
            margin-top: 0.8rem;
            padding-top: 0.95rem;
            border-top: 1px solid #e8edf6;
        }

        .contacto-section h3 {
            margin: 0 0 0.9rem;
            font-size: 1rem;
            color: #2a3c56;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 700;
        }

        .contacto-section h3 i {
            color: #516c8e;
            font-size: 0.95rem;
        }

        .with-icon .input-icon-wrap {
            position: relative;
        }

        .with-icon .input-icon-wrap i {
            position: absolute;
            top: 50%;
            left: 0.65rem;
            transform: translateY(-50%);
            color: #8ba0bc;
            font-size: 0.8rem;
        }

        .with-icon .input-icon-wrap input {
            padding-left: 2rem;
        }

        .cliente-form-actions {
            margin-top: 1.2rem;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 0.55rem;
        }

        .btn-cancelar,
        .btn-guardar {
            min-width: 5rem;
            height: 2.25rem;
            padding: 0 1rem;
            border-radius: 0.5rem;
            border: 1px solid #d1dceb;
            font-size: 0.85rem;
            font-weight: 700;
            color: #4e6482;
            background: #f8fbff;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-guardar {
            background: #fff;
        }

        .btn-cancelar:hover,
        .btn-guardar:hover {
            color: #2e425e;
            border-color: #bbccdf;
            text-decoration: none;
        }

        .cliente-bottom-note {
            text-align: center;
            margin-top: 1rem;
            color: #97a9bf;
            font-size: 0.75rem;
            font-weight: 600;
        }

        @media (max-width: 992px) {
            .cliente-create-ui {
                max-width: none;
            }

            .empresa-grid {
                grid-template-columns: repeat(6, 1fr);
            }

            .contacto-grid {
                grid-template-columns: 1fr;
            }

            .field-lg,
            .field-sm,
            .field-full,
            .field-md {
                grid-column: span 6;
            }
        }

        @media (max-width: 640px) {
            .cliente-create-topbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.7rem;
            }

            .cliente-create-card form {
                padding: 1rem;
            }
        }
    </style>
@endsection
