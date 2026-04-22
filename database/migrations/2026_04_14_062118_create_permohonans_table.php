<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permohonans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Data Permohonan
            $table->enum('jenis_permohonan', ['pasang_baru', 'tambah_daya', 'peningkatan_keandalan']);
            $table->string('idpel', 50)->nullable();
            $table->string('no_ktp', 16);
            $table->string('nama_pelanggan');
            $table->string('ulp', 100);
            $table->text('alamat_gardu');
            $table->string('nama_gardu', 100);
            $table->string('no_telepon', 15);
            
            // Path Dokumen
            $table->string('dokumen_ba_lahan');
            $table->string('dokumen_ba_lingkungan');
            $table->string('dokumen_return_agrimen');
            $table->string('dokumen_imb')->nullable();
            $table->string('dokumen_sertifikat_lahan')->nullable();
            
            // Tanda Tangan Elektronik (base64)
            $table->text('ttd_ba_lahan');
            $table->text('ttd_ba_lingkungan');
            
            // Status & Verifikasi
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('catatan_admin')->nullable();
            $table->text('catatan_reject_global')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            
            // Tracking Upload Ulang
            $table->integer('jumlah_perbaikan')->default(0);
            $table->timestamp('tanggal_upload')->useCurrent();
            $table->timestamp('tanggal_reject')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permohonans');
    }
};