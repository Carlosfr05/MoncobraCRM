@extends('adminlte::page')

@section('title', 'Presupuestos - MoncobraCRM')

@section('css')
    @vite(['resources/css/presupuestos-index.css'])
@endsection

@section('content_header')
    <div class="presupuestos-header">
        <div class="presupuestos-header__copy">
            <h1>Seguimiento de Presupuestos</h1>
            <p>Visualiza, filtra y gestiona las ofertas comerciales del proyecto activo.</p>
        </div>

        <a href="{{ route('presupuestos.create') }}" class="presupuestos-create-btn">
            <i class="fas fa-plus"></i>
            Nuevo Presupuesto
        </a>
    </div>
@endsection

@section('content')
    <div class="presupuestos-shell">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-circle-check"></i>
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="presupuestos-filters-card">
            <form method="GET" action="{{ route('presupuestos.index') }}" class="presupuestos-search-form">
                <div class="presupuestos-search-copy">
                    <span class="presupuestos-search-label">Buscador</span>
                    <h2>Encuentra presupuestos por oferta, cliente, OT o fecha</h2>
                    <p>Escribe un texto, un número de oferta, una OT o una fecha para localizar el registro.</p>
                </div>

                <div class="presupuestos-search-controls">
                    <div class="presupuestos-input-group">
                        <i class="fas fa-search"></i>
                        <input
                            type="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Buscar por número de oferta, cliente, OT o fecha"
                            autocomplete="off"
                        >
                    </div>

                    <div class="presupuestos-actions">
                        <button type="submit" class="presupuestos-search-btn">
                            Buscar
                        </button>

                        @if($search !== '')
                            <a href="{{ route('presupuestos.index') }}" class="presupuestos-reset-btn">
                                Limpiar
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <div class="presupuestos-card">
            <div class="presupuestos-card__header">
                <div>
                    <h3>Listado de presupuestos</h3>
                    <p>{{ $presupuestos->total() }} resultados encontrados</p>
                </div>

                <div class="presupuestos-card__meta">
                    <span class="meta-pill">Proyecto activo</span>
                    <span class="meta-pill meta-pill--soft">Página {{ $presupuestos->currentPage() }} de {{ $presupuestos->lastPage() }}</span>
                </div>
            </div>

            <div class="table-responsive presupuestos-table-wrap">
                <table class="table presupuestos-table">
                    <thead>
                        <tr>
                            <th>Nº Oferta</th>
                            <th>Número</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>OT</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($presupuestos as $presupuesto)
                            <tr>
                                <td data-label="Nº Oferta">
                                    <div class="presupuesto-primary">
                                        <strong>{{ $presupuesto->documento }}</strong>
                                        @if($presupuesto->titulo)
                                            <span>{{ $presupuesto->titulo }}</span>
                                        @else
                                            <span class="text-muted">Sin título asociado</span>
                                        @endif
                                    </div>
                                </td>
                                <td data-label="Número">
                                    <span class="presupuesto-reference">{{ $presupuesto->numero }}</span>
                                </td>
                                <td data-label="Fecha">
                                    <span class="presupuesto-date">
                                        {{ optional($presupuesto->fecha)->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td data-label="Cliente">
                                    <div class="presupuesto-client">
                                        <strong>{{ $presupuesto->cliente?->empresa_nombre ?? 'Sin cliente' }}</strong>
                                        @if($presupuesto->cliente?->localidad)
                                            <span>{{ $presupuesto->cliente->localidad }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td data-label="OT">
                                    <span class="presupuesto-ot">
                                        {{ $presupuesto->ot ?: 'Sin OT' }}
                                    </span>
                                </td>
                                <td data-label="Total">
                                    <span class="presupuesto-total">
                                        {{ number_format((float) ($presupuesto->total ?? 0), 2, ',', '.') }} EUR
                                    </span>
                                </td>
                                <td data-label="Estado">
                                    @php
                                        $estado = (string) ($presupuesto->estado ?: 'pendiente');
                                        $estadoClass = match ($estado) {
                                            'aceptado' => 'estado-pill estado-aceptado',
                                            'rechazado' => 'estado-pill estado-rechazado',
                                            'pendiente pedido' => 'estado-pill estado-pendiente-pedido',
                                            default => 'estado-pill estado-pendiente',
                                        };
                                    @endphp
                                    <span class="{{ $estadoClass }}">{{ ucfirst($estado) }}</span>
                                </td>
                                <td data-label="Acciones" class="text-right">
                                    <button type="button" class="presupuesto-action-btn" aria-label="Acción pendiente" title="Acción pendiente">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="presupuestos-empty-state">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                        <h4>No hay presupuestos para mostrar</h4>
                                        <p>Prueba a cambiar la búsqueda o crea un nuevo presupuesto para empezar.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="presupuestos-pagination">
                {{ $presupuestos->links() }}
            </div>
        </div>
    </div>
@endsection