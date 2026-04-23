@extends('adminlte::page')

@section('title', 'Nueva Salida de Stock - MoncobraCRM')

@section('css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/inventario-salida.css'])
@endsection

@section('content')
    <section class="stock-out-page">
        <header class="stock-out-head">
            <nav class="stock-out-breadcrumb" aria-label="breadcrumb">
                <a href="{{ route('inventario.index') }}">Inventario</a>
                <span><i class="fas fa-chevron-right"></i></span>
                <strong>Nueva Salida de Stock</strong>
            </nav>

            <div class="stock-out-datetime">
                <i class="far fa-calendar-alt"></i>
                {{ now()->format('d M Y, H:i A') }}
            </div>
        </header>

        <section class="stock-out-title">
            <h1>Registro de Salida</h1>
            <p>Control de egresos de materiales y componentes industriales.</p>
        </section>

        @if ($errors->any())
            <div class="stock-out-alert" role="alert">
                <strong>No se pudo registrar la salida.</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="stock-out-form" action="{{ route('inventario.salida.store') }}" method="POST" novalidate>
            @csrf

            <div class="stock-out-layout">
                <div class="stock-out-main">
                    <article class="out-card">
                        <header><h2><i class="far fa-copy"></i> Identificacion del producto</h2></header>

                        <div class="out-grid out-grid-top">
                            <div class="field-group field-wide">
                                <label for="producto_busqueda">Producto</label>
                                <input
                                    id="producto_busqueda"
                                    name="producto_busqueda"
                                    type="text"
                                    list="inventario-catalogo-salida"
                                    value="{{ old('producto_busqueda') }}"
                                    placeholder="Escribe SKU o nombre..."
                                    class="@error('producto_busqueda') is-invalid @enderror"
                                    required
                                >
                            </div>

                            <div class="field-group field-tight">
                                <label for="cantidad_retirar">Cantidad a retirar</label>
                                <input
                                    id="cantidad_retirar"
                                    name="cantidad_retirar"
                                    type="number"
                                    min="1"
                                    step="1"
                                    value="{{ old('cantidad_retirar', 1) }}"
                                    class="@error('cantidad_retirar') is-invalid @enderror"
                                    required
                                >
                            </div>
                        </div>

                        <article class="selected-product-card">
                            <div class="selected-head">
                                <span>Seleccionado</span>
                                <span class="state-ok">En stock</span>
                            </div>

                            <div class="selected-body">
                                <div class="selected-icon"><i class="fas fa-cart-arrow-down"></i></div>
                                <div>
                                    <h3 id="selected-product-name">{{ old('producto_busqueda', 'Selecciona un item del inventario') }}</h3>
                                    <small id="selected-product-code">SKU: -</small>
                                </div>
                                <div class="selected-stock">
                                    <small>Stock Actual</small>
                                    <strong><span id="selected-stock-value">0</span> unid</strong>
                                </div>
                            </div>
                        </article>
                    </article>

                    <article class="out-card">
                        <header><h2><i class="far fa-clipboard"></i> Trazabilidad y asignacion</h2></header>

                        <div class="out-grid out-grid-bottom">
                            <div class="field-group">
                                <label for="ot">Orden de trabajo (OT)</label>
                                <input id="ot" name="ot" type="text" value="{{ old('ot') }}" placeholder="Buscar OT activa..." class="@error('ot') is-invalid @enderror">
                            </div>

                            <div class="field-group">
                                <label for="solicitante">Solicitante</label>
                                <input id="solicitante" name="solicitante" type="text" value="{{ old('solicitante', auth()->user()->name ?? '') }}" placeholder="Nombre del solicitante" class="@error('solicitante') is-invalid @enderror">
                            </div>
                        </div>

                        <footer class="out-actions">
                            <button type="submit" class="btn-confirm-out">
                                <i class="far fa-check-circle"></i>
                                Confirmar salida de stock
                            </button>
                            <a href="{{ route('inventario.index') }}" class="btn-cancel-out">Cancelar</a>
                        </footer>
                    </article>
                </div>

                <aside class="stock-out-side">
                    <article class="side-summary-card">
                        <h2>Resumen de operación</h2>

                        <dl class="summary-list">
                            <div>
                                <dt>Operador</dt>
                                <dd>{{ auth()->user()->name ?? 'Operador' }}</dd>
                            </div>
                            <div>
                                <dt>Cantidad de productos</dt>
                                <dd id="qty-preview">-{{ (int) old('cantidad_retirar', 1) }}</dd>
                            </div>
                            <div>
                                <dt>Criticidad</dt>
                                <dd><span class="crit-level">Media</span></dd>
                            </div>
                        </dl>

                        <div class="security-note">
                            <small>NOTA DE SEGURIDAD</small>
                            <p>Asegurese de verificar fisicamente el numero de serie antes de completar el retiro del almacen central.</p>
                        </div>

                        <button type="button" class="btn-pdf">Ver PDF</button>
                    </article>

                    <article class="side-history-card">
                        <h3>Salidas recientes</h3>
                        <div class="history-list">
                            @forelse($salidasRecientes as $item)
                                <article>
                                    <div class="history-icon"><i class="far fa-minus-square"></i></div>
                                    <div>
                                        <strong>{{ $item->descripcion }}</strong>
                                        <small>{{ $item->updated_at?->format('d-m-Y H:i') }} · Hace {{ $item->updated_at?->diffForHumans() }}</small>
                                    </div>
                                    <span>-{{ max(1, (int) round($item->stock_actual * 0.05)) }}</span>
                                </article>
                            @empty
                                <p class="history-empty">No hay salidas recientes registradas.</p>
                            @endforelse
                        </div>
                        <button type="button" class="btn-history">Ver todo el historial</button>
                    </article>
                </aside>
            </div>

            <datalist id="inventario-catalogo-salida">
                @foreach ($catalogo as $producto)
                    <option value="{{ $producto->descripcion }}" data-codigo="{{ $producto->codigo }}"></option>
                    <option value="{{ $producto->codigo }}" data-codigo="{{ $producto->codigo }}"></option>
                @endforeach
            </datalist>
            <input type="hidden" name="codigo" id="codigo" value="{{ old('codigo') }}">
        </form>
    </section>
