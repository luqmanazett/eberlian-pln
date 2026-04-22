<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_perbaikans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->constrained('permohonans')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->integer('versi_ke');
            $table->json('dokumen_yang_diperbaiki');
            $table->json('dokumen_yang_ditolak')->nullable();
            $table->text('alasan_penolakan_sebelumnya');
            
            $table->enum('status_perbaikan', ['draft', 'submitted', 'approved', 'rejected'])->default('submitted');
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_perbaikans');
    }
};