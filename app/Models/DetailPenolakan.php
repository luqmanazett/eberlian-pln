<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPenolakan extends Model
{
    protected $table = 'detail_penolakans';
    
    protected $fillable = [
        'permohonan_id', 'dokumen_type', 'ditolak', 'alasan_penolakan',
    ];
    
    protected $casts = [
        'ditolak' => 'boolean',
    ];
    
    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(Permohonan::class);
    }
    
    public static function getDokumenLabels(): array
{
    return [
        'ba_lahan' => 'BA Lahan',
        'ba_lingkungan' => 'BA Lingkungan',
        'return_agrimen' => 'Written Agreement',  // 👈 Ganti di sini
        'imb' => 'IMB (Opsional)',
        'sertifikat_lahan' => 'Sertifikat Lahan (Opsional)',
    ];
}
}