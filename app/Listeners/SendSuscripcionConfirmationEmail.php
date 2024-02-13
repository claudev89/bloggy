<?php

namespace App\Listeners;

use App\Events\SuscripcionTokenCreated;
use App\Mail\ContactoMailable;
use App\Mail\SuscripcionMailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendSuscripcionConfirmationEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SuscripcionTokenCreated $event): void
    {
        Mail::to($event->correo)->send(new SuscripcionMailable($event->token, $event->correo));
    }
}
