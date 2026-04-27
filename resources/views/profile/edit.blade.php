@extends('components.pln-layout')

@section('title', 'Akun Saya - SIPEL PLN')
@section('header-title', 'Akun Saya')

@section('content')
<div class="space-y-5">
    
    {{-- Header --}}
    <div class="flex items-center gap-3 mb-1">
        <a href="{{ url()->previous() }}" class="text-gray-600">
            <span class="text-2xl">←</span>
        </a>
        <h2 class="text-xl font-bold text-gray-800">Akun Saya</h2>
    </div>
    
    {{-- Profil Info Card --}}
<div class="card" style="padding: 20px;">
    <h3 class="font-semibold text-gray-800 mb-4 text-base">Informasi Profil</h3>
    
    <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
        @csrf
        @method('PATCH')
        
        {{-- Nama (Readonly) --}}
        <div>
            <label class="input-label">Nama Lengkap</label>
            <input type="text" value="{{ Auth::user()->name }}" 
                   class="input-field" style="background: #F3F4F6; color: #6B7280;" readonly disabled>
            <p class="text-xs text-gray-400 mt-1">Nama terdaftar di sistem PLN, tidak dapat diubah</p>
        </div>
        
        {{-- Nomor KTP (Readonly) - DIPINDAHKAN KE SINI --}}
        <div>
            <label class="input-label">Nomor KTP</label>
            <input type="text" value="{{ Auth::user()->no_ktp ?? 'Belum diisi' }}" 
                   class="input-field" style="background: #F3F4F6; color: #6B7280;" readonly disabled>
            <p class="text-xs text-gray-400 mt-1">Nomor KTP terdaftar di sistem</p>
        </div>
        
        {{-- Email --}}
        <div>
            <label class="input-label">Email</label>
            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" 
                   class="input-field" placeholder="Email" required>
            @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        {{-- Nomor Telepon --}}
        <div>
            <label class="input-label">Nomor Telepon</label>
            <input type="tel" name="no_telepon" value="{{ old('no_telepon', Auth::user()->no_telepon) }}" 
                   class="input-field" placeholder="0812-3456-7890">
            @error('no_telepon')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-primary" style="padding: 12px 20px; width: 100%;">
            Simpan Perubahan
        </button>
    </form>
</div>
    
    {{-- Ganti Password Card --}}
    <div class="card" style="padding: 20px;">
        <h3 class="font-semibold text-gray-800 mb-4 text-base">Ganti Password</h3>
        
        @if(session('status') === 'password-updated')
        <div class="bg-green-100 text-green-800 p-3 rounded-lg text-sm mb-4">
            ✅ Password berhasil diubah!
        </div>
        @endif
        
        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label class="input-label">Password Saat Ini</label>
                <input type="password" name="current_password" class="input-field" placeholder="••••••••" required>
                @error('current_password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="input-label">Password Baru</label>
                <input type="password" name="password" class="input-field" placeholder="••••••••" required>
                @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="input-label">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="input-field" placeholder="••••••••" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="padding: 12px 20px; width: 100%;">
                Ganti Password
            </button>
        </form>
    </div>
    
    {{-- Manajemen User (Hanya Admin Utama) --}}
    @if(Auth::user()->role == 'admin' && Auth::user()->canManageUsers())
    <div class="card" style="padding: 20px;">
        <a href="{{ route('admin.user.index') }}" class="flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-gray-800 text-base">👥 Manajemen User</h3>
                <p class="text-sm text-gray-500 mt-1">Kelola akun pengguna sistem</p>
            </div>
            <span class="text-pln-primary text-2xl">→</span>
        </a>
    </div>
    @endif
    
    {{-- Logout Button --}}
    <div class="card" style="padding: 16px 20px;">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn" style="background: #FEE2E2; color: #991B1B; border: none; padding: 12px 20px; width: 100%;">
                🚪 Keluar / Logout
            </button>
        </form>
    </div>
    
    {{-- Info Versi --}}
    <p class="text-center text-xs text-gray-400 py-4">SIPEL PLN v1.0</p>
    
</div>
@endsection