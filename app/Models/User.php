<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    public function isAdminUtama(): bool
{
    return $this->role === 'admin' && $this->admin_level === 1;
}

public function isAdminVerifikator(): bool
{
    return $this->role === 'admin' && $this->admin_level === 2;
}

public function canManageUsers(): bool
{
    return $this->isAdminUtama();
}

public function canViewLogs(): bool
{
    return $this->isAdminUtama();
}

public function canExportData(): bool
{
    return $this->isAdminUtama();
}
    use HasFactory, Notifiable;

    protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'admin_level',  // 👈 Tambahkan ini
    'no_telepon',
    'no_ktp',
];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    // 👇 Tambahkan methods ini
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    
    public function isManagement(): bool
    {
        return $this->role === 'management';
    }
    
    public function isUser(): bool
    {
        return $this->role === 'user';
    }
    
    public function permohonans(): HasMany
    {
        return $this->hasMany(Permohonan::class);
    }
    
    public function notifikasis(): HasMany
    {
        return $this->hasMany(Notifikasi::class);
    }
}