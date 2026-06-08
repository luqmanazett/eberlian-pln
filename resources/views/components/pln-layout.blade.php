<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'E-Berlian')</title>
    
    {{-- Font Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
    --pln-primary: #24beac;
    --pln-primary-dark: #359A8F;
    --pln-primary-light: #D4F5F0;
    --pln-yellow: #FFD100;
    --pln-yellow-dark: #E6BC00;
    --pln-blue: #005B9F;
    --pln-success: #10B981;
    --pln-warning: #D97706;
    --pln-danger: #EF4444;
    --pln-info: #3B82F6;
    --pln-gray-bg: #F5F7FA;
    --pln-text-dark: #1F2937;
    --pln-text-gray: #6B7280;
    --safe-bottom: env(safe-area-inset-bottom, 0px);
}
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--pln-gray-bg);
            color: var(--pln-text-dark);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        
        .mobile-container {
            width: 100%;
            background-color: var(--pln-gray-bg);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        /* Header */
        .app-header {
            background: #008080;
            color: white;
            padding: 12px 16px;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .app-header h1 {
            font-size: 18px;
            font-weight: 700;
            color: white;
        }
        
        /* Content Area */
        .app-content {
            padding: 16px;
            flex: 1;
            display: flex;
            flex-direction: column;
            padding-bottom: calc(80px + var(--safe-bottom)); /* Add padding back for fixed bottom nav */
        }
        
        /* Custom Scrollbar for app-content */
        .app-content::-webkit-scrollbar {
            width: 4px;
        }
        .app-content::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        
        /* Cards */
        .card {
            background: white;
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .card-stat {
            background: white;
            border-radius: 12px;
            padding: 12px 8px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 14px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
            width: 100%;
            text-decoration: none;
        }
        
        .btn-primary {
            background: var(--pln-primary);
            color: white;
        }
        
        .btn-primary:active {
            background: var(--pln-primary-dark);
        }
        
        .btn-secondary {
            background: white;
            color: var(--pln-text-dark);
            border: 1.5px solid #E5E7EB;
        }
        
        .btn-success {
            background: var(--pln-success);
            color: white;
        }
        
        .btn-outline {
            background: transparent;
            color: var(--pln-text-dark);
            border: 1.5px solid #E5E7EB;
        }
        
        /* Form inputs */
        .input-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 6px;
            color: var(--pln-text-dark);
        }
        
        .input-label .required {
            color: var(--pln-danger);
        }
        
        .input-field {
            width: 100%;
            padding: 14px 16px;
            border: 1.5px solid #E5E7EB;
            border-radius: 12px;
            font-size: 16px;
            background: white;
            transition: border-color 0.2s;
        }
        
        .input-field:focus {
            outline: none;
            border-color: var(--pln-primary);
            box-shadow: 0 0 0 3px rgba(0,128,128,0.15);
        }
        
        /* Bottom Navigation */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            background: white;
            border-top: 1px solid #E5E7EB;
            padding: 8px 16px;
            padding-bottom: calc(8px + var(--safe-bottom));
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            box-shadow: 0 -2px 10px rgba(0,0,0,0.05);
            z-index: 40;
        }
        
        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #9CA3AF;
            font-size: 12px;
            transition: color 0.2s;
        }
        
       .nav-item.active {
    color: var(--pln-primary);  /* Hijau Tosca #008080 */
}

