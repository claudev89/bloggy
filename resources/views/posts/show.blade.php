@extends('layouts.app')

@section('content')

    <h2 class="text-uppercase" xmlns="http://www.w3.org/1999/html">{{ $post->titulo }}</h2>

    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
            @if( $post->categories->first()->parentCategory )
                <li class="breadcrumb-item">
                    <a href="{{ route('categories.show', $post->categories->first()->parent_category->name) }}">{{ $post->categories->first()->parent_category->name }}</a>
                </li>
            @endif
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('categories.show', $post->categories->first()->name) }}">{{$post->categories->first()->name }}</a> </li>
        </ol>
    </nav>

    <div class="text-secondary mb-3">
        Publicado el {{ date('d/m/Y', strtotime($post->created_at)) }} | Leído {{$post->views === 1 ? $post->views." vez": $post->views." veces" }}
    </div>

    <p>{{ $post->description }}</p>

    @if(Str::startsWith($post->image, 'http'))
        <img src="{{ $post->image }}" />
    @else
        <img src="{{ asset('storage/'.$post->image) }}" />
    @endif

    <p>{!! $post->body !!}</p>

    @if(count($post->tags) > 0)
        <strong>Etiquetas: </strong>
    @endif
    <div>
        @foreach($post->tags as $tag)
            <a href="{{ route('tag.show', $tag->name) }}"><span class="badge text-bg-secondary">{{ $tag->name }}</span></a>
        @endforeach
    </div>

    <livewire:PostComments :key="'comments-'.$post->id" :$post :comments="$post->comments"/>

@endsection

