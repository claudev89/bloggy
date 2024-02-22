@extends('layouts.app')

@section('content')

    <h2 class="text-uppercase" xmlns="http://www.w3.org/1999/html">{{ $post->titulo }}</h2>

    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            @if( $post->categories->first()->parentCategory )
                <li class="breadcrumb-item">
                    <a href="{{ route('categories.show', $post->categories->first()->parent_category) }}">{{ $post->categories->first()->parent_category->name }}</a>
                </li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{$post->categories->first()->name }}</li>
        </ol>
    </nav>

    <div class="text-secondary mb-3">
        Posteado el {{ date('d/m/Y', strtotime($post->created_at)) }}
    </div>

    <p>{{ $post->description }}</p>
    <img src="{{ $post->image }}" class="mb-3">
    <p>{{ $post->body }}</p>

    <div class="row">
        <div class="col-10">
            <div class="row justify-content-end">
                <div class="col-1 align-content-center">
                    <livewire:LikeButton :likeable="$post" wire:key="{{ 'like-post-'.$post->id }}" />
                </div>
                <div class="col-1 align-content-center">
                    <i class="bi bi-chat-square"></i> <br>
                    <span class="small"> {{ $post->comentarios->count() }}</span>
                </div>
            </div>
        </div>
        @if($post->user)
            <div class="col-md-2 justify-content-center" onclick="window.location.href='{{route('users.show', $post->user)}}'" style="cursor: pointer">
                <img src="{{ $post->user->profile_photo_path }}" width="60" height="60" class="rounded-circle"><br>
                {{ $post->user->name }}
            </div>
        @else
            <div class="col-md-2 justify-content-center">
                <img src="{{ '/images/pp.webp' }}" width="60" height="60" class="rounded-circle"><br>
                Usuario Eliminado
            </div>
        @endif
    </div>

    <livewire:Comentariosect :post="$post" wire:key="{{ 'commentsForPost-'.$post->id }}" @saved="$refresh" />

@endsection

