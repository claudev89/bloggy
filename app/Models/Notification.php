<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->belongsTo(Post::class);
    }

    public function comentarios()
    {
        return $this->belongsTo(Comentario::class);
    }

    public function likes()
    {
        return $this->belongsTo(Like::class);
    }
}
