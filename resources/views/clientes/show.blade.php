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
    @vite(['resources/css/clientes-show.css'])
@endsection
