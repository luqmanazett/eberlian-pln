<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatPerbaikan extends Model
{
    protected $table = 'riwayat_perbaikans';
    
    protected $fillable = [
        'permohonan_id', 'user_id', 'versi_ke', 'dokumen_yang_diperbaiki',
        'dokumen_yang_ditolak', 'alasan_penolakan_sebelumnya', 'status_perbaikan',
        'submitted_at', 'reviewed_at',
    ];
    
    protected $casts = [
        'dokumen_yang_diperbaiki' => 'array',
        'dokumen_yang_ditolak' => 'array',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];
    
    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(Permohonan::class);
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}