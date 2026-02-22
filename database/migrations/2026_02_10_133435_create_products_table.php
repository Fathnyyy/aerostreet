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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Nama Sepatu
        $table->string('slug')->unique(); // URL: aerostreet-hoops-low
        $table->string('brand'); // Brand Name (Nike, Adidas, etc)
        $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Terhubung ke kategori
        
        $table->string('thumbnail'); // Foto Utama (Depan)
        $table->decimal('price', 10, 2); // Harga (149900.00)
        $table->text('description'); // Penjelasan produk
        $table->enum('status', ['active', 'draft', 'archived'])->default('active'); // Status jualan
        
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
