<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Relasi ke User
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Nomor order unik (e.g. KL-20260222-XXXX)
            $table->string('order_number')->unique();

            // Total harga order (termasuk pajak, dll)
            $table->decimal('total_price', 15, 2);

            // Metode pembayaran
            $table->enum('payment_method', ['midtrans', 'manual']);

            // Status order
            $table->enum('status', [
                'pending',               // Baru dibuat, menunggu pembayaran
                'pending_verification',  // Manual: bukti sudah diupload, menunggu konfirmasi admin
                'paid',                  // Sudah terkonfirmasi lunas
                'shipped',               // Sudah dikirim
                'completed',             // Order selesai
                'cancelled',             // Dibatalkan
            ])->default('pending');

            // Upload bukti transfer (hanya untuk manual)
            $table->string('payment_proof')->nullable();

            // Snap Token dari Midtrans (hanya untuk midtrans)
            $table->string('snap_token')->nullable();

            // Transaction ID dari Midtrans untuk tracking callback
            $table->string('midtrans_transaction_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
