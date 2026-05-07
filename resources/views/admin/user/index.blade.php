@extends('components.pln-layout')

@section('title', 'Manajemen User - SIPEL PLN')
@section('header-title', 'Manajemen User')

@section('content')
<style>
    /* Custom Styles for the Mockup Match */
    .bg-pln-gradient {
        background: linear-gradient(135deg, #005B9F 0%, #008785 100%);
        position: relative;
    }
    .wave-bg {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: auto;
        opacity: 0.15;
    }
    .stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 16px;
        border-bottom: 4px solid transparent;
        transition: transform 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-2px);
    }
    .stat-card.total { border-bottom-color: #24beac; }
    .stat-card.user { border-bottom-color: #3B82F6; }
    .stat-card.admin { border-bottom-color: #8B5CF6; }
    .stat-card.management { border-bottom-color: #10B981; }
    
    .stat-icon-wrapper {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .stat-card.total .stat-icon-wrapper { background: #E6F7F5; color: #24beac; }
    .stat-card.user .stat-icon-wrapper { background: #EFF6FF; color: #3B82F6; }
    .stat-card.admin .stat-icon-wrapper { background: #F5F3FF; color: #8B5CF6; }
    .stat-card.management .stat-icon-wrapper { background: #ECFDF5; color: #10B981; }
    
    .filter-container {
        background: #fff;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }
    
    .table-container {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.03);
        overflow: hidden;
    }
    
    .avatar-img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #E5E7EB;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #6B7280;
        object-fit: cover;
    }
    
    .role-badge {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }
    .role-badge.user { background: #EFF6FF; color: #3B82F6; }
    .role-badge.admin { background: #F5F3FF; color: #8B5CF6; }
    .role-badge.management { background: #ECFDF5; color: #10B981; }
    
    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid;
        transition: all 0.2s;
        cursor: pointer;
    }
    .action-btn.edit { border-color: #A7F3D0; color: #10B981; background: #fff; }
    .action-btn.edit:hover { background: #ECFDF5; }
    .action-btn.reset { border-color: #BFDBFE; color: #3B82F6; background: #fff; }
    .action-btn.reset:hover { background: #EFF6FF; }
    .action-btn.delete { border-color: #FECACA; color: #EF4444; background: #fff; }
    .action-btn.delete:hover { background: #FEF2F2; }
    
    .btn-teal {
        background-color: #24beac;
        color: white;
        border-radius: 8px;
        font-weight: 600;
        transition: background 0.2s;
    }
    .btn-teal:hover { background-color: #1a9c8d; }
    
    /* Overriding layout padding to allow full width banner */
    .content-wrapper {
        padding: 0 !important;
    }
</style>

<div class="">
    
    {{-- Header Banner Area --}}
    <div class="bg-pln-gradient text-white px-4 pt-6 pb-20 rounded-b-[40px] relative overflow-hidden">
        {{-- Decorative towers SVG (simulated with paths) --}}
        <svg class="wave-bg" viewBox="0 0 1440 320" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,160L48,176C96,192,192,224,288,213.3C384,203,480,149,576,144C672,139,768,181,864,197.3C960,213,1056,203,1152,176C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z" fill="rgba(255,255,255,0.1)"></path>
        </svg>
        
        <div class="relative z-10 flex flex-col gap-4">
            <div class="flex justify-between items-start">
                <div class="flex items-start gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="mt-1 text-white hover:text-gray-200 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    </a>
                    <div>
                        <h1 class="text-xl font-bold mb-1">Manajemen User</h1>
                        <p class="text-white/80 text-[11px]">Kelola semua akun pengguna</p>
                    </div>
                </div>
                <a href="{{ route('admin.user.create') }}" class="btn-teal px-3 py-2 text-xs flex items-center gap-1 shadow-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah
                </a>
            </div>
        </div>
    </div>
    
    {{-- Stats Cards (Overlapping banner) --}}
    <div class="px-4 -mt-12 relative z-20 mb-6">
        <div class="grid grid-cols-2 gap-3">
            {{-- Total --}}
            <div class="stat-card total p-3 gap-3">
                <div class="stat-icon-wrapper w-10 h-10">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-semibold text-gray-500 mb-0.5">Total</p>
                    <h3 class="text-xl font-bold text-gray-800 leading-none">{{ number_format($stats['total'], 0, ',', '.') }}</h3>
                </div>
            </div>
            
            {{-- Admin --}}
            <div class="stat-card admin p-3 gap-3">
                <div class="stat-icon-wrapper w-10 h-10">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-semibold text-gray-500 mb-0.5">Admin</p>
                    <h3 class="text-xl font-bold text-gray-800 leading-none">{{ number_format($stats['admin'], 0, ',', '.') }}</h3>
                </div>
            </div>
            
            {{-- User --}}
            <div class="stat-card user p-3 gap-3">
                <div class="stat-icon-wrapper w-10 h-10">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-semibold text-gray-500 mb-0.5">User</p>
                    <h3 class="text-xl font-bold text-gray-800 leading-none">{{ number_format($stats['user'], 0, ',', '.') }}</h3>
                </div>
            </div>
            
            {{-- Management --}}
            <div class="stat-card management p-3 gap-3">
                <div class="stat-icon-wrapper w-10 h-10">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-semibold text-gray-500 mb-0.5">Manage</p>
                    <h3 class="text-xl font-bold text-gray-800 leading-none">{{ number_format($stats['management'], 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>
    
    <div class="px-4">
        {{-- Filter Section --}}
        <div class="filter-container mb-6">
            <form method="GET" class="flex flex-col gap-3">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <select name="role" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-xs focus:outline-none focus:border-pln-primary">
                            <option value="">Semua Role</option>
                            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="management" {{ request('role') == 'management' ? 'selected' : '' }}>Management</option>
                        </select>
                    </div>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               class="w-full border border-gray-200 rounded-lg pl-3 pr-8 py-2 text-xs focus:outline-none focus:border-pln-primary" 
                               placeholder="Cari user...">
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="btn-teal px-4 py-2 flex-1 text-xs flex items-center justify-center gap-1">
                        Filter
                    </button>
                    <a href="{{ route('admin.user.index') }}" class="border border-gray-200 text-gray-600 rounded-lg px-4 py-2 flex-1 text-xs flex items-center justify-center gap-1 hover:bg-gray-50 transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>
        
        {{-- User List (Mobile Card Layout) --}}
        <div class="flex flex-col gap-3">
            @forelse($users as $index => $user)
            <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm flex flex-col gap-3">
                <div class="flex items-start justify-between gap-2">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <div class="avatar-img shadow-sm border border-gray-100 flex-shrink-0">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="font-bold text-gray-800 text-sm leading-tight truncate">{{ $user->name }}</p>
                            <p class="text-[11px] text-gray-500 mt-0.5 truncate">{{ $user->email }}</p>
                        </div>
                    </div>
                    <span class="role-badge {{ $user->role }} flex-shrink-0">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
                
                <div class="pt-3 border-t border-gray-50 flex items-center justify-between">
                    <span class="text-xs text-gray-500 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        {{ $user->no_telepon ?? '-' }}
                    </span>
                    <div class="flex items-center gap-1.5">
                        <a href="{{ route('admin.user.edit', $user->id) }}" class="action-btn edit" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <button onclick="openResetModal({{ $user->id }}, '{{ addslashes($user->name) }}')" class="action-btn reset" title="Reset Password">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                        </button>
                        @if($user->id != Auth::id())
                        <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?')" class="inline-block m-0 p-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn delete" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-xl border border-gray-100 p-8 text-center text-gray-500 shadow-sm">
                <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <p class="text-sm">Belum ada data user</p>
            </div>
            @endforelse
            
            {{-- Pagination --}}
            @if($users->hasPages())
            <div class="mt-4 flex justify-center">
                {{ $users->appends(request()->query())->links() }}
            </div>
            @else
            <div class="mt-2 text-center text-[11px] text-gray-500">
                Menampilkan {{ $users->count() }} dari {{ $stats['total'] }} data
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Modal Reset Password --}}
<div id="resetModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[24px] w-full max-w-md p-6 shadow-xl">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-xl font-bold text-gray-800">Reset Password</h3>
            <button onclick="closeResetModal()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <p class="text-sm text-gray-500 mb-6">Reset password untuk: <span id="resetUserName" class="font-semibold text-gray-800"></span></p>
        
        <form id="resetForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Password Baru</label>
                <input type="password" name="password" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:border-pln-primary focus:ring-1 focus:ring-pln-primary outline-none" required minlength="8" placeholder="Minimal 8 karakter">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:border-pln-primary focus:ring-1 focus:ring-pln-primary outline-none" required placeholder="Masukkan ulang password">
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeResetModal()" class="w-full py-3 rounded-xl border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition">Batal</button>
                <button type="submit" class="w-full py-3 rounded-xl bg-pln-primary text-white font-semibold hover:bg-[#1a9c8d] transition shadow-lg shadow-pln-primary/30">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openResetModal(id, name) {
        document.getElementById('resetUserName').textContent = name;
        document.getElementById('resetForm').action = '/admin/user/' + id + '/reset-password';
        document.getElementById('resetModal').classList.remove('hidden');
        document.getElementById('resetModal').classList.add('flex');
    }
    function closeResetModal() {
        document.getElementById('resetModal').classList.add('hidden');
        document.getElementById('resetModal').classList.remove('flex');
    }
</script>
@endsection
