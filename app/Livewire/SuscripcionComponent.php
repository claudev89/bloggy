<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Suscripcion;

class SuscripcionComponent extends Component
{
    public $correo;

    public function crearSuscripcion()
    {
        Suscripcion::create(['correo' => $this->correo]);
        session()->flash('suscripcionRealizada', 'Se ha suscrito correctamente ✔. enviamos un correo de confirmación a '.$this->correo. ' que debe aceptar.');
    }

    public function render()
    {
        return view('livewire.suscripcion-component');
    }
}
