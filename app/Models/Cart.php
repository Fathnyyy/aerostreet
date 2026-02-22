<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'size',
        'quantity',
    ];

    // Relasi ke User (Milik siapa?)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Produk (Barang apa?)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
