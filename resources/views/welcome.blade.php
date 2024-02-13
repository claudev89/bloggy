@extends('layouts.app')

@section('content')
    @if(session()->has('suscrito'))
        <div class="alert alert-success" role="alert">{{ session('suscrito') }}</div>
    @endif
    @if(session()->has('noSuscrito'))
        <div class="alert alert-danger" role="alert">{{ session('noSuscrito') }}</div>
    @endif
    @php($posts = \App\Models\Post::where('borrador', 0)->orderBy('created_at', 'desc')->paginate(15))
    @foreach($posts as $post)
        <div class="card mb-2 mt-2">
            <div class="row g-0">
                <div class="col-md-4">
                    <a href="{{ route('posts.show', $post) }}"><img src="{{ $post->image }}" class="img-fluid rounded" alt="{{ $post->titulo }}"></a>
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <a style="text-decoration: none; color: inherit" href="{{ route('posts.show', $post )}}"><h4
                                class="card-title">{{ $post->titulo }}</h4></a>
                        <small
                            class="d-inline-flex mb-2 px-2 py-1 fw-semibold text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-2">
                            {{ date('d/m/Y', strtotime($post->created_at)) }}
                        </small>
                        <text class="text-body-secondary">Posteado por
                            @if($post->user)
                                <a style="text-decoration: none; color: inherit"
                                   href="{{ route('users.show', $post->user ) }}">{{ $post->user->name }}</a>
                            @else
                                usuario eliminado
                            @endif
                            en <a style="text-decoration: none; color: inherit"
                                  href="{{ route('categories.show', $post->categories->first() ) }}">{{ $post->categories->first()->name }} </a>
                        </text>
                        <div class="row">
                            <p class="crop-text-2 col-9 col-md-10">{{ $post->description }}</p>
                            <div class="col-1">
                                <i class="bi bi-heart"></i> <br>{{ $post->likes->count() }}</br>
                            </div>
                            <div class="col-1">
                                <i class="bi bi-chat-square"></i> <br>{{ $post->comentarios->count() }}</br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{ $posts->links() }}

    <hr>
    <div class="container">
        @livewire('suscripcionComponent')
    </div>

@endsection

<style>
    .crop-text-2 {
        -webkit-line-clamp: 2;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-box-orient: vertical;
    }
</style>
