@extends('adminlte::page')

@section('title', 'Perfil Cliente - MoncobraCRM')

@section('content')
    <section class="cliente-show-ui">
        @if (session('success'))
            <div class="cliente-show-success" role="status">
                <i class="fas fa-check-circle" aria-hidden="true"></i>
                {{ session('success') }}
            </div>
        @endif

        <header class="cliente-show-topbar">
            <nav aria-label="breadcrumb" class="cliente-show-breadcrumbs">
                <a href="{{ route('clientes.index') }}">Clientes</a>
                <span><i class="fas fa-chevron-right" aria-hidden="true"></i></span>
                <strong>{{ $cliente->empresa_nombre }}</strong>
                <span><i class="fas fa-chevron-right" aria-hidden="true"></i></span>
                <span>Historial de Pedidos</span>
            </nav>
        </header>

        <section class="cliente-show-head">
            <div>
                <h1>Historial de Presupuesto: {{ $cliente->empresa_nombre }}</h1>
                <p>Gestión integral del flujo de pedidos y trazabilidad de fabricación.</p>
            </div>
            <div class="cliente-show-actions">
                <a href="{{ route('presupuestos.create', ['cliente_id' => $cliente->id, 'volver_cliente' => 1, 'modo' => 'carga']) }}" class="btn-exportar">
                    <i class="fas fa-upload" aria-hidden="true"></i>
                    Cargar Presupuesto
                </a>
                <a href="{{ route('presupuestos.create', ['cliente_id' => $cliente->id, 'volver_cliente' => 1]) }}" class="btn-nuevo-presupuesto">
                    <i class="fas fa-plus" aria-hidden="true"></i>
                    Nuevo Presupuesto
                </a>
            </div>
        </section>

        <article class="cliente-show-card">
            <header class="cliente-show-card-head">
                <h2>Listado de Órdenes de Trabajo</h2>
                <form method="GET" action="{{ route('clientes.show', $cliente->id) }}">
                    <label class="sr-only" for="estado">Filtrar estado</label>
                    <select id="estado" name="estado" onchange="this.form.submit()">
                        <option value="todos" {{ $estadoFiltro === 'todos' ? 'selected' : '' }}>Todos los estados</option>
                        <option value="pendiente" {{ $estadoFiltro === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="recibido" {{ $estadoFiltro === 'recibido' ? 'selected' : '' }}>Recibido</option>
                        <option value="entregado" {{ $estadoFiltro === 'entregado' ? 'selected' : '' }}>Entregado</option>
                    </select>
                </form>
            </header>

            <div class="table-responsive cliente-show-table-wrap">
                <table class="table cliente-show-table">
                    <thead>
                        <tr>
                            <th>OT</th>
                            <th>N° Presupuesto</th>
                            <th>Fecha</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Total</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($presupuestos as $presupuesto)
                            <tr>
                                <td class="ot-cell">{{ $presupuesto->ot ?: 'OT-' . str_pad((string) $presupuesto->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td>
                                    @if ($presupuesto->archivo_pdf)
                                        <a href="{{ route('presupuestos.pdf', $presupuesto->id) }}" target="_blank" rel="noopener" class="presupuesto-numero-link">
                                            {{ $presupuesto->numero ?: 'SIN-NÚMERO' }}
                                        </a>
                                    @else
                                        <span class="presupuesto-numero-disabled">{{ $presupuesto->numero ?: 'SIN-NÚMERO' }}</span>
                                    @endif
                                </td>
                                <td>{{ $presupuesto->fecha ? $presupuesto->fecha->format('d/m/Y') : 'N/D' }}</td>
                                <td>{{ $presupuesto->titulo ?: ($presupuesto->documento ?: 'Sin descripción') }}</td>
                                <td>
                                    <span class="estado-pill estado-{{ $presupuesto->ui_estado }}">{{ $presupuesto->ui_estado_label }}</span>
                                </td>
                                <td class="total-cell">
                                    @if ($presupuesto->ui_total !== null)
                                        {{ number_format($presupuesto->ui_total, 2, ',', '.') }} €
                                    @else
                                        N/D
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($presupuesto->archivo_pdf)
                                        <a href="{{ route('presupuestos.pdf', $presupuesto->id) }}" target="_blank" rel="noopener" class="accion-pdf-btn">
                                            <i class="far fa-file-pdf" aria-hidden="true"></i>
                                            Ver PDF
                                        </a>
                                    @else
                                        <span class="accion-sin-pdf">Sin PDF</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">No hay presupuestos registrados para este cliente.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <footer class="cliente-show-footer">
                <p>Mostrando {{ $presupuestos->count() }} de {{ $presupuestos->total() }} registros</p>

                @if ($presupuestos->hasPages())
                    <nav aria-label="Paginación historial" class="cliente-show-pagination">
                        <a href="{{ $presupuestos->onFirstPage() ? '#' : $presupuestos->previousPageUrl() }}" class="page-btn {{ $presupuestos->onFirstPage() ? 'is-disabled' : '' }}">Anterior</a>

                        @foreach ($presupuestos->getUrlRange(max(1, $presupuestos->currentPage() - 1), min($presupuestos->lastPage(), $presupuestos->currentPage() + 1)) as $page => $url)
                            <a href="{{ $url }}" class="page-number {{ $page === $presupuestos->currentPage() ? 'is-active' : '' }}">{{ $page }}</a>
                        @endforeach

                        <a href="{{ $presupuestos->hasMorePages() ? $presupuestos->nextPageUrl() : '#' }}" class="page-btn {{ $presupuestos->hasMorePages() ? '' : 'is-disabled' }}">Siguiente</a>
                    </nav>
                @endif
            </footer>
        </article>

        <div class="cliente-show-back">
            <a href="{{ route('clientes.index') }}" class="btn-volver-listado">
                <i class="fas fa-arrow-left" aria-hidden="true"></i>
                Atrás al listado
            </a>
        </div>
    </section>
@endsection

@section('css')
    <style>
        .content-wrapper {
            background: #f3f6fb;
        }

        .cliente-show-ui {
            color: #223248;
            font-family: "Segoe UI", "Source Sans Pro", sans-serif;
            padding-bottom: 1.1rem;
        }

        .cliente-show-topbar {
            margin-bottom: 0.8rem;
        }

        .cliente-show-success {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            margin-bottom: 0.85rem;
            padding: 0.62rem 0.85rem;
            border: 1px solid #bde5cb;
            border-radius: 0.72rem;
            background: #edf9f1;
            color: #266b3e;
            font-size: 0.86rem;
            font-weight: 700;
        }

        .cliente-show-breadcrumbs {
            display: inline-flex;
            align-items: center;
            gap: 0.48rem;
            font-size: 0.78rem;
            font-weight: 600;
            color: #8da0ba;
        }

        .cliente-show-breadcrumbs a {
            color: #7088a8;
            text-decoration: none;
        }

        .cliente-show-breadcrumbs strong {
            color: #4f627d;
            font-weight: 700;
        }

        .cliente-show-breadcrumbs i {
            font-size: 0.58rem;
            color: #a5b6cb;
        }

        .cliente-show-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .cliente-show-head h1 {
            margin: 0;
            color: #1e3d60;
            font-size: 2.2rem;
            font-weight: 700;
            line-height: 1.12;
        }

        .cliente-show-head p {
            margin: 0.35rem 0 0;
            color: #6f87a4;
            font-size: 0.95rem;
        }

        .cliente-show-actions {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            flex-wrap: wrap;
        }

        .btn-exportar,
        .btn-nuevo-presupuesto {
            height: 2.35rem;
            border-radius: 0.62rem;
            padding: 0 0.95rem;
            font-size: 0.84rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.42rem;
            text-decoration: none;
            border: 1px solid transparent;
            white-space: nowrap;
        }

        .btn-exportar {
            background: #fff;
            border-color: #d2deec;
            color: #445a78;
        }

        .btn-nuevo-presupuesto {
            background: #173f6a;
            border-color: #173f6a;
            color: #fff;
            box-shadow: 0 11px 16px -14px rgba(19, 56, 96, 0.9);
        }

        .btn-exportar:hover {
            border-color: #bdd0e6;
            color: #304c6e;
        }

        .btn-nuevo-presupuesto:hover {
            color: #fff;
            background: #12375e;
            border-color: #12375e;
            text-decoration: none;
        }

        .cliente-show-card {
            background: #fff;
            border: 1px solid #d5e0ee;
            border-radius: 0.85rem;
            overflow: hidden;
            box-shadow: 0 17px 30px -28px rgba(20, 52, 94, 0.95);
        }

        .cliente-show-card-head {
            padding: 1rem 1rem;
            border-bottom: 1px solid #e6edf7;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .cliente-show-card-head h2 {
            margin: 0;
            color: #25415f;
            font-size: 1.2rem;
            font-weight: 700;
        }

        .cliente-show-card-head select {
            min-width: 9.4rem;
            height: 2rem;
            border: 1px solid #d5dfec;
            border-radius: 0.55rem;
            color: #445a78;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 0 0.65rem;
            background: #f8fbff;
        }

        .cliente-show-table {
            margin-bottom: 0;
        }

        .cliente-show-table thead th {
            border-top: 0;
            border-bottom: 1px solid #e7eef7;
            color: #6f86a4;
            text-transform: uppercase;
            letter-spacing: 0.14em;
            font-size: 0.67rem;
            font-weight: 700;
            padding: 0.92rem 0.95rem;
            white-space: nowrap;
        }

        .cliente-show-table tbody td {
            border-top: 1px solid #eaf1fa;
            color: #304863;
            font-size: 0.86rem;
            padding: 0.92rem 0.95rem;
            vertical-align: middle;
        }

        .ot-cell {
            font-weight: 700;
            color: #1f3e61;
            white-space: nowrap;
        }

        .presupuesto-numero-link {
            color: #1f67b8;
            font-weight: 700;
            text-decoration: none;
            border-bottom: 1px solid transparent;
        }

        .presupuesto-numero-link:hover {
            color: #144f96;
            border-bottom-color: #144f96;
            text-decoration: none;
        }

        .presupuesto-numero-disabled {
            color: #6f86a4;
            font-weight: 700;
        }

        .estado-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 5.1rem;
            height: 1.5rem;
            border-radius: 999px;
            font-size: 0.62rem;
            font-weight: 800;
            letter-spacing: 0.06em;
            border: 1px solid transparent;
        }

        .estado-entregado {
            color: #2b8250;
            background: #e7f8ee;
            border-color: #c7ebd5;
        }

        .estado-pendiente {
            color: #9b6c16;
            background: #fff5dc;
            border-color: #f2deaa;
        }

        .estado-recibido {
            color: #1f67b8;
            background: #eaf2ff;
            border-color: #cbddf8;
        }

        .total-cell {
            white-space: nowrap;
            font-weight: 700;
            color: #253f61;
        }

        .accion-pdf-btn {
            height: 1.9rem;
            border-radius: 0.48rem;
            border: 1px solid #d3deec;
            background: #f8fbff;
            color: #3f5a79;
            font-size: 0.72rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.3rem;
            padding: 0 0.6rem;
            text-decoration: none;
        }

        .accion-pdf-btn:hover {
            color: #1f4f8c;
            border-color: #bccde3;
            text-decoration: none;
        }

        .accion-sin-pdf {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 1.9rem;
            border-radius: 0.48rem;
            border: 1px dashed #d6e0ee;
            color: #90a2b8;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0 0.6rem;
        }

        .cliente-show-footer {
            border-top: 1px solid #e6edf7;
            padding: 0.85rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.9rem;
            flex-wrap: wrap;
        }

        .cliente-show-footer p {
            margin: 0;
            color: #6c82a0;
            font-size: 0.78rem;
            font-weight: 600;
        }

        .cliente-show-back {
            margin-top: 0.85rem;
            display: flex;
            justify-content: flex-start;
        }

        .btn-volver-listado {
            height: 2.15rem;
            border-radius: 0.52rem;
            border: 1px solid #cfdbec;
            background: #fff;
            color: #476282;
            font-size: 0.8rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            padding: 0 0.95rem;
            text-decoration: none;
        }

        .btn-volver-listado:hover {
            color: #2f4c6f;
            border-color: #b8cde5;
            text-decoration: none;
        }

        .cliente-show-pagination {
            display: inline-flex;
            align-items: center;
            gap: 0.32rem;
        }

        .cliente-show-pagination a {
            text-decoration: none;
        }

        .page-btn,
        .page-number {
            height: 1.8rem;
            border-radius: 0.48rem;
            border: 1px solid #d0ddef;
            color: #4f6786;
            background: #fff;
            font-size: 0.72rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 0.62rem;
        }

        .page-number {
            width: 1.8rem;
            padding: 0;
        }

        .page-number.is-active {
            background: #173f6a;
            border-color: #173f6a;
            color: #fff;
        }

        .is-disabled {
            pointer-events: none;
            opacity: 0.55;
            background: #f6f9ff;
        }

        @media (max-width: 992px) {
            .cliente-show-head {
                flex-direction: column;
                align-items: flex-start;
            }

            .cliente-show-head h1 {
                font-size: 1.8rem;
            }
        }

        @media (max-width: 640px) {
            .cliente-show-card-head,
            .cliente-show-footer {
                flex-direction: column;
                align-items: flex-start;
            }

            .cliente-show-pagination {
                flex-wrap: wrap;
            }
        }
    </style>
@endsection
