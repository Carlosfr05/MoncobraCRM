@extends('adminlte::page')

@section('title', 'Gestión de Clientes - MoncobraCRM')

@section('content')
    @php
        $iconosIndustria = ['fa-building', 'fa-bolt', 'fa-industry', 'fa-city', 'fa-warehouse'];
        $sectores = ['SECTOR INDUSTRIAL', 'SERVICIOS TÉCNICOS', 'INGENIERÍA Y MANTENIMIENTO', 'INFRAESTRUCTURA', 'ENERGÍA Y UTILITIES'];
        $roles = ['DIRECCIÓN TÉCNICA', 'GESTIÓN DE CUENTAS', 'OPERACIONES', 'ADMINISTRACIÓN', 'COMPRAS'];
    @endphp

    <section class="clientes-ui">
        @if (session('success'))
            <div class="clientes-success" role="status">
                <i class="fas fa-check-circle" aria-hidden="true"></i>
                {{ session('success') }}
            </div>
        @endif

        <header class="clientes-header">
            <div>
                <h1>Gestión de Clientes</h1>
                <p>Administración y control de la cartera de empresas industriales.</p>
            </div>
            <div class="clientes-header-actions">
                <button type="button" class="clientes-icon-btn" aria-label="Notificaciones">
                    <i class="fas fa-bell"></i>
                </button>
                <button type="button" class="clientes-icon-btn" aria-label="Configuración">
                    <i class="fas fa-cog"></i>
                </button>
                <a href="{{ route('clientes.create') }}" class="clientes-add-btn">
                    Añadir Cliente
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </header>

        <article class="clientes-card">
            <form method="GET" action="{{ route('clientes.index') }}" class="clientes-search-row">
                <div class="clientes-search-box">
                    <i class="fas fa-search" aria-hidden="true"></i>
                    <input
                        type="text"
                        name="buscar"
                        value="{{ $buscar }}"
                        placeholder="Filtrar por nombre, CIF, sector o localidad..."
                        aria-label="Buscar clientes"
                    >
                </div>
                <input type="hidden" name="estado" value="{{ $estado }}">
                <button type="submit" class="clientes-search-btn">Ejecutar Búsqueda</button>
            </form>

            <div class="clientes-tabs-row">
                <nav class="clientes-tabs" aria-label="Estados de clientes">
                    <a href="{{ route('clientes.index', ['estado' => 'todos', 'buscar' => $buscar]) }}" class="{{ $estado === 'todos' ? 'is-active' : '' }}">Todos los Clientes</a>
                    <a href="{{ route('clientes.index', ['estado' => 'activas', 'buscar' => $buscar]) }}" class="{{ $estado === 'activas' ? 'is-active' : '' }}">Cuentas Activas</a>
                    <a href="{{ route('clientes.index', ['estado' => 'inactivas', 'buscar' => $buscar]) }}" class="{{ $estado === 'inactivas' ? 'is-active' : '' }}">Inactivos / Bajas</a>
                </nav>

                <button type="button" class="clientes-filter-btn">
                    <i class="fas fa-sliders-h" aria-hidden="true"></i>
                    Filtros Avanzados
                </button>
            </div>

            <div class="table-responsive clientes-table-wrapper">
                <table class="table clientes-table">
                    <thead>
                        <tr>
                            <th>Nombre del Cliente Industrial</th>
                            <th>CIF / Ident.</th>
                            <th>Sede Principal</th>
                            <th>Persona de Contacto</th>
                            <th>OTS Activas</th>
                            <th class="text-right">Gestión</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clientes as $cliente)
                            @php
                                $key = $cliente->id % count($iconosIndustria);
                                $otsActivas = (int) $cliente->albaranes_count + (int) $cliente->presupuestos_count + (int) $cliente->pedidos_clientes_count;
                                $contacto = $cliente->persona_contacto ?: 'Sin asignar';
                            @endphp
                            <tr>
                                <td>
                                    <div class="cliente-main">
                                        <span class="cliente-avatar" aria-hidden="true">
                                            <i class="fas {{ $iconosIndustria[$key] }}"></i>
                                        </span>
                                        <div>
                                            <a href="{{ route('clientes.show', $cliente->id) }}" class="cliente-name-link">
                                                <div class="cliente-name">{{ $cliente->empresa_nombre }}</div>
                                            </a>
                                            <div class="cliente-meta">{{ $sectores[$key] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="cliente-cif">{{ $cliente->cif_nif }}</td>
                                <td class="cliente-location">{{ $cliente->localidad ?: 'Sin localidad' }}</td>
                                <td>
                                    <div class="cliente-contact">{{ $contacto }}</div>
                                    <div class="cliente-meta">{{ $roles[$key] }}</div>
                                </td>
                                <td>
                                    <span class="cliente-ots">{{ $otsActivas }}</span>
                                </td>
                                <td>
                                    <div class="cliente-actions">
                                        <a href="{{ route('clientes.edit', $cliente->id) }}" class="cliente-action-icon" title="Editar cliente" aria-label="Editar cliente">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <a href="{{ route('clientes.show', $cliente->id) }}" class="cliente-expediente-btn">
                                            <i class="fas fa-history"></i>
                                            Expediente
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    No hay clientes registrados para los filtros seleccionados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <footer class="clientes-footer">
                <p>
                    Mostrando registros del {{ $clientes->firstItem() ?? 0 }} al {{ $clientes->lastItem() ?? 0 }} de un total de {{ number_format($clientes->total(), 0, ',', '.') }} clientes registrados
                </p>

                @if ($clientes->hasPages())
                    <div class="clientes-pagination">
                        {{ $clientes->onEachSide(1)->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </footer>
        </article>
    </section>
@endsection

@section('css')
    <style>
        .content-wrapper {
            background: #f3f6fb;
        }

        .clientes-ui {
            font-family: "Segoe UI", "Source Sans Pro", sans-serif;
            color: #122238;
            padding-bottom: 0.75rem;
        }

        .clientes-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .clientes-success {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            margin-bottom: 1rem;
            padding: 0.65rem 0.85rem;
            border: 1px solid #bde5cb;
            border-radius: 0.75rem;
            background: #edf9f1;
            color: #266b3e;
            font-weight: 700;
            font-size: 0.88rem;
        }

        .clientes-header h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.1;
        }

        .clientes-header p {
            margin: 0.35rem 0 0;
            color: #6b7d95;
            font-size: 0.95rem;
        }

        .clientes-header-actions {
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }

        .clientes-icon-btn {
            width: 2.5rem;
            height: 2.5rem;
            border: 1px solid #d9e3f0;
            border-radius: 0.85rem;
            background: #fff;
            color: #64748b;
            transition: all 0.2s ease;
        }

        .clientes-icon-btn:hover {
            color: #1f6ed8;
            border-color: #bed5f6;
        }

        .clientes-add-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.7rem 1.15rem;
            border-radius: 0.75rem;
            background: linear-gradient(120deg, #1f79ea, #1064cf);
            color: #fff;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            box-shadow: 0 10px 18px -15px rgba(10, 89, 188, 0.85);
        }

        .clientes-add-btn:hover {
            color: #fff;
            transform: translateY(-1px);
        }

        .clientes-card {
            background: #fff;
            border: 1px solid #dce6f3;
            border-radius: 1.15rem;
            overflow: hidden;
            box-shadow: 0 14px 35px -30px rgba(16, 53, 100, 0.55);
        }

        .clientes-search-row {
            display: flex;
            gap: 0.9rem;
            padding: 1.45rem;
            border-bottom: 1px solid #e8edf5;
            background: #fdfefe;
        }

        .clientes-search-box {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 0.7rem;
            border: 1px solid #d7e1ee;
            border-radius: 0.75rem;
            padding: 0 0.9rem;
            background: #fff;
        }

        .clientes-search-box i {
            color: #8393a9;
            font-size: 0.9rem;
        }

        .clientes-search-box input {
            width: 100%;
            height: 2.75rem;
            border: 0;
            outline: 0;
            color: #324865;
            font-size: 0.93rem;
            background: transparent;
        }

        .clientes-search-btn {
            min-width: 9.5rem;
            border: 0;
            border-radius: 0.75rem;
            background: linear-gradient(120deg, #2380ef, #1469d2);
            color: #fff;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 10px 16px -14px rgba(20, 105, 210, 0.92);
        }

        .clientes-tabs-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.9rem;
            border-bottom: 1px solid #e8edf5;
            padding: 0.95rem 1.45rem;
        }

        .clientes-tabs {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .clientes-tabs a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            border-radius: 0.65rem;
            color: #607089;
            font-size: 0.84rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .clientes-tabs a.is-active {
            background: #e9f3ff;
            color: #1e74db;
        }

        .clientes-filter-btn {
            border: 1px solid #d5dfed;
            background: #fff;
            color: #425a78;
            border-radius: 0.65rem;
            padding: 0.5rem 0.95rem;
            font-size: 0.84rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .clientes-table-wrapper {
            margin: 0;
        }

        .clientes-table {
            margin-bottom: 0;
        }

        .clientes-table thead th {
            border-top: 0;
            border-bottom: 1px solid #e8edf5;
            color: #7a8ca5;
            font-size: 0.69rem;
            text-transform: uppercase;
            letter-spacing: 0.18em;
            font-weight: 700;
            padding: 1.15rem 1.2rem;
        }

        .clientes-table tbody td {
            border-top: 1px solid #edf2f8;
            vertical-align: middle;
            padding: 1.2rem;
            color: #2a3e57;
            font-size: 0.91rem;
        }

        .cliente-main {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            min-width: 16rem;
        }

        .cliente-avatar {
            width: 2.6rem;
            height: 2.6rem;
            border-radius: 0.8rem;
            background: #f1f6fd;
            border: 1px solid #dbe7f6;
            color: #7388a6;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            flex-shrink: 0;
        }

        .cliente-name {
            color: #1c2c42;
            font-size: 1.02rem;
            font-weight: 700;
            line-height: 1.15;
        }

        .cliente-name-link {
            text-decoration: none;
            display: inline-block;
        }

        .cliente-name-link:hover .cliente-name {
            color: #1f72d8;
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        .cliente-meta {
            margin-top: 0.2rem;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: #7f90a9;
            font-weight: 700;
        }

        .cliente-cif {
            font-weight: 700;
            color: #374b67;
            white-space: nowrap;
        }

        .cliente-location {
            color: #425b7a;
        }

        .cliente-contact {
            color: #1f2f45;
            font-weight: 700;
        }

        .cliente-ots {
            min-width: 2.6rem;
            height: 2.6rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.8rem;
            background: #ebf4ff;
            color: #1f73d9;
            border: 1px solid #c8dcf6;
            font-weight: 700;
            font-size: 1.02rem;
        }

        .cliente-actions {
            display: inline-flex;
            align-items: center;
            justify-content: flex-end;
            gap: 0.55rem;
            width: 100%;
        }

        .cliente-action-icon {
            width: 2.2rem;
            height: 2.2rem;
            border: 1px solid #d8e3f0;
            border-radius: 0.65rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #566b87;
            background: #f8fbff;
            text-decoration: none;
        }

        .cliente-expediente-btn {
            border: 1px solid #dbe4f0;
            border-radius: 0.65rem;
            padding: 0.46rem 0.85rem;
            color: #3f5675;
            background: #f8fbff;
            text-decoration: none;
            font-size: 0.81rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
        }

        .clientes-footer {
            border-top: 1px solid #e8edf5;
            padding: 1.15rem 1.45rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .clientes-footer p {
            margin: 0;
            color: #5f738f;
            font-size: 0.94rem;
            font-weight: 600;
        }

        .clientes-pagination .pagination {
            margin: 0;
            gap: 0.4rem;
        }

        .clientes-pagination .page-item .page-link {
            border-radius: 0.65rem;
            border: 1px solid #d4deec;
            color: #526784;
            min-width: 2.2rem;
            height: 2.2rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 0.75rem;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .clientes-pagination .page-item.active .page-link {
            border-color: #1f75dd;
            background: #1f75dd;
            box-shadow: 0 9px 15px -11px rgba(31, 117, 221, 0.95);
        }

        .clientes-pagination .page-item.disabled .page-link {
            color: #9aabc0;
            background: #f7f9fc;
        }

        @media (max-width: 992px) {
            .clientes-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .clientes-search-row {
                flex-direction: column;
            }

            .clientes-search-btn {
                width: 100%;
                min-height: 2.75rem;
            }

            .clientes-tabs-row {
                flex-direction: column;
                align-items: flex-start;
            }

            .cliente-main {
                min-width: auto;
            }
        }
    </style>
@endsection
