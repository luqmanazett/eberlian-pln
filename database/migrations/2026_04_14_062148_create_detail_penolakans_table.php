<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_penolakans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->constrained('permohonans')->onDelete('cascade');
            
            $table->enum('dokumen_type', [
                'ba_lahan',
                'ba_lingkungan', 
                'return_agrimen',
                'imb',
                'sertifikat_lahan'
            ]);
            
            $table->boolean('ditolak')->default(false);
            $table->text('alasan_penolakan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_penolakans');
    }
};