<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'size',
        'quantity',
        'price',
    ];

    /**
     * Subtotal untuk item ini
     */
    public function getSubtotalAttribute(): float
    {
        return $this->price * $this->quantity;
    }

    // ========================
    // RELATIONSHIPS
    // ========================

    /**
     * Item milik satu Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Item berelasi ke satu Produk
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
