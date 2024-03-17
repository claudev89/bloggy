<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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

    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    public function likes()
    {
        return $this->belongsTo(Like::class);
    }

    public function postAuthor(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, Post::class);
    }

    public function commentAuthor(): BelongsTo
    {
        return $this->comentarios->belongsTo(User::class, 'autor');
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->morphTo('notifiable');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->whereHasMorph('notifiable', [Post::class, Comentario::class], function ($query, $type) use ($userId) {
            $query->whereHas('user', function ($query) use ($userId) {
                $query->where('id', $userId);
            });
        });
    }

}
