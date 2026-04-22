<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            // Ubah dokumen menjadi nullable
            $table->string('dokumen_ba_lahan')->nullable()->change();
            $table->string('dokumen_ba_lingkungan')->nullable()->change();
            $table->string('dokumen_return_agrimen')->nullable()->change();
            $table->string('dokumen_imb')->nullable()->change();
            $table->string('dokumen_sertifikat_lahan')->nullable()->change();
            
            // Ubah ttd menjadi nullable
            $table->text('ttd_ba_lahan')->nullable()->change();
            $table->text('ttd_ba_lingkungan')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $table->string('dokumen_ba_lahan')->nullable(false)->change();
            $table->string('dokumen_ba_lingkungan')->nullable(false)->change();
            $table->string('dokumen_return_agrimen')->nullable(false)->change();
            $table->string('dokumen_imb')->nullable()->change();
            $table->string('dokumen_sertifikat_lahan')->nullable()->change();
            
            $table->text('ttd_ba_lahan')->nullable(false)->change();
            $table->text('ttd_ba_lingkungan')->nullable(false)->change();
        });
    }
};