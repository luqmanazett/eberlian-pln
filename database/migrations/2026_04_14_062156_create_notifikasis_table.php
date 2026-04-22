<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifikasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('permohonan_id')->constrained('permohonans')->onDelete('cascade');
            
            $table->enum('jenis_notifikasi', ['approved', 'rejected', 'perlu_perbaikan']);
            $table->text('pesan');
            $table->text('alasan')->nullable();
            $table->boolean('sudah_dibaca')->default(false);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifikasis');
    }
};