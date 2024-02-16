<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }

    public function subcategory()
    {
        return $this->hasMany(Category::class, 'parentCategory');
    }

    public function parent_category()
    {
        return $this->belongsTo(Category::class, 'parentCategory');
    }
}
