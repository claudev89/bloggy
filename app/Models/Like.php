<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Like extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function likeable()
    {
        return $this->morphTo()->withDefault();
    }


}
