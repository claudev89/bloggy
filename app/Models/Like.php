<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function likeable()
    {
        return $this->morphTo()->withDefault();
    }

    public function notifications()
    {
        return $this->hasOne(Notification::class);
    }


}
