<?php

namespace App\Console\Commands;

use App\Events\DeleteExpiredSuscriptions;
use Illuminate\Console\Command;
use App\Models\Suscripcion;

class SuscriptionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'suscriptions:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Se eliminan de la base de datos todas las solicitudes de suscripción que no hayan sido confirmadas después de 30 días';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $subscriptions = Suscripcion::has('token')->where('created_at', '<=', now()->subDays(30))->get();

        event( new DeleteExpiredSuscriptions($subscriptions));

        Suscripcion::has('token')->where('created_at', '<=', now()->subDays(30))->delete();

        $this->info('Suscripciones expiradas eliminadas correctamente.');
    }
}
