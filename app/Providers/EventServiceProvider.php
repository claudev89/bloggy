<?php

namespace App\Providers;

use App\Events\DeleteExpiredSuscriptions;
use App\Events\SuscripcionTokenCreated;
use App\Listeners\SendSuscripcionConfirmationEmail;
use App\Listeners\SendSuscriptionExpiredNotification;
use App\Models\Comentario;
use App\Models\Like;
use App\Observers\ComentarioObserver;
use App\Observers\LikeObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SuscripcionTokenCreated::class => [
            SendSuscripcionConfirmationEmail::class
        ],
        DeleteExpiredSuscriptions::class => [SendSuscriptionExpiredNotification::class],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Like::observe(LikeObserver::class);
        Comentario::observe(ComentarioObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
