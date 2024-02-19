<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'autor');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function respuesta()
    {
        return $this->hasMany(Comentario::class, 'respuestaA');
    }
}
