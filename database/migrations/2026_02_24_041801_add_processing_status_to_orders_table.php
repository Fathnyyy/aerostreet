<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Tambah nilai 'processing' ke ENUM status pada tabel orders.
     * MySQL ENUM tidak bisa diubah via Blueprint::change(), harus pakai raw SQL.
     */
    public function up(): void
    {
        // ALTER COLUMN langsung via raw SQL — paling aman untuk ENUM di MySQL
        DB::statement("
            ALTER TABLE `orders`
            MODIFY COLUMN `status` ENUM(
                'pending',
                'pending_verification',
                'paid',
                'processing',
                'shipped',
                'completed',
                'cancelled'
            ) NOT NULL DEFAULT 'pending'
        ");
    }

    public function down(): void
    {
        // Kembalikan ke ENUM tanpa 'processing'
        DB::statement("
            ALTER TABLE `orders`
            MODIFY COLUMN `status` ENUM(
                'pending',
                'pending_verification',
                'paid',
                'shipped',
                'completed',
                'cancelled'
            ) NOT NULL DEFAULT 'pending'
        ");
    }
};
