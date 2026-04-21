@extends('adminlte::page')

@section('title', 'Editar Cliente - MoncobraCRM')

@section('content')
    <section class="cliente-edit-ui">
        <header class="cliente-edit-topbar">
            <nav aria-label="breadcrumb" class="cliente-edit-breadcrumbs">
                <a href="{{ route('clientes.index') }}">Clientes</a>
                <span><i class="fas fa-chevron-right" aria-hidden="true"></i></span>
                <span>{{ $cliente->empresa_nombre }}</span>
                <span><i class="fas fa-chevron-right" aria-hidden="true"></i></span>
                <strong>Editar Cliente</strong>
            </nav>
        </header>

        <section class="cliente-edit-head">
            <h1>Editar Cliente: {{ $cliente->empresa_nombre }}</h1>
            <p>Actualice la información del cliente y los parámetros de gestión empresarial.</p>
        </section>

        @if ($errors->any())
            <div class="alert alert-danger cliente-edit-errors" role="alert">
                <strong>No se pudo actualizar el cliente.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <article class="cliente-edit-card">
            <form action="{{ route('clientes.update', $cliente->id) }}" method="POST" novalidate>
                @csrf
                @method('PUT')

                <section class="edit-block">
                    <h2>
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        Información General
                    </h2>

                    <div class="edit-grid cols-2">
                        <div class="field-group">
                            <label for="empresa_nombre">Nombre de la Empresa</label>
                            <input type="text" id="empresa_nombre" name="empresa_nombre" value="{{ old('empresa_nombre', $cliente->empresa_nombre) }}" class="@error('empresa_nombre') is-invalid @enderror" required>
                        </div>

                        <div class="field-group">
                            <label for="cif_nif">CIF / VAT Number</label>
                            <input type="text" id="cif_nif" name="cif_nif" value="{{ old('cif_nif', $cliente->cif_nif) }}" class="@error('cif_nif') is-invalid @enderror" required>
                        </div>

                        <div class="field-group">
                            <label for="localidad">Localidad</label>
                            <input type="text" id="localidad" name="localidad" value="{{ old('localidad', $cliente->localidad) }}" class="@error('localidad') is-invalid @enderror" required>
                        </div>

                        <div class="field-group">
                            <label for="codigo_postal">CP</label>
                            <input type="text" id="codigo_postal" name="codigo_postal" value="{{ old('codigo_postal', $cliente->codigo_postal) }}" class="@error('codigo_postal') is-invalid @enderror" required>
                        </div>
                    </div>
                </section>

                <section class="edit-block with-divider">
                    <h2>
                        <i class="far fa-user" aria-hidden="true"></i>
                        Contacto Principal
                    </h2>

                    <div class="edit-grid cols-2">
                        <div class="field-group">
                            <label for="persona_contacto">Nombre del Responsable</label>
                            <input type="text" id="persona_contacto" name="persona_contacto" value="{{ old('persona_contacto', $cliente->persona_contacto) }}" class="@error('persona_contacto') is-invalid @enderror">
                        </div>

                        <div class="field-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $cliente->email) }}" class="@error('email') is-invalid @enderror">
                        </div>

                        <div class="field-group">
                            <label for="telefono">Teléfono Directo</label>
                            <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $cliente->telefono) }}" class="@error('telefono') is-invalid @enderror">
                        </div>

                        <div class="field-group">
                            <label for="cargo_visual">Cargo / Posición</label>
                            <input type="text" id="cargo_visual" value="Responsable de cuenta" disabled>
                        </div>
                    </div>
                </section>

                <section class="edit-block with-divider">
                    <h2>
                        <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                        Ubicación
                    </h2>

                    <div class="edit-grid cols-1">
                        <div class="field-group">
                            <label for="direccion">Dirección</label>
                            <input type="text" id="direccion" name="direccion" value="{{ old('direccion', $cliente->direccion) }}" class="@error('direccion') is-invalid @enderror" required>
                        </div>
                    </div>
                </section>

                <footer class="edit-actions">
                    <a href="{{ route('clientes.index') }}" class="btn-cancelar">Cancelar</a>
                    <button type="submit" class="btn-actualizar">
                        <i class="far fa-save" aria-hidden="true"></i>
                        Actualizar Datos
                    </button>
                </footer>
            </form>
        </article>
    </section>
@endsection

