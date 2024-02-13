<?php

namespace App\Http\Controllers;

use App\Models\SuscripcionToken;
use Illuminate\Http\Request;

class SuscripcionController extends Controller
{
    public function confirmSuscription($token)
    {
        $suscriptionToken = SuscripcionToken::where('token', $token)->first();

        if($suscriptionToken){
            $suscriptionToken->delete();
            session()->flash('suscrito', '¡Tu suscripción fue confirmada exitosamente!.');
            return(redirect()->to('/'));
        } else {
            session()->flash('noSuscrito', 'El enlace de confirmación no es válido.');
            return(redirect()->to('/'));
        }
    }
}
