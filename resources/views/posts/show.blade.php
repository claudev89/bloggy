@extends('layouts.app')

@section('content')

    <h2 class="text-uppercase">{{ $post->titulo }}</h2>

    <nav
        style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
        aria-label="breadcrumb">
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
                    <i class="bi bi-heart"></i><br>
                    {{ $post->likes->count() }}
                </div>
                <div class="col-1 align-content-center">
                    <i class="bi bi-chat-square"></i> <br>
                    {{ $post->comentarios->count() }}
                </div>
            </div>
        </div>
        @if($post->user)
            <div class="col-md-2 justify-content-center"
                 onclick="window.location.href='{{route('users.show', $post->user)}}'" style="cursor: pointer">
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
    @auth()
        <hr>
        <div class="container align-content-end">
            <form>
                <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Deje su comentario aquí" id="comentario"
                              style="height: 100px"></textarea>
                    <label for="floatingTextarea">Dejar un comentario</label>
                </div>
                <div class="row justify-content-end">
                    <button type="submit" class="btn btn-outline-light col-md-3 me-3 col-5">Comentar</button>
                </div>
            </form>
        </div>
            @endauth

            <hr>
            <h2>Comentarios:</h2>

            @if($post->comentarios->isNotEmpty())
                @foreach($post->comentarios->sortByDesc('created_at') as $comentario)
                    @if(is_null($comentario->respuestaA))
                        <div class="card mb-3">
                            <h5 class="card-header">
                                @if($comentario->autor)
                                    <a href="{{ route('users.show', $comentario->user) }}"
                                       style="text-decoration: none; color: inherit">
                                        <img src="{{ $comentario->user->profile_photo_path }}" width="25" height="25"
                                             class="rounded-3"> {{ $comentario->user->name }}
                                    </a>
                                    comentó el {{ date('d/m/Y', strtotime($comentario->created_at)) }}:
                                @else
                                    <img src="" width="25" height="25" class="rounded-3"><i>Cuenta Eliminada</i>
                                    comentó el {{ date('d/m/Y', strtotime($comentario->created_at)) }}:
                                @endif
                            </h5>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-9 col-md-10">
                                        <p class="card-text">{{ $comentario->cuerpo }}</p>
                                    </div>
                                    <div class="col-1">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="bi bi-heart"></i>
                                            <span>{{ $comentario->likes->count() }}</span>
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <i class="bi bi-chat-square"></i>
                                    </div>
                                </div>
                            </div>
                            @foreach($comentario->respuesta as $respuesta)
                                @if($comentario->id == $respuesta->respuestaA)
                                    <div class="card mb-3 me-4 ms-4 mb-2">
                                        <h5 class="card-header">
                                            @if($respuesta->autor)
                                                <a href="{{ route('users.show', $respuesta->user) }}"
                                                   style="text-decoration: none; color: inherit">
                                                    @if( is_null($respuesta->user->profile_photo_path))
                                                        <img src="/images/pp.webp" width="25" height="25"
                                                             class="rounded-3"> {{ $respuesta->user->name }}
                                                    @else
                                                        <img src="{{ $respuesta->user->profile_photo_path }}" width="25"
                                                             height="25" class="rounded-3"> {{ $respuesta->user->name }}
                                                    @endif
                                                </a>
                                                comentó el {{ date('d/m/Y', strtotime($respuesta->created_at)) }}:
                                            @else
                                                <img src="" width="25" height="25" class="rounded-3"><i>Cuenta
                                                    Eliminada</i>
                                                comentó el {{ date('d/m/Y', strtotime($respuesta->created_at)) }}:
                                            @endif
                                        </h5>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-9 col-md-11">
                                                    <p class="card-text">{{ $respuesta->cuerpo }}</p>
                                                </div>
                                                <div class="col-1">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <i class="bi bi-heart"></i>
                                                        <span>{{ $respuesta->likes->count() }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                    @endif
                @endforeach
            @else
                Todavía no hay comentarios, sé el primero en comentar.
    @endif

@endsection
