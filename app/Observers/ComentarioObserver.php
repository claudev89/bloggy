<?php

namespace App\Observers;

use App\Models\Comentario;

class ComentarioObserver
{
    /**
     * Handle the Comentario "created" event.
     */
    public function created(Comentario $comentario): void
    {
        //
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
