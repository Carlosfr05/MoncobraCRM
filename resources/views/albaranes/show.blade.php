@extends('adminlte::page')

@section('title', 'Visor de Albaran - MoncobraCRM')

@section('header-title')
    <i class="fas fa-file-pdf"></i> Visor de Albaran
@endsection

@section('content')
    <section class="albaran-viewer-wrap">
        <header class="albaran-viewer-header">
            <div>
                <h1>{{ $albaran->numero }}</h1>
                <p>
                    Cliente: {{ $albaran->cliente?->empresa_nombre ?: 'Sin cliente' }}
                    | Fecha: {{ optional($albaran->fecha)->format('d/m/Y') ?: '-' }}
                </p>
            </div>
            <div class="albaran-viewer-actions">
                <a href="{{ route('albaranes.index') }}" class="btn-back">Volver al listado</a>
            </div>
        </header>

        @if ($pdfStreamUrl)
            <div class="pdf-panel">
                <iframe
                    src="{{ $pdfStreamUrl }}#toolbar=1&navpanes=0&view=FitH"
                    title="PDF del albaran {{ $albaran->numero }}"
                    class="pdf-frame"
                ></iframe>
            </div>
        @else
            <div class="pdf-empty-state">
                <i class="far fa-file-pdf" aria-hidden="true"></i>
                <h2>No hay PDF disponible para este albaran</h2>
                <p>
                    Se puede abrir este visor en cuanto se asocie un archivo PDF al albaran.
                </p>
            </div>
        @endif
    </section>
@endsection

@section('css')
    @vite(['resources/css/albaran-pdf-viewer.css'])
@endsection
