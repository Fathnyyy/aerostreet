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
            'pending'              => 'Awaiting Payment',
            'pending_verification' => 'Verifying Payment',
            'paid'                 => 'Payment Confirmed',
            'shipped'              => 'Shipped',
            'completed'            => 'Completed',
            'cancelled'            => 'Cancelled',
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
}
