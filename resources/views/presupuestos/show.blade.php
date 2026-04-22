@extends('adminlte::page')

@section('title', 'Detalle Presupuesto - MoncobraCRM')

@section('header-title')
    <i class="fas fa-file-contract"></i> Detalle de Presupuesto
@endsection

@section('content')
    <section class="presupuesto-show-wrap">
        <header class="presupuesto-show-head">
            <div>
                <h1>{{ $presupuesto->numero }}</h1>
                <p>
                    Cliente: {{ $presupuesto->cliente?->empresa_nombre ?: 'Sin cliente' }}
                    | Fecha: {{ optional($presupuesto->fecha)->format('d/m/Y') ?: '-' }}
                </p>
            </div>
            <div class="presupuesto-show-actions">
                @if ($presupuesto->archivo_pdf)
                    <a href="{{ route('presupuestos.pdf', $presupuesto) }}" target="_blank" class="open-pdf-btn">Abrir PDF</a>
                @endif
                <a href="{{ route('presupuestos.index') }}" class="back-btn">Volver</a>
            </div>
        </header>

        <article class="presupuesto-show-card">
            <div class="presupuesto-meta-grid">
                <div>
                    <span class="meta-label">Documento</span>
                    <p>{{ $presupuesto->documento }}</p>
                </div>
                <div>
                    <span class="meta-label">OT</span>
                    <p>{{ $presupuesto->ot ?: 'Sin OT' }}</p>
                </div>
                <div>
                    <span class="meta-label">Titulo</span>
                    <p>{{ $presupuesto->titulo ?: '-' }}</p>
                </div>
                <div>
                    <span class="meta-label">Total</span>
                    <p>{{ number_format((float) ($presupuesto->total ?? 0), 2, ',', '.') }}€</p>
                </div>
            </div>

            @if ($presupuesto->archivo_pdf)
                <div class="presupuesto-pdf-panel">
                    <iframe src="{{ route('presupuestos.pdf', $presupuesto) }}#toolbar=1&navpanes=0&view=FitH" title="PDF presupuesto {{ $presupuesto->numero }}"></iframe>
                </div>
            @else
                <p class="pdf-empty">Este presupuesto no tiene archivo PDF asociado.</p>
            @endif
        </article>
    </section>
@endsection

@section('css')
    @vite(['resources/css/presupuestos-show.css'])
@endsection
