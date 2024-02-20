@extends('layouts.app')

@section('content')


    <h2 class="text-uppercase">{{ $post->titulo }}</h2>

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
                    <livewire:LikeButton :likeable="$post" />
                </div>
                <div class="col-1 align-content-center">
                    <i class="bi bi-chat-square"></i> <br>
                    {{ $post->comentarios->count() }}
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

    <div class="container py-5">
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-10">
                <div class="card">
                    <div class="card-body p-4">
                        <h4 class="text-center pb-2">Comentarios</h4>

                        <div class="row">
                            <div class="col">
                                <!-- Comentarios -->
                                @if($post->comentarios->isNotEmpty())
                                    @foreach($post->comentarios->sortByDesc('created_at') as $comentario)
                                        @php($fechaComentario = \Carbon\Carbon::parse($comentario->created_at))
                                        @if(is_null($comentario->respuestaA))
                                            @if($comentario->user->profile_photo_path)
                                                @php($profile_photo_url = $comentario->user->profile_photo_path)
                                            @else
                                                @php($profile_photo_url = '/images/pp.webp')
                                            @endif
                                            @if($comentario->user)
                                                @php($author_name = $comentario->user->name)
                                            @else
                                                @php($author_name = "<i>Cuenta Eliminada</i>")
                                            @endif
                                            <div class="d-flex flex-start mt-4">
                                                @if($comentario->user)
                                                    <a href="{{ route('users.show', $comentario->user) }}">
                                                    <img class="rounded-circle shadow-1-strong me-1 me-md-3 profile_pct"
                                                         src="{{ $profile_photo_url }}" alt="{{ $author_name }}" width="65"
                                                         height="65" />
                                                    </a>
                                                @else
                                                    <img class="rounded-circle shadow-1-strong me-1 me-md-3 profile_pct"
                                                         src="{{ $profile_photo_url }}" alt="{{ $author_name }}" width="65"
                                                         height="65" />
                                                @endif
                                                <div class="flex-grow-1 flex-shrink-1">
                                                    <div>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <p class="mb-1 flex-fill">
                                                                {{ $author_name }}<span class="small text-secondary d-block d-md-inline"> - <a href="#" style="text-decoration: none; color: inherit" data-mdb-tooltip-init title="{{ $fechaComentario->isoFormat('LLLL') }}">{{ $fechaComentario->diffForHumans() }}</a></span>
                                                            </p>
                                                            <div>
                                                                <a href="#!" style="text-decoration: none; color: inherit"><i class="bi bi-reply me-1"></i><span class="small d-block d-md-inline d-none">Responder</span></a>
                                                            </div>
                                                            <div class="ms-2">
                                                                <livewire:LikeButton :likeable="$comentario" />
                                                            </div>
                                                        </div>
                                                        <p class="small mb-0">
                                                            {{ $comentario->cuerpo }}
                                                        </p>
                                                    </div>
                                                    <!-- Fin comentario -->

                                                    <!-- Inicio respuestas -->
                                                    @foreach($comentario->respuesta as $respuesta)
                                                        @php($fechaRespuesta = \Carbon\Carbon::parse($respuesta->created_at))
                                                        @if($comentario->id == $respuesta->respuestaA)
                                                            @if(($respuesta->user->profile_photo_path))
                                                                @php($profile_photo_url = $respuesta->user->profile_photo_path)
                                                            @else
                                                                @php($profile_photo_url = '/images/pp.webp')
                                                            @endif
                                                            @if($respuesta->user)
                                                                @php($author_name = $respuesta->user->name)
                                                            @else
                                                                @php($author_name = "<i>Cuenta Eliminada</i>")
                                                            @endif

                                                            <div class="d-flex flex-start mt-4">
                                                                @if($respuesta->user)
                                                                    <a class="me-3" href="{{ route('users.show', $respuesta->user) }}">
                                                                        <img class="rounded-circle shadow-1-strong profile_pct"
                                                                             src="{{ $profile_photo_url }}" alt="{{ $author_name }}"
                                                                             width="65" height="65" />
                                                                    </a>
                                                                @else
                                                                    <img class="rounded-circle shadow-1-strong profile_pct"
                                                                         src="{{ $profile_photo_url }}" alt="{{ $author_name }}"
                                                                         width="65" height="65" />
                                                                @endif
                                                                <div class="flex-grow-1 flex-shrink-1">
                                                                    <div>
                                                                        <div class="d-flex justify-content-between align-items-center">
                                                                            <p class="mb-1">
                                                                                {{ $author_name }}<span class="small text-secondary d-block d-md-inline"> - <a href="#" style="text-decoration: none; color: inherit" data-mdb-tooltip-init title="{{ $fechaRespuesta->isoFormat('LLLL') }}">{{ $fechaRespuesta->diffForHumans() }}</a></span>
                                                                            </p>
                                                                            <livewire:LikeButton :likeable="$respuesta" />
                                                                        </div>
                                                                        <p class="small mb-0">
                                                                            {{ $respuesta->cuerpo }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="alert alert-dark">
                                        Todavía no hay comentarios. @auth Sé el primero en dejar uno. @endauth
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @auth()
        <div class="container text-dark">
            <div class="row d-flex justify-content-center">
                <div class="col-12 col-md-10">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="d-flex flex-start w-100">
                                <img class="rounded-circle shadow-1-strong me-3 profile_pct"
                                     src="@if(is_null(auth()->user()->profile_photo_path)) /images/pp.webp @else(auth()->user()->profile_photo_path) @endif" alt="{{auth()->user()->name}}"
                                     width="65"
                                     height="65"/>
                                <div class="w-100">
                                    <h5>Deja un comentario</h5>
                                    <div class="form-outline">
                                        <textarea class="form-control" id="comentario" rows="4"></textarea>
                                    </div>
                                    <div class="d-flex justify-content-end mt-3">
                                        <button type="button" class="btn btn-outline-light">
                                            Comentar <i class="fas fa-long-arrow-alt-right ms-1"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endauth

    <script>
        // Initialization for ES Users
        import { Tooltip, initMDB } from "mdb-ui-kit";

        initMDB({ Tooltip });
    </script>

@endsection

<style>
    .link-muted {
        color: #aaa;
    }

    .link-muted:hover {
        color: #fff;
    }

    @media (max-width: 576px) {
        .profile_pct {
            width: 20px;
            height: 20px;
        }
    }



</style>
