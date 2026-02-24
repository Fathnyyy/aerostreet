<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            // Relasi utama
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->constrained()->onDelete('cascade');

            // Konten review
            $table->tinyInteger('rating')->unsigned();          // 1-5 bintang
            $table->string('title')->nullable();                // Judul singkat
            $table->text('body')->nullable();                   // Isi ulasan
            $table->json('photos')->nullable();                 // Array path foto (max 4)

            // Tingkat kepuasan tambahan
            $table->tinyInteger('size_fit')->nullable();        // 1=Kekecilan, 2=Pas, 3=Kebesaran
            $table->boolean('verified_purchase')->default(true);// Selalu true (sudah order)

            // Moderasi
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved');

            // Satu user hanya bisa review satu produk per order
            $table->unique(['user_id', 'product_id', 'order_id']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
