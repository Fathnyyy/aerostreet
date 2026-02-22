<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'brand',
        'category_id',
        'thumbnail',
        'price',
        'description',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }

    public function sizes()
    {
        return $this->hasMany(\App\Models\ProductSize::class);
    }
}
