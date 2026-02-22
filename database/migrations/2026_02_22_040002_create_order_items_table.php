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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel orders
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->onDelete('cascade');

            // Relasi ke tabel products
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('cascade');

            // Ukuran yang dipilih (snapshot saat checkout)
            $table->string('size');

            // Jumlah item
            $table->unsignedInteger('quantity');

            // Harga saat checkout (snapshot — harga bisa berubah di masa depan)
            $table->decimal('price', 15, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
