@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Crear Post</h1>
@stop

@section('content')

    <livewire:admin.create-post />

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script></script>
@stop
