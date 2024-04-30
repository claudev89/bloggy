@extends('layouts.app')

@if(session()->has('deletedPost'))
    <div class="toast show fade text-bg-success position-fixed bottom-0 end-0 mb-2 me-2 z-3" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000" id="sMessage">
        <div class="d-flex">
            <div class="toast-body">
                {!! session('deletedPost') !!}
            </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
@endif

@section('content')

    @auth
        <div class="ms-auto mb-2">
            <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#createPost"><i class="bi bi-plus"></i> Agregar post</button>
            <livewire:admin.createPost />
        </div>
    @endauth
    @if(session()->has('suscrito'))
        <div class="alert alert-success" role="alert">{{ session('suscrito') }}</div>
    @endif
    @if(session()->has('noSuscrito'))
        <div class="alert alert-danger" role="alert">{{ session('noSuscrito') }}</div>
    @endif

    @if(!isset($posts))
        @php($posts = \App\Models\Post::where('borrador', 0)->orderBy('created_at', 'desc')->paginate(15))
    @else
        @if(isset($tagName))
            <h4>Etiqueta: {{$tagName}}</h4>
        @endif
        @if(isset($categoryName))
            <h4>Categoría: {{ $categoryName }}</h4>
        @endif
    @endif
    @foreach($posts as $post)

        @if(Str::startsWith($post->image, 'http'))
            @php($image = $post->image)
        @else
            @php($image = asset('storage/'.$post->image))
        @endif

        @php($fechaPost = \Carbon\Carbon::parse($post->created_at))
        <div class="card mb-2 mt-2">
            <div class="row g-0">
                <div class="col-md-4">
                    <a href="{{ route('posts.show', $post) }}"><img src="{{ $image }}" class="img-fluid rounded" alt="{{ $post->titulo }}"></a>
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <a style="text-decoration: none; color: inherit" href="{{ route('posts.show', $post )}}"><h4
                                class="card-title">{{ $post->titulo }}</h4></a>
                        <small
                            class="d-inline-flex mb-2 px-2 py-1 fw-semibold text-danger-emphasis bg-danger-subtle border border-danger-subtle rounded-2 text-uppercase">
                            @if ($fechaPost->year === now()->year)
                                {{ substr($fechaPost->isoFormat('D MMM'), 0, -1) }}
                            @else
                                {{ $fechaPost->isoFormat('D MMM YYY') }}
                            @endif
                        </small>
                        <text class="text-body-secondary">Publicado por
                            @if($post->user)
                                <a style="text-decoration: none; color: inherit"
                                   href="{{ route('users.show', $post->user ) }}"><b>{{ $post->user->name }}</b></a>
                            @else
                                usuario eliminado
                            @endif
                            en <a style="text-decoration: none; color: inherit"
                                  href="{{ route('categories.show', $post->categories->first() ) }}"><b>{{ $post->categories->first()->name }}</b> </a>
                        </text>
                        <div class="row">
                            <p class="crop-text-2">{{ $post->description }}</p>
                        </div>
                        <div class="d-flex flex-row justify-content-end no-gutters">
                            <div class="text-center">
                                <i class="bi bi-eye"></i> <br> {{ $post->views }}
                            </div>
                            <div class="text-center ms-2 me-2">
                                <i class="bi bi-heart"></i> <br>{{ $post->likes->count() }}</br>
                            </div>
                            <div class="text-center">
                                <i class="bi bi-chat-square"></i> <br>{{ $post->comentarios->count() }}</br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @if(!isset($categoryName))
        {{ $posts->links() }}
    @endif

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