@section('css')
    <style>
        .content-wrapper {
            background: #f3f6fb;
        }

        .cliente-edit-ui {
            max-width: 900px;
            margin: 0 auto;
            color: #223248;
            font-family: "Segoe UI", "Source Sans Pro", sans-serif;
            padding-bottom: 1rem;
        }

        .cliente-edit-topbar {
            padding-top: 0.3rem;
            margin-bottom: 0.8rem;
        }

        .cliente-edit-breadcrumbs {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #8294ac;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .cliente-edit-breadcrumbs a {
            color: #768aa6;
            text-decoration: none;
        }

        .cliente-edit-breadcrumbs strong {
            color: #4d607a;
            font-weight: 700;
        }

        .cliente-edit-breadcrumbs i {
            font-size: 0.6rem;
            color: #a4b4c8;
        }

        .cliente-edit-head h1 {
            margin: 0;
            color: #1e2d43;
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.1;
        }

        .cliente-edit-head p {
            margin: 0.4rem 0 1rem;
            color: #7a8ea8;
            font-size: 0.92rem;
        }

        .cliente-edit-errors {
            border-radius: 0.72rem;
            margin-bottom: 0.9rem;
        }

        .cliente-edit-errors ul {
            margin: 0.45rem 0 0;
            padding-left: 1.2rem;
        }

        .cliente-edit-card {
            background: #fff;
            border: 1px solid #d7e1ef;
            border-radius: 0.75rem;
            box-shadow: 0 15px 32px -30px rgba(24, 61, 112, 0.9);
        }

        .cliente-edit-card form {
            padding: 1.05rem 1rem 0.9rem;
        }

        .edit-block {
            padding: 0.1rem 0.2rem 0.85rem;
        }

        .edit-block.with-divider {
            border-top: 1px solid #e8edf5;
            padding-top: 0.85rem;
        }

        .edit-block h2 {
            margin: 0 0 0.75rem;
            color: #243750;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            font-weight: 700;
        }

        .edit-block h2 i {
            color: #2f86ee;
            font-size: 0.85rem;
        }

        .edit-grid {
            display: grid;
            gap: 0.82rem 0.85rem;
        }

        .edit-grid.cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .edit-grid.cols-1 {
            grid-template-columns: 1fr;
        }

        .field-group {
            display: flex;
            flex-direction: column;
            gap: 0.36rem;
        }

        .field-group label {
            margin: 0;
            color: #425873;
            font-size: 0.76rem;
            font-weight: 700;
        }

        .field-group input {
            width: 100%;
            height: 2.45rem;
            border: 1px solid #d5dfed;
            border-radius: 0.45rem;
            background: #f9fbfe;
            color: #2f4563;
            padding: 0 0.7rem;
            font-size: 0.88rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .field-group input:disabled {
            opacity: 0.76;
            color: #7f90a6;
            cursor: not-allowed;
        }

        .field-group input:focus {
            outline: none;
            border-color: #6daaf1;
            box-shadow: 0 0 0 3px rgba(85, 153, 235, 0.14);
            background: #fff;
        }

        .field-group input.is-invalid {
            border-color: #d84e61;
            background: #fff;
        }

        .edit-actions {
            border-top: 1px solid #e8edf5;
            padding: 0.9rem 0.2rem 0;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 0.55rem;
        }

        .btn-cancelar,
        .btn-actualizar {
            height: 2.25rem;
            border-radius: 0.46rem;
            border: 1px solid #d4deeb;
            padding: 0 1rem;
            font-size: 0.83rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            gap: 0.35rem;
        }

        .btn-cancelar {
            background: #fff;
            color: #4b607d;
            min-width: 5rem;
        }

        .btn-actualizar {
            border-color: #1f76de;
            background: #1f76de;
            color: #fff;
            min-width: 7.7rem;
            box-shadow: 0 9px 14px -12px rgba(31, 118, 222, 0.95);
        }

        .btn-cancelar:hover {
            text-decoration: none;
            color: #334a67;
            border-color: #b9cbe0;
        }

        .btn-actualizar:hover {
            color: #fff;
            text-decoration: none;
            background: #1668ca;
            border-color: #1668ca;
        }

        @media (max-width: 768px) {
            .cliente-edit-ui {
                max-width: none;
            }

            .edit-grid.cols-2 {
                grid-template-columns: 1fr;
            }

            .edit-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-cancelar,
            .btn-actualizar {
                width: 100%;
            }
        }
    </style>
@endsection
