<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_price',
        'payment_method',
        'status',
        'payment_proof',
        'snap_token',
        'midtrans_transaction_id',
    ];

    /**
     * Generate nomor order unik
     * Format: KL-YYYYMMDD-XXXX (e.g. KL-20260222-A3F9)
     */
    public static function generateOrderNumber(): string
    {
        do {
            $number = 'KL-' . date('Ymd') . '-' . strtoupper(Str::random(4));
        } while (self::where('order_number', $number)->exists());

        return $number;
    }

    /**
     * Label friendly untuk status
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'              => 'Menunggu Pembayaran',
            'pending_verification' => 'Menunggu Verifikasi',
            'paid'                 => 'Pembayaran Dikonfirmasi',
            'processing'           => 'Sedang Dikemas',
            'shipped'              => 'Dalam Pengiriman',
            'completed'            => 'Selesai',
            'cancelled'            => 'Dibatalkan',
            default                => ucfirst($this->status),
        };
    }

    /**
     * Warna badge untuk status
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending'              => 'yellow',
            'pending_verification' => 'blue',
            'paid'                 => 'green',
            'processing'           => 'blue',
            'shipped'              => 'indigo',
            'completed'            => 'emerald',
            'cancelled'            => 'red',
            default                => 'gray',
        };
    }

    // ========================
    // RELATIONSHIPS
    // ========================

    /**
     * Order milik satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Order memiliki banyak OrderItem
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class);
    }

    /** Apakah order ini bisa diulas (shipped atau completed) */
    public function getCanReviewAttribute(): bool
    {
        return in_array($this->status, ['shipped', 'completed']);
    }
}
