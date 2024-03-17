<?php

namespace App\Http\Middleware;

use App\Models\Comentario;
use App\Models\Post;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Notification;

class CheckNotificationOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Se supone que este middleware hace que sólo el autor de un post o comentario al que se le está dando
        // like o comentando, pueda marcar como leídas las notificaciones de ése.

        /*
        if($request->route('notification')) {
            $user = auth()->user();
            $notificationId = $request->route('notification');
            $notification = Notification::findOrFail($notificationId);

            if($notification->notifiable_type == 'p')
            {
                $post = Post::findOrFail($notification->notifiable_id);
                $destinatarioId = $post->autor;
            }
            if($notification->notifiable_type == 'c')
            {
                $comentario = Comentario::findOrFail($notification->notifiable_id);
                $destinatarioId = $comentario->autor;
            }
            if($user->id !== $destinatarioId)
            {
                return "no puedes vel esto";
            }
        }
        */

        return $next($request);
    }
}
