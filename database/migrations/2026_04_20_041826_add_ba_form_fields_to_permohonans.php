<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            // Opsi untuk BA Lahan
            $table->enum('ba_lahan_type', ['upload', 'form'])->nullable();
            $table->json('ba_lahan_data')->nullable(); // Data form BA Lahan
            
            // Opsi untuk BA Lingkungan
            $table->enum('ba_lingkungan_type', ['upload', 'form'])->nullable();
            $table->json('ba_lingkungan_data')->nullable(); // Data form BA Lingkungan
        });
    }

    public function down(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $table->dropColumn(['ba_lahan_type', 'ba_lahan_data', 'ba_lingkungan_type', 'ba_lingkungan_data']);
        });
    }
};