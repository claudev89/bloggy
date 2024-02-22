<div>
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
                                                                <livewire:LikeButton :likeable="$comentario" wire:key="{{ 'likeButton-' .  $comentario->id }}" />
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
                                                                            <livewire:LikeButton :likeable="$respuesta"  wire:key="{{ 'likeButton-' .  $comentario->id.'-'.$respuesta->id }}" />
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
                                        Todavía no hay comentarios.
                                        @auth Sé el primero en dejar uno. @endauth
                                        @guest <a href="/login">Inicia sesión</a> para dejar el primero. @endguest
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @guest
        @if($post->comentarios->isNotEmpty())
            <div class="row justify-content-center">
                <div class="alert alert-dark col-12 col-md-5" style="text-align: center">
                    <a href="/login">Inicia sesión</a> para poder comentar.
                </div>
            </div>
        @endif
    @endguest

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
                                    <form wire:submit.prevent="addComment" >
                                    <div class="form-outline">
                                        <textarea class="form-control" id="comentario" rows="4" wire:model="comentario"></textarea>
                                    </div>
                                    <div class="d-flex justify-content-end mt-3">
                                        <button type="submit" class="btn btn-outline-light">
                                            Comentar <i class="fas fa-long-arrow-alt-right ms-1"></i>
                                        </button>
                                    </div>
                                    </form>
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
</div>
