@extends('components.pln-layout')

@section('title', 'Profil - SIPEL PLN')
@section('header-title', 'Profil')

@section('content')
<style>
    .bg-pln-gradient {
        background: #008080; /* Match app-header */
    }
    .profile-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        padding: 20px 24px;
        margin-top: -32px;
        position: relative;
        z-index: 10;
        display: flex;
        align-items: center;
        gap: 16px;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .avatar-circle {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background-color: #E6F7F5;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        overflow: hidden;
        border: 4px solid white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .menu-section-title {
        font-size: 13px;
        font-weight: 700;
        color: #008785;
        margin-bottom: 12px;
        margin-top: 24px;
        padding-left: 4px;
    }
    .menu-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }
    .menu-item {
        display: flex;
        align-items: center;
        padding: 16px;
        gap: 16px;
        transition: background 0.2s;
        cursor: pointer;
    }
    .menu-item:hover {
        background: #F9FAFB;
    }
    .menu-item:not(:last-child) {
        border-bottom: 1px solid #F3F4F6;
    }
    .menu-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .menu-icon.green { background: #E6F7F5; color: #008785; }
    .menu-icon.red { background: #FEE2E2; color: #EF4444; }
    
    .menu-text {
        flex: 1;
    }
    .menu-title {
        font-weight: 600;
        color: #1F2937;
        font-size: 15px;
        margin-bottom: 2px;
    }
    .menu-subtitle {
        font-size: 12px;
        color: #6B7280;
    }
    .menu-arrow {
        color: #008785;
    }
    
    .menu-item.logout .menu-title { color: #EF4444; }
    .menu-item.logout .menu-subtitle { color: #F87171; }
    .menu-item.logout .menu-arrow { color: #EF4444; }

    /* Forms container inside accordion */
    .form-container {
        display: none;
        padding: 16px;
        background: #F9FAFB;
        border-top: 1px solid #F3F4F6;
    }
    .form-container.active {
        display: block;
        animation: slideDown 0.2s ease-out;
    }
    
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Override app-content padding so banner touches the edge */
    .app-content {
        padding-top: 0 !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        /* Biarkan padding-bottom bawaan pln-layout agar tidak tertutup navbar */
    }
</style>

<div>
    
    {{-- Header Background Extension --}}
    <div class="bg-pln-gradient w-full h-16"></div>
    
    <div class="px-5">
        {{-- Profile Floating Card --}}
        <div class="profile-card">
            <div class="avatar-circle">
                <svg class="w-10 h-10 text-pln-primary" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
            </div>
            <div class="flex-1 min-w-0">
                <h2 class="text-lg font-bold text-gray-800 truncate">{{ Auth::user()->name }}</h2>
                <p class="text-[13px] text-gray-500 truncate">{{ Auth::user()->email }}</p>
                <span class="inline-block mt-1 px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-[10px] font-bold tracking-wide border border-gray-200">
                    {{ strtoupper(Auth::user()->role) }}
                </span>
            </div>
        </div>
        
        @if(session('status') === 'profile-updated' || session('status') === 'password-updated')
        <div class="mt-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Berhasil menyimpan perubahan!
        </div>
        @endif
        
        {{-- Section: Akun --}}
        <h3 class="menu-section-title">Akun</h3>
        <div class="menu-card">
            
            {{-- Informasi Profil --}}
            <a href="{{ route('profile.edit') }}" class="menu-item block-style" style="text-decoration: none;">
                <div class="menu-icon green">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div class="menu-text">
                    <p class="menu-title">Kelola Profil</p>
                    <p class="menu-subtitle">Ubah informasi profil Anda</p>
                </div>
                <div class="menu-arrow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
            </a>
            
            {{-- Password & Keamanan --}}
            <a href="{{ route('profile.password') }}" class="menu-item block-style" style="text-decoration: none;">
                <div class="menu-icon green">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <div class="menu-text">
                    <p class="menu-title">Password & Keamanan</p>
                    <p class="menu-subtitle">Ubah password akun Anda</p>
                </div>
                <div class="menu-arrow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
            </a>
            
        </div>
        
        {{-- Section: Admin (Hanya jika admin bisa manage user) --}}
        @if(Auth::user()->role == 'admin' && Auth::user()->canManageUsers())
        <h3 class="menu-section-title">Admin</h3>
        <div class="menu-card">
            <a href="{{ route('admin.user.index') }}" class="menu-item block-style" style="display: flex; text-decoration: none;">
                <div class="menu-icon green">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div class="menu-text">
                    <p class="menu-title">Manajemen User</p>
                    <p class="menu-subtitle">Kelola akun pengguna sistem</p>
                </div>
                <div class="menu-arrow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
            </a>
        </div>
        @endif
        
        {{-- Section: Bantuan & Keluar --}}
        <h3 class="menu-section-title">Bantuan</h3>
        <div class="menu-card">
            <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                @csrf
                <div class="menu-item logout" onclick="document.getElementById('logoutForm').submit()">
                    <div class="menu-icon red">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </div>
                    <div class="menu-text">
                        <p class="menu-title">Keluar / Logout</p>
                        <p class="menu-subtitle">Akhiri sesi dan keluar dari aplikasi</p>
                    </div>
                    <div class="menu-arrow">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