@endsection

@section('js')
    @php
        $catalogoSalidaJs = $catalogo
            ->map(function ($item) {
                return [
                    'codigo' => (string) $item->codigo,
                    'descripcion' => (string) $item->descripcion,
                    'stock_actual' => (int) ($item->stock_actual ?? 0),
                ];
            })
            ->values();
    @endphp

    <script>
        (function () {
            const catalogo = @json($catalogoSalidaJs);
            const productoInput = document.getElementById('producto_busqueda');
            const codigoInput = document.getElementById('codigo');
            const cantidadInput = document.getElementById('cantidad_retirar');
            const qtyPreview = document.getElementById('qty-preview');
            const selectedName = document.getElementById('selected-product-name');
            const selectedCode = document.getElementById('selected-product-code');
            const selectedStock = document.getElementById('selected-stock-value');

            const normalize = (value) => String(value || '').trim().toLowerCase();

            const findProducto = () => {
                const search = normalize(productoInput.value);
                if (!search) {
                    return null;
                }

                return catalogo.find((item) => {
                    return normalize(item.codigo) === search || normalize(item.descripcion) === search;
                }) || null;
            };

            const updateSummary = () => {
                const qty = parseInt(cantidadInput.value || '0', 10) || 0;
                qtyPreview.textContent = `-${Math.max(1, qty)}`;
            };

            const hydrateProduct = () => {
                const producto = findProducto();

                if (!producto) {
                    codigoInput.value = '';
                    selectedName.textContent = productoInput.value || 'Selecciona un item del inventario';
                    selectedCode.textContent = 'SKU: -';
                    selectedStock.textContent = '0';
                    return;
                }

                codigoInput.value = producto.codigo;
                selectedName.textContent = producto.descripcion;
                selectedCode.textContent = `SKU: ${producto.codigo}`;
                selectedStock.textContent = producto.stock_actual;
            };

            productoInput.addEventListener('change', hydrateProduct);
            productoInput.addEventListener('input', hydrateProduct);
            cantidadInput.addEventListener('input', updateSummary);

            hydrateProduct();
            updateSummary();
        })();
    </script>
@endsection
