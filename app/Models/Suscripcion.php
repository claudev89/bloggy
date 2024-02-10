<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suscripcion extends Model
{
    use HasFactory;
    protected $fillable = ['correo'];

    public function token()
    {
        return $this->hasOne(SuscripcionToken::class);
    }
}
