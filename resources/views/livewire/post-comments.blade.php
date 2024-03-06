<div>
    <div class="row">
        <div class="col-10">
            <div class="row justify-content-end">
                <div class="col-1 align-content-center">
                    <livewire:LikeButton :likeable="$post" :key="'like-post-'.$post->id"/>
                </div>
                <div class="col-1 align-content-center">
                    <a href="{{ auth()->check() ? '#comment' : route('login') }}" style="color: inherit"><i
                            class="bi bi-chat-square"></i></a><br>
                    <span class="small"> {{ $post->comentarios->count() }} </span>
                </div>
            </div>
        </div>
        @if($post->user)
            <div class="col-md-2 justify-content-center"
                 onclick="window.location.href='{{route('users.show', $post->user)}}'" style="cursor: pointer">
                <img src="{{ $post->user->profile_photo_url }}" width="60" height="60" class="rounded-circle"><br>
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
                                @if($this->comments->count() === 0)
                                    <div class="alert alert-dark">
                                        Todavía no hay comentarios.
                                    </div>
                                @else
                                    @forelse($this->comments->get() as $comentario)
                                        @php($fechaComentario = \Carbon\Carbon::parse($comentario->created_at))
                                        @if(is_null($comentario->respuestaA))
                                            @if($comentario->user->profile_photo_url)
                                                @php($profile_photo_url = $comentario->user->profile_photo_url)
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
                                                        <img
                                                            class="rounded-circle shadow-1-strong me-1 me-md-3 profile_pct"
                                                            src="{{ $profile_photo_url }}" alt="{{ $author_name }}"
                                                            width="65"
                                                            height="65"/>
                                                    </a>
                                                @else
                                                    <img class="rounded-circle shadow-1-strong me-1 me-md-3 profile_pct"
                                                         src="{{ $profile_photo_url }}" alt="{{ $author_name }}"
                                                         width="65"
                                                         height="65"/>
                                                @endif
                                                <div class="flex-grow-1 flex-shrink-1">
                                                    <div>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <p class="mb-1 flex-fill">
                                                                {{ $author_name }}<span
                                                                    class="small text-secondary d-block d-md-inline"> - <a
                                                                        href="#"
                                                                        style="text-decoration: none; color: inherit"
                                                                        data-mdb-tooltip-init
                                                                        title="{{ $fechaComentario->isoFormat('LLLL') }}">{{ $fechaComentario->diffForHumans() }}</a></span>
                                                            </p>
                                                            <div @auth() wire:click="displayReplyForm({{ $comentario->id }})"
                                                                 style="cursor: pointer" @endauth>
                                                                <i class="bi bi-reply me-1"></i><span
                                                                    class="small d-block d-md-inline d-none">Responder</span>
                                                            </div>
                                                            <div class="ms-2">
                                                                <livewire:LikeButton :likeable="$comentario"
                                                                                     :key="'likeButton-' .  $comentario->id"/>
                                                            </div>
                                                        </div>
                                                        <p class="small mb-0">
                                                            {{ $comentario->cuerpo }}
                                                        </p>
                                                    </div>

                                                    @if($showReplyForm === $comentario->id)
                                                        <div class="container text-dark">
                                                            <div class="row d-flex justify-content-center">
                                                                <div class="col-12">
                                                                    <div class="d-flex flex-start w-100 mt-3">
                                                                        <img
                                                                            class="rounded-circle shadow-1-strong me-3 profile_pct"
                                                                            src="{{ auth()->user()->profile_photo_url }}"
                                                                            alt="{{auth()->user()->name}}"
                                                                            width="35"
                                                                            height="35"/>
                                                                        <div class="w-100">
                                                                            <div class="form-outline mb-2">
                                                                            <textarea class="form-control" id="replyBody"
                                                                                      rows="4"
                                                                                      wire:model="replyBody"></textarea>
                                                                            </div>
                                                                            @error('replyBody')
                                                                                <span class="alert alert-danger">{{ $message }}</span>
                                                                            @enderror
                                                                            <div
                                                                                class="d-flex justify-content-end mt-3">
                                                                                <button wire:click="replyToComment"
                                                                                        class="btn btn-outline-light">
                                                                                    Responder <i
                                                                                        class="fas fa-long-arrow-alt-right ms-1"></i>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <!-- Fin comentario -->

                                                    <!-- Inicio respuestas -->
                                                    @foreach($comentario->respuesta as $respuesta)
                                                        @php($fechaRespuesta = \Carbon\Carbon::parse($respuesta->created_at))
                                                        @if($comentario->id == $respuesta->respuestaA)
                                                            @if($respuesta->user)
                                                                @php($author_name = $respuesta->user->name)
                                                            @else
                                                                @php($author_name = "<i>Cuenta Eliminada</i>")
                                                            @endif

                                                            <div class="d-flex flex-start mt-4">
                                                                @if($respuesta->user)
                                                                    <a class="me-3"
                                                                       href="{{ route('users.show', $respuesta->user) }}">
                                                                        <img
                                                                            class="rounded-circle shadow-1-strong profile_pct"
                                                                            src="{{ $respuesta->user->profile_photo_url }}"
                                                                            alt="{{ $author_name }}"
                                                                            width="65" height="65"/>
                                                                    </a>
                                                                @else
                                                                    <img
                                                                        class="rounded-circle shadow-1-strong profile_pct"
                                                                        src="/images/pp.jpg"
                                                                        alt="{{ $author_name }}"
                                                                        width="65" height="65"/>
                                                                @endif
                                                                <div class="flex-grow-1 flex-shrink-1">
                                                                    <div>
                                                                        <div
                                                                            class="d-flex justify-content-between align-items-center">
                                                                            <p class="mb-1">
                                                                                {{ $author_name }}<span
                                                                                    class="small text-secondary d-block d-md-inline"> - <a
                                                                                        href="#"
                                                                                        style="text-decoration: none; color: inherit"
                                                                                        data-mdb-tooltip-init
                                                                                        title="{{ $fechaRespuesta->isoFormat('LLLL') }}">{{ $fechaRespuesta->diffForHumans() }}</a></span>
                                                                            </p>
                                                                            <livewire:LikeButton :likeable="$respuesta"
                                                                                                 :key="'likeButton-' . $respuesta->id"/>
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
                                    @empty
                                        <div class="alert alert-dark">
                                            Todavía no hay comentarios.
                                        </div>
                                    @endforelse
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @guest
        @if($this->comments->count() > 0)
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
                                     src="{{auth()->user()->profile_photo_url}}"
                                     alt="{{auth()->user()->name}}"
                                     width="65"
                                     height="65"/>
                                <div class="w-100">
                                    <h5>Deja un comentario</h5>
                                    <div class="form-outline mb-2">
                                    <textarea class="form-control" id="comment" rows="4"
                                              wire:model="comment"></textarea>
                                    </div>
                                    @if($errors->isNotEmpty())
                                        <div class="alert alert-danger">{{ $errors }}</div>
                                    @endif
                                    <div class="d-flex justify-content-end mt-3">
                                        <button wire:click="postComment" class="btn btn-outline-light">
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
</div>

