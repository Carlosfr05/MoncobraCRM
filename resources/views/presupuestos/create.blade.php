@extends('adminlte::page')

@section('title', 'Nuevo Presupuesto - MoncobraCRM')

@section('content')
    @php
        $isCarga = $modo === 'carga';
        $volverUrl = $volverACliente && $clienteSeleccionadoId
            ? route('clientes.show', $clienteSeleccionadoId)
            : route('presupuestos.index');
    @endphp

    <section class="presupuesto-create-ui">
        <header class="presupuesto-topbar">
            <nav aria-label="breadcrumb" class="presupuesto-breadcrumbs">
                <a href="{{ route('dashboard') }}">Inicio</a>
                <span><i class="fas fa-chevron-right" aria-hidden="true"></i></span>
                <a href="{{ route('clientes.index') }}">Clientes</a>
                <span><i class="fas fa-chevron-right" aria-hidden="true"></i></span>
                <strong>{{ $isCarga ? 'Cargar Presupuesto' : 'Nuevo Presupuesto' }}</strong>
            </nav>
        </header>

        <section class="presupuesto-head">
            <h1>{{ $isCarga ? 'Cargar Presupuesto' : 'Registrar Nuevo Presupuesto' }}</h1>
            <p>Complete los datos del presupuesto para añadirlo al historial del cliente.</p>
        </section>

        @if ($errors->any())
            <div class="alert alert-danger presupuesto-errors" role="alert">
                <strong>No se pudo guardar el presupuesto.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <article class="presupuesto-card">
            <header>
                <i class="fas fa-file-invoice-dollar" aria-hidden="true"></i>
                <h2>Datos del Presupuesto</h2>
            </header>

            <form action="{{ route('presupuestos.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <input type="hidden" name="modo" value="{{ $modo }}">

                @if ($volverACliente && $clienteSeleccionadoId)
                    <input type="hidden" name="redirect_cliente_id" value="{{ $clienteSeleccionadoId }}">
                @endif

                <div class="presupuesto-grid">
                    <div class="field-group">
                        <label for="cliente_id">Cliente</label>
                        <select id="cliente_id" name="cliente_id" class="@error('cliente_id') is-invalid @enderror" required>
                            <option value="">Seleccione un cliente...</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ (string) old('cliente_id', $clienteSeleccionadoId ?: '') === (string) $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->empresa_nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field-group">
                        <label for="fecha">Fecha</label>
                        <input type="date" id="fecha" name="fecha" value="{{ old('fecha', now()->toDateString()) }}" class="@error('fecha') is-invalid @enderror" required>
                    </div>

                    <div class="field-group">
                        <label for="documento">Documento</label>
                        <input type="text" id="documento" name="documento" value="{{ old('documento') }}" placeholder="Presupuesto técnico" class="@error('documento') is-invalid @enderror" maxlength="50" required>
                    </div>

                    <div class="field-group">
                        <label for="numero">N° Presupuesto</label>
                        <input type="text" id="numero" name="numero" value="{{ old('numero') }}" placeholder="PO-AIR-5590" class="@error('numero') is-invalid @enderror" maxlength="50" required>
                    </div>

                    <div class="field-group field-full">
                        <label for="titulo">Descripción</label>
                        <input type="text" id="titulo" name="titulo" value="{{ old('titulo') }}" placeholder="Descripción del trabajo o alcance" class="@error('titulo') is-invalid @enderror" maxlength="255">
                    </div>

                    <div class="field-group">
                        <label for="ot">OT</label>
                        <input type="text" id="ot" name="ot" value="{{ old('ot') }}" placeholder="OT-2024-0012" class="@error('ot') is-invalid @enderror" maxlength="255">
                    </div>

                    <div class="field-group field-full">
                        <label for="archivo_pdf">Archivo PDF {{ $isCarga ? '(obligatorio)' : '(opcional)' }}</label>
                        <input type="file" id="archivo_pdf" name="archivo_pdf" accept="application/pdf" class="@error('archivo_pdf') is-invalid @enderror" {{ $isCarga ? 'required' : '' }}>
                        <small class="pdf-help">Formato permitido: PDF. Tamano maximo: 10 MB.</small>
                    </div>
                </div>

                <footer class="presupuesto-actions">
                    <a href="{{ $volverUrl }}" class="btn-cancelar">Cancelar</a>
                    <button type="submit" class="btn-guardar">
                        <i class="fas fa-save" aria-hidden="true"></i>
                        Guardar Presupuesto
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

        .presupuesto-create-ui {
            max-width: 920px;
            margin: 0 auto;
            color: #223248;
            font-family: "Segoe UI", "Source Sans Pro", sans-serif;
            padding-bottom: 1rem;
        }

        .presupuesto-topbar {
            margin-bottom: 0.85rem;
        }

        .presupuesto-breadcrumbs {
            display: inline-flex;
            align-items: center;
            gap: 0.48rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: #8397b2;
        }

        .presupuesto-breadcrumbs a {
            color: #7088a8;
            text-decoration: none;
        }

        .presupuesto-breadcrumbs i {
            font-size: 0.58rem;
            color: #a6b7cb;
        }

        .presupuesto-head h1 {
            margin: 0;
            font-size: 2rem;
            line-height: 1.1;
            color: #1f2f45;
            font-weight: 700;
        }

        .presupuesto-head p {
            margin: 0.4rem 0 1rem;
            color: #778ba8;
            font-size: 0.94rem;
        }

        .presupuesto-errors {
            border-radius: 0.74rem;
            margin-bottom: 1rem;
        }

        .presupuesto-errors ul {
            margin: 0.45rem 0 0;
            padding-left: 1.2rem;
        }

        .presupuesto-card {
            background: #fff;
            border: 1px solid #d8e1ef;
            border-radius: 0.82rem;
            overflow: hidden;
            box-shadow: 0 16px 30px -28px rgba(19, 53, 99, 0.95);
        }

        .presupuesto-card > header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 1.15rem;
            border-bottom: 1px solid #e6edf8;
            background: #fbfdff;
        }

        .presupuesto-card > header i {
            color: #1f76de;
            font-size: 0.9rem;
        }

        .presupuesto-card > header h2 {
            margin: 0;
            color: #2a3d57;
            font-size: 1rem;
            font-weight: 700;
        }

        .presupuesto-card form {
            padding: 1.15rem 1.25rem 1rem;
        }

        .presupuesto-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.9rem 0.95rem;
        }

        .field-group {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .field-group label {
            margin: 0;
            color: #3e556f;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .field-group input,
        .field-group select {
            width: 100%;
            height: 2.45rem;
            border: 1px solid #d6dfec;
            border-radius: 0.48rem;
            background: #fff;
            color: #304967;
            padding: 0 0.72rem;
            font-size: 0.88rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .field-group input[type="file"] {
            height: auto;
            padding: 0.58rem 0.72rem;
            line-height: 1.3;
            background: #fbfdff;
        }

        .field-group input:focus,
        .field-group select:focus {
            outline: none;
            border-color: #6caaef;
            box-shadow: 0 0 0 3px rgba(89, 156, 236, 0.14);
        }

        .field-group .is-invalid {
            border-color: #d84e61;
        }

        .field-full {
            grid-column: 1 / -1;
        }

        .pdf-help {
            color: #768ba8;
            font-size: 0.76rem;
            font-weight: 600;
        }

        .presupuesto-actions {
            margin-top: 1rem;
            border-top: 1px solid #e8eef7;
            padding-top: 0.9rem;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 0.55rem;
        }

        .btn-cancelar,
        .btn-guardar {
            height: 2.25rem;
            border-radius: 0.48rem;
            padding: 0 1rem;
            font-size: 0.83rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            gap: 0.4rem;
        }

        .btn-cancelar {
            border: 1px solid #d2deec;
            background: #fff;
            color: #4d6381;
        }

        .btn-guardar {
            border: 1px solid #1f76de;
            background: #1f76de;
            color: #fff;
            box-shadow: 0 8px 14px -11px rgba(31, 118, 222, 0.95);
        }

        .btn-cancelar:hover {
            text-decoration: none;
            color: #334a67;
            border-color: #b8cbe3;
        }

        .btn-guardar:hover {
            text-decoration: none;
            color: #fff;
            background: #1668ca;
            border-color: #1668ca;
        }

        @media (max-width: 768px) {
            .presupuesto-grid {
                grid-template-columns: 1fr;
            }

            .presupuesto-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-cancelar,
            .btn-guardar {
                width: 100%;
            }
        }
    </style>
@endsection
