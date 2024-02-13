<?php

namespace App\Listeners;

use App\Events\DeleteExpiredSuscriptions;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\DeleteSubscriptionNotification;

class SendSuscriptionExpiredNotification
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
    public function handle(DeleteExpiredSuscriptions $event): void
    {
        foreach ($event->subscriptions as $subscription)
        {
            Mail::to($subscription->correo)->send(new DeleteSubscriptionNotification($subscription));
        }
    }
}
