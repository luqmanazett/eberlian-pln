<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifikasi extends Model
{
    protected $table = 'notifikasis';
    
    protected $fillable = [
        'user_id', 'permohonan_id', 'jenis_notifikasi', 'pesan', 'alasan', 'sudah_dibaca',
    ];
    
    protected $casts = [
        'sudah_dibaca' => 'boolean',
        'created_at' => 'datetime',  // 👈 TAMBAHKAN INI
    ];
    
    public $timestamps = false;  // Karena kita hanya pakai created_at
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(Permohonan::class);
    }
}