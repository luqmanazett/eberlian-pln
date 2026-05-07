<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permohonan extends Model
{
    protected $table = 'permohonans';
    
    protected $fillable = [
        'user_id',
        'jenis_permohonan',
        'id_register',
        'idpel',
        'no_ktp',
        'nama_pelanggan',
        'ulp',
        'alamat_gardu',
        'nama_gardu',
        'no_telepon',
        
        // BA Lahan
        'ba_lahan_type',
        'ba_lahan_data',
        'dokumen_ba_lahan',
        
        // BA Lingkungan
        'ba_lingkungan_type',
        'ba_lingkungan_data',
        'dokumen_ba_lingkungan',
        
        // Dokumen lainnya
        'dokumen_return_agrimen',
        'dokumen_imb',
        'dokumen_sertifikat_lahan',
        
        // Tanda Tangan
        'ttd_ba_lahan',
        'ttd_ba_lingkungan',
        
        // Status & Verifikasi
        'status',
        'catatan_admin',
        'catatan_reject_global',
        'approved_at',
        'rejected_at',
        'approved_by',
        
        // Tracking
        'jumlah_perbaikan',
        'tanggal_upload',
        'tanggal_reject',
    ];
    
    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'tanggal_upload' => 'datetime',
        'tanggal_reject' => 'datetime',
        'ba_lahan_data' => 'array',
        'ba_lingkungan_data' => 'array',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    
    public function detailPenolakan(): HasMany
    {
        return $this->hasMany(DetailPenolakan::class);
    }
    
    public function notifikasi(): HasMany
    {
        return $this->hasMany(Notifikasi::class);
    }
    
    public function riwayatPerbaikan(): HasMany
    {
        return $this->hasMany(RiwayatPerbaikan::class);
    }
    
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
    
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
    
    public function canUploadUlang(): bool
    {
        if ($this->jumlah_perbaikan >= 3) {
            return false;
        }
        
        if ($this->tanggal_reject) {
            $deadline = $this->tanggal_reject->addHours(24);
            if (now()->gt($deadline)) {
                return false;
            }
        }
        
        return true;
    }
    
    public function getDokumenDitolak(): array
    {
        return $this->detailPenolakan()
            ->where('ditolak', true)
            ->pluck('dokumen_type')
            ->toArray();
    }
}