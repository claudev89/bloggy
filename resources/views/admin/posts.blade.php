@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Posts</h1>
@stop

@section('content')
    <p>Acá puedes administrar los posts tuyos y de los usuarios.</p>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="my-posts-tab" data-toggle="tab" data-target="#my-posts" type="button" role="tab" aria-controls="home" aria-selected="true">Mis Posts</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="users-posts-tab" data-toggle="tab" data-target="#users-posts" type="button" role="tab" aria-controls="profile" aria-selected="false">Posts de Usuarios</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="categories-tab" data-toggle="tab" data-target="#categories" type="button" role="tab" aria-controls="contact" aria-selected="false">Categorías</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="my-posts" role="tabpanel" aria-labelledby="my-posts-tab"> <livewire:admin.admin-posts /> </div>
        <div class="tab-pane fade" id="users-posts" role="tabpanel" aria-labelledby="users-posts-tab">Posts de Usuarios</div>
        <div class="tab-pane fade" id="categories" role="tabpanel" aria-labelledby="categories-tab">Categorías</div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script></script>
@stop
