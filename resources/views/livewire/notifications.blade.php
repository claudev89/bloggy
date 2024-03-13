<div>
    @auth
        @php($user = \App\Models\User::find(auth()->id()))
        @php($notifications = \App\Models\Notification::forUser($user->id)->latest()->get())


        <li class="nav-item dropdown mt-1" id="notificaciones">
            <button class="btn btn-dark- dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false">
                <i class="bi bi-bell-fill"></i>
                @if($notifications->count()>0)
                    @if($notifications->where('read', 0)->count()>0)
                        <span
                            class="position-absolute top-0 start-90 translate-middle badge rounded-pill bg-danger">
                                                    {{ $notifications->where('read', 0)->count() }}
                                                </span>
                    @endif
                @endif
            </button>
            <ul class="dropdown-menu dropdown-menu-dark" style="width: 22rem;">

                @php($action = "")
                @php($element = "")
                @php($donde = "")
                @php($postN = "")

                @forelse($notifications as $notification)
                    @if($notification->notifiable_type == 'p')
                        @php($postN = \App\Models\Post::find($notification->notifiable_id))
                    @else
                        @php($comentario = \App\Models\Comentario::find($notification->notifiable_id))
                        @if(isset($comentario->respuestaA))
                            @php($originalComment = \App\Models\Comentario::find($comentario->respuestaA))
                            @php($postN = \App\Models\Post::find($originalComment->post_id))
                        @else
                            @php($postN = \App\Models\Post::find($comentario->post_id))
                        @endif
                    @endif
                    @php($authorNotification = \App\Models\User::find($notification->user_id))
                    @if($notification->type == 'l')
                        @php($action = " <i class='bi bi-chat-square-heart'></i> le ha dado like a tu ")
                        @if($notification->notifiable_type == 'p')
                            @php($element = "publicación.")
                        @else
                            @php($comment = \App\Models\Comentario::find($notification->notifiable_id))
                            @if(!isset($comment->respuestaA))
                                @php($element = "comentario ")
                            @else
                                @php($comentarioOriginal = \App\Models\Comentario::find($comment->respuestaA))
                                @if($comentarioOriginal->autor === $user->id)
                                    @php($element = "tu respuesta a tu propio comentario ")
                                @elseif($comentarioOriginal->autor === $authorNotification->id)
                                    @php($element = "tu respuesta a su comentario ")
                                @else
                                    @php($element = "tu respuesta al comentario de <a href='".route('users.show', $comentarioOriginal->user)."' class='text-reset' style='text-decoration: none'><b>".$comentarioOriginal->user->name." </b></a>")
                                @endif
                            @endif
                        @endif
                    @endif

                    @if($notification->type == 'c')
                        @php($comment = \App\Models\Comentario::find($notification->notifiable_id))
                        @if($notification->notifiable_type == 'p')
                            @php($action = " <i class='bi bi-chat-square'></i> ha comentado tu ")
                            @php($element = "publicación.")
                        @else
                            @php($action = " <i class='bi bi-reply'></i> ha respondido tu ")
                            @php($element = "comentario ")
                        @endif
                    @endif

                        @if($postN->autor === $user->id)
                            @php($donde = "en tu publicación.")
                        @elseif($postN->autor === $authorNotification->id)
                            @php($donde = "en tu publicación.")
                        @else
                            @php($donde = "en la publicación de <a href='".route('users.show', $postN->user)."' class='text-reset' style='text-decoration: none'><b>".$postN->user->name."</b></a>")
                        @endif
                    @if($element == "publicación.")
                        @php($donde = "")
                    @endif
                    <li><a class="dropdown-item p-0" href="#">
                            <div wire:key="{{$notification->id}}"
                                class="card p-0 ist-group-item list-group-item-action {{ $notification->read === 0 ? 'bg-secondary border-dark' :''}}">
                                <div class="card-body p-1">
                                    <a href="#">
                                        <div class="row"
                                             onclick="window.location.href = '{{ route('notifications.show', ['notification' => $notification->id, 'postId' => $postN->id]) }}';"
                                             style="cursor: pointer;">
                                            <div class="col-3 pe-0"><a
                                                    href="{{ route('users.show', $authorNotification) }}"><img
                                                        class="w-100 rounded-circle"
                                                        src="{{ $authorNotification->profile_photo_url }}"></a>
                                            </div>
                                            <div class="col text-reset ps-2">
                                                <strong><a
                                                        href="{{ route('users.show', $authorNotification) }}"
                                                        class="text-reset"
                                                        style="text-decoration: none">{{ $authorNotification->name }} </a></strong><br>
                                                {!!$action!!} {!! $element !!} {!! $donde !!}<br>
                                                <span
                                                    class="small text-secondary">{{ $notification->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </a></li>
                @empty
                    <p class="alert alert-dark">No tienes notificaciones.<p/>
                @endforelse

                <div class="mt-2 d-flex justify-content-center align-items-center">
                    <button class="btn btn-outline-light btn-sm">
                        Ver todas las notificaciones
                    </button>
                </div>
            </ul>
        </li>

    @endauth
</div>
