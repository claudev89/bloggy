<?php

namespace App\Observers;

use App\Models\Comentario;
use App\Models\Notification;
use App\Models\Post;
use App\Models\User;

class ComentarioObserver
{
    /**
     * Handle the Comentario "created" event.
     */
    public function creating(Comentario $comentario): void
    {
        $crearNotificacion = false;
       if($comentario->respuestaA !== null) {
           $comentarioOriginal = Comentario::find($comentario->respuestaA);
           if($comentarioOriginal->autor !== $comentario->autor) {
               $crearNotificacion = true;
           }
       }
       else {
           $post = Post::find($comentario->post_id);
           if($post->autor !== $comentario->autor) {
               $crearNotificacion = true;
           }
       }
       if($crearNotificacion){
           $notification = Notification::create([
               'user_id' => $comentario->autor,
               'type' => 'c',
               'notifiable_type' => $comentario->respuestaA == null ? 'p' : 'c',
               'notifiable_id' => $comentario->respuestaA == null ? $comentario->post_id : $comentario->respuestaA,
           ]);
           $comentario->notification_id = $notification->id;
           $crearNotificacion = false;
       }
    }

    /**
     * Handle the Comentario "updated" event.
     */
    public function updated(Comentario $comentario): void
    {
        //
    }

    /**
     * Handle the Comentario "deleted" event.
     */
    public function deleted(Comentario $comentario): void
    {
        //
    }

    /**
     * Handle the Comentario "restored" event.
     */
    public function restored(Comentario $comentario): void
    {
        //
    }

    /**
     * Handle the Comentario "force deleted" event.
     */
    public function forceDeleted(Comentario $comentario): void
    {
        //
    }
}
