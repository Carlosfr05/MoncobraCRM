@extends('adminlte::page')

@section('title', 'Editar Albaran Cliente - MoncobraCRM')

@section('header-title')
    <i class="fas fa-file-invoice"></i> ALBARAN CLIENTE
@endsection

@section('content')
    @include('albaranes.partials.form', ['mode' => 'edit', 'albaran' => $albaran, 'clientes' => $clientes])
@endsection

@section('css')
    @vite(['resources/css/albaranes-form.css'])
@endsection

@section('js')
    @vite(['resources/js/albaranes-form.js'])
@endsection
