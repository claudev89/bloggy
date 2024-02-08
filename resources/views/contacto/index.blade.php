@extends('layouts.app')

@section('content')
    <h1 class="text-uppercase">Formulario de contacto</h1>
    <h5>Nos alegra que quieras ponerte en contacto con nosotros, para hacerlo, por favor completa el siguiente formulario:</h5>
    @livewire('ContactForm')
@endsection
