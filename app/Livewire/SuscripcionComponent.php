<?php

namespace App\Livewire;

use App\Events\SuscripcionTokenCreated;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Suscripcion;

class SuscripcionComponent extends Component
{
    public $correo;
    public $showSpinner = false;

    protected $rules = [
        'correo' => 'required|email|unique:suscripcions,correo'
    ];

    public function crearSuscripcion()
    {
        $this->showSpinner = true;
        $this->validate();
        $suscripcion = Suscripcion::create(['correo' => $this->correo]);
        $token = Str::random(60);
        $suscripcion->token()->create(['token' => $token]);
        event(new SuscripcionTokenCreated($token, $this->correo));
        session()->flash('suscripcionRealizada', 'Se ha suscrito correctamente ✔. enviamos un correo de confirmación a '.$this->correo. ' que debe aceptar antes de 30 días.');
        $this->showSpinner = false;
    }

    public function render()
    {
        return view('livewire.suscripcion-component');
    }
}