.nav-item.active span:last-child {
    color: var(--pln-primary) !important;
    font-weight: 600;
}
        
        .nav-item span:first-child {
            font-size: 22px;
            margin-bottom: 2px;
        }
        
        .nav-item img {
            filter: grayscale(100%) brightness(0.8);
            transition: filter 0.2s;
        }
        
       .nav-item.active img {
    filter: brightness(0) saturate(100%) invert(36%) sepia(67%) saturate(442%) hue-rotate(141deg) brightness(94%) contrast(101%);
}
        
        .nav-item.active span:last-child {
    color: var(--pln-primary) !important;
    font-weight: 600;
}
        
        /* Status Badges */
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .badge-pending {
            background: #FEF3C7;
            color: #92400E;
        }
        
        .badge-approved {
            background: #D1FAE5;
            color: #065F46;
        }
        
        .badge-rejected {
            background: #FEE2E2;
            color: #991B1B;
        }
        
        .badge-info {
            background: #DBEAFE;
            color: #1E40AF;
        }
        
        /* Step Progress */
        .step-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 0;
        }
        
        .step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
        }
        
        .step-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 4px;
            background: #E5E7EB;
            color: #9CA3AF;
        }
        
        .step-circle.active {
            background: var(--pln-primary);
            color: white;
        }
        
        .step-circle.completed {
            background: var(--pln-success);
            color: white;
        }
        
        .step-label {
            font-size: 12px;
            text-align: center;
            color: #9CA3AF;
        }
        
        .step-label.active {
            color: var(--pln-text-dark);
            font-weight: 500;
        }
        
        .step-line {
            flex: 1;
            height: 2px;
            background: #E5E7EB;
            margin: 0 4px;
            margin-bottom: 24px;
        }
        
        .step-line.completed {
            background: var(--pln-success);
        }
        
        /* Toast Notification */
        .toast {
            position: fixed;
            bottom: 100px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--pln-text-dark);
            color: white;
            padding: 12px 20px;
            border-radius: 30px;
            font-size: 14px;
            max-width: 90%;
            z-index: 100;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        /* File upload preview */
        .file-preview {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px;
            background: #F9FAFB;
            border-radius: 12px;
            margin-top: 8px;
        }
        
        /* Notification badge */
        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: var(--pln-danger);
            color: white;
            font-size: 10px;
            font-weight: 600;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Text colors */
        .text-pln-primary { color: var(--pln-primary); }
        .bg-pln-primary { background-color: var(--pln-primary); }
        .border-pln-primary { border-color: var(--pln-primary); }
        
        /* Gradient Background untuk Welcome Card */
        .bg-gradient-welcome {
            background: linear-gradient(135deg, var(--pln-primary) 0%, var(--pln-primary-dark) 100%);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="mobile-container">
        {{-- Header --}}
        <header class="app-header">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    @hasSection('back-url')
                        <a href="@yield('back-url')" class="text-white hover:bg-white/20 p-1.5 rounded-lg transition mr-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        </a>
                    @else
                        {{-- Logo PLN --}}
                        @if(file_exists(public_path('images/pln-logo.png')))
                        <img src="{{ asset('images/pln-logo.png') }}" alt="PLN" style="height: 32px; width: auto;">
                        @else
                        <span style="background: white; color: var(--pln-primary); font-weight: bold; padding: 4px 8px; border-radius: 6px; font-size: 14px;">PLN</span>
                        @endif
                    @endif
                    <div>
                        <h1 style="line-height: 1.2;">@yield('header-title', 'E-Berlian')</h1>
                        @hasSection('header-subtitle')
                        <p style="font-size: 11px; color: rgba(255,255,255,0.8); line-height: 1.2; font-weight: 400;">@yield('header-subtitle')</p>
                        @endif
                    </div>
                </div>
                
               @auth
<div class="flex items-center gap-3">
    @if(Auth::user()->role == 'user')
    <a href="{{ route('user.notifikasi.index') }}" class="relative">
        @if(file_exists(public_path('images/notifikasi/icon-notifikasi.png')))
        <img src="{{ asset('images/notifikasi/icon-notifikasi.png') }}" alt="Notifikasi" style="width: 24px; height: 24px;">
        @else
        <span class="text-white text-xl">🔔</span>
        @endif
        <span id="notification-badge" class="notification-badge hidden">0</span>
    </a>
    @endif
    
    @if(Auth::user()->role == 'admin')
    <a href="{{ route('admin.notifikasi.index') }}" class="relative">
        @if(file_exists(public_path('images/notifikasi/icon-notifikasi.png')))
        <img src="{{ asset('images/notifikasi/icon-notifikasi.png') }}" alt="Notifikasi" style="width: 24px; height: 24px;">
        @else
        <span class="text-white text-xl">🔔</span>
        @endif
        <span id="admin-notification-badge" class="notification-badge hidden">0</span>
    </a>
    @endif
</div>
@endauth
            </div>
        </header>
        
        {{-- Content --}}
        <div class="app-content">
            @if(session('success'))
            <div class="toast" id="toast-success">
                {{ session('success') }}
            </div>
            @endif
            
            @if(session('error'))
            <div class="toast" id="toast-error" style="background: var(--pln-danger);">
                {{ session('error') }}
            </div>
            @endif
            
            @yield('content')
            
            {{-- Copyright - Kecuali di halaman Riwayat --}}
            @php
                $hideCopyright = request()->routeIs('user.permohonan.history');
            @endphp
            
            @if(!$hideCopyright)
            <div style="text-align: center; padding: 8px 0; margin-top: auto; margin-bottom: 16px;">
                <p style="font-size: 11px; color: #9CA3AF; margin: 0;">Sistem dibangun oleh Luqmanazet - Tim Magang 2026</p>
            </div>
            @endif
        </div>
        
        {{-- Bottom Navigation untuk USER --}}
        @auth
        @if(Auth::user()->role == 'user')
        <nav class="bottom-nav" style="padding: 6px 16px;">
            
            <a href="{{ route('user.dashboard') }}" class="nav-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                <span style="display: flex; flex-direction: column; align-items: center; gap: 2px;">
                    @if(file_exists(public_path('images/bottom-nav/home.png')))
                    <img src="{{ asset('images/bottom-nav/home.png') }}" alt="Beranda" style="width: 20px; height: 20px; object-fit: contain;">
                    @else
                    <span style="font-size: 20px;">🏠</span>
                    @endif
                    <span style="font-size: 11px;">Beranda</span>
                </span>
            </a>
            
            <a href="{{ route('user.permohonan.create') }}" class="nav-item {{ request()->routeIs('user.permohonan.*') && !request()->routeIs('user.permohonan.history') ? 'active' : '' }}">
                <span style="display: flex; flex-direction: column; align-items: center; gap: 2px;">
                    @if(file_exists(public_path('images/bottom-nav/permohonan.png')))
                    <img src="{{ asset('images/bottom-nav/permohonan.png') }}" alt="Permohonan" style="width: 20px; height: 20px; object-fit: contain;">
                    @else
                    <span style="font-size: 20px;">📝</span>
                    @endif
                    <span style="font-size: 11px;">Permohonan</span>
                </span>
            </a>
            
            <a href="{{ route('user.permohonan.history') }}" class="nav-item {{ request()->routeIs('user.permohonan.history') ? 'active' : '' }}">
                <span style="display: flex; flex-direction: column; align-items: center; gap: 2px;">
                    @if(file_exists(public_path('images/bottom-nav/riwayat.png')))
                    <img src="{{ asset('images/bottom-nav/riwayat.png') }}" alt="Riwayat" style="width: 20px; height: 20px; object-fit: contain;">
                    @else
                    <span style="font-size: 20px;">📋</span>
                    @endif
                    <span style="font-size: 11px;">Riwayat</span>
                </span>
            </a>
            
            <a href="{{ route('profile.index') }}" class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <span style="display: flex; flex-direction: column; align-items: center; gap: 2px;">
                    @if(file_exists(public_path('images/bottom-nav/akun.png')))
                    <img src="{{ asset('images/bottom-nav/akun.png') }}" alt="Akun" style="width: 20px; height: 20px; object-fit: contain;">
                    @else
                    <span style="font-size: 20px;">👤</span>
                    @endif
                    <span style="font-size: 11px;">Akun</span>
                </span>
            </a>
            
        </nav>
        @endif
        @endauth
        
       {{-- Bottom Navigation untuk ADMIN --}}
@auth
@if(Auth::user()->role == 'admin')
<nav class="bottom-nav" style="padding: 6px 16px; grid-template-columns: repeat({{ Auth::user()->admin_level == 1 ? '4' : '3' }}, 1fr);">
    
    {{-- Dashboard --}}
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <span style="display: flex; flex-direction: column; align-items: center; gap: 2px;">
            @if(file_exists(public_path('images/bottom-nav/admin/dashboard.png')))
            <img src="{{ asset('images/bottom-nav/admin/dashboard.png') }}" alt="Dashboard" style="width: 20px; height: 20px; object-fit: contain;">
            @else
            <span style="font-size: 20px;">🏠</span>
            @endif
            <span style="font-size: 11px;">Dashboard</span>
        </span>
    </a>
    
    {{-- Permohonan --}}
    <a href="{{ route('admin.verifikasi.index') }}" class="nav-item {{ request()->routeIs('admin.verifikasi.*') ? 'active' : '' }}">
        <span style="display: flex; flex-direction: column; align-items: center; gap: 2px;">
            @if(file_exists(public_path('images/bottom-nav/admin/permohonan.png')))
            <img src="{{ asset('images/bottom-nav/admin/permohonan.png') }}" alt="Permohonan" style="width: 20px; height: 20px; object-fit: contain;">
            @else
            <span style="font-size: 20px;">📄</span>
            @endif
            <span style="font-size: 11px;">Permohonan</span>
        </span>
    </a>
    
    {{-- Eksport Data - HANYA ADMIN UTAMA (LEVEL 1) --}}
@if(Auth::user()->admin_level == 1)
<a href="{{ route('admin.export.index') }}" class="nav-item {{ request()->routeIs('admin.export.*') ? 'active' : '' }}">
    <span style="display: flex; flex-direction: column; align-items: center; gap: 2px;">
        @if(file_exists(public_path('images/bottom-nav/export.png')))
        <img src="{{ asset('images/bottom-nav/export.png') }}" alt="Eksport Data" style="width: 20px; height: 20px; object-fit: contain;">
        @else
        <span style="font-size: 20px;">📥</span>
        @endif
        <span style="font-size: 11px;">Eksport Data</span>
    </span>
</a>
@endif
    
    {{-- Profil --}}
    <a href="{{ route('profile.index') }}" class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
        <span style="display: flex; flex-direction: column; align-items: center; gap: 2px;">
            @if(file_exists(public_path('images/bottom-nav/admin/profil.png')))
            <img src="{{ asset('images/bottom-nav/admin/profil.png') }}" alt="Profil" style="width: 20px; height: 20px; object-fit: contain;">
            @else
            <span style="font-size: 20px;">👤</span>
            @endif
            <span style="font-size: 11px;">Profil</span>
        </span>
    </a>
    
</nav>
@endif
@endauth
    </div>
    
    <script>
        // Auto-hide toast
        setTimeout(() => {
            const toast = document.getElementById('toast-success') || document.getElementById('toast-error');
            if (toast) {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s';
                setTimeout(() => toast?.remove(), 300);
            }
        }, 3000);
        
        // Notification badge untuk User
        @auth
        @if(Auth::user()->role == 'user')
        function updateNotificationBadge() {
            fetch('{{ route("user.notifikasi.unread") }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('notification-badge');
                    if (badge) {
                        if (data.count > 0) {
                            badge.textContent = data.count > 9 ? '9+' : data.count;
                            badge.classList.remove('hidden');
                        } else {
                            badge.classList.add('hidden');
                        }
                    }
                })
                .catch(err => console.log('Notifikasi error:', err));
        }
        document.addEventListener('DOMContentLoaded', updateNotificationBadge);
        setInterval(updateNotificationBadge, 30000);
        @endif
        @endauth
        
        // Notification badge untuk Admin
        @auth
        @if(Auth::user()->role == 'admin')
        function updateAdminNotificationBadge() {
            fetch('{{ route("admin.notifikasi.unread") }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('admin-notification-badge');
                    if (badge) {
                        if (data.count > 0) {
                            badge.textContent = data.count > 9 ? '9+' : data.count;
                            badge.classList.remove('hidden');
                        } else {
                            badge.classList.add('hidden');
                        }
                    }
                })
                .catch(err => console.log('Notifikasi Admin error:', err));
        }
        document.addEventListener('DOMContentLoaded', updateAdminNotificationBadge);
        setInterval(updateAdminNotificationBadge, 30000);
        @endif
        @endauth
    </script>
    
    @stack('scripts')
</body>
</html>
