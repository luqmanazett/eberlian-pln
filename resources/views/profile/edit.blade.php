@extends('components.pln-layout')

@section('title', 'Kelola Profil - E-Berlian')
@section('header-title', 'Kelola Profil')
@section('back-url', route('profile.index'))

@push('styles')
<style>
    /* Hapus padding bawaan app-content agar background hijau bisa penuh */
    .app-content { 
        padding-top: 0 !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }
    
    .bg-pln-gradient {
        background: #008080; /* Match app-header */
    }
    
    .edit-profile-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 24px;
        margin-top: -30px;
        position: relative;
        z-index: 20;
    }
    
    .avatar-wrapper {
        position: relative;
        width: 90px;
        height: 90px;
        margin: 0 auto;
    }
    .avatar-circle {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background-color: #E6F7F5;
        border: 4px solid white;
        box-shadow: 0 4px 15px rgba(0,128,128,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .avatar-camera {
        position: absolute;
        bottom: 0;
        right: 0;
        background: #008080;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 3px solid white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    .avatar-camera:hover {
        transform: scale(1.05);
    }
</style>
@endpush

@section('content')
<div>
    {{-- Header Background Extension --}}
    <div class="bg-pln-gradient w-full h-16"></div>
    
    <div class="px-5">
        <div class="edit-profile-card">
            
            {{-- Avatar Section --}}
            <div class="avatar-wrapper mb-8">
                <div class="avatar-circle">
                    @if(Auth::user()->avatar)
                        <img id="avatar-preview" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                    @else
                        <img id="avatar-preview" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=008080&color=fff&size=100" alt="Avatar" class="w-full h-full object-cover">
                    @endif
                </div>
                <label for="avatar_upload" class="avatar-camera">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </label>
            </div>

            {{-- Informasi Akun Header --}}
            <div class="flex items-start gap-3 mb-6">
                <div class="text-[#008080] mt-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h3 class="text-[13px] font-bold text-[#008080]">Informasi Akun</h3>
                    <p class="text-[11px] text-gray-500 mt-0.5">Pastikan data Anda sudah sesuai dan selalu diperbarui.</p>
                </div>
            </div>

            @if(session('status') === 'profile-updated')
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>Profil berhasil diperbarui!</span>
            </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PATCH')
                
                <input type="file" name="avatar" id="avatar_upload" class="hidden" accept="image/*" onchange="previewAvatar(event)">
                @error('avatar')<p class="text-red-500 text-[10px] mb-2 text-center">{{ $message }}</p>@enderror
                
                {{-- Nama Lengkap (Read Only) --}}
                <div>
                    <label class="text-[11px] font-bold text-gray-700 mb-1.5 block">Nama Lengkap</label>
                    <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <input type="text" value="{{ Auth::user()->name }}" class="w-full border border-gray-100 rounded-xl py-3.5 pl-11 pr-4 text-[13px] text-gray-600 bg-gray-50 outline-none" readonly disabled>
                    </div>
                    <div class="flex items-center gap-1 mt-1.5 text-gray-400">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <p class="text-[9px]">Sesuai data sistem PLN, tidak dapat diubah</p>
                    </div>
                </div>
                
                {{-- Nomor KTP (Read Only) --}}
                <div>
                    <label class="text-[11px] font-bold text-gray-700 mb-1.5 block">Nomor KTP</label>
                    <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                        </div>
                        <input type="text" value="{{ Auth::user()->no_ktp ?? '1234567890123457' }}" class="w-full border border-gray-100 rounded-xl py-3.5 pl-11 pr-4 text-[13px] text-gray-600 bg-gray-50 outline-none" readonly disabled>
                    </div>
                    <div class="flex items-center gap-1 mt-1.5 text-gray-400">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <p class="text-[9px]">Sesuai data sistem PLN, tidak dapat diubah</p>
                    </div>
                </div>
                
                {{-- Email --}}
                <div>
                    <label class="text-[11px] font-bold text-gray-700 mb-1.5 block">Email</label>
                    <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="w-full border border-gray-200 rounded-xl py-3.5 pl-11 pr-4 text-[13px] text-gray-800 focus:border-[#008080] focus:ring-1 focus:ring-[#008080] outline-none transition" required>
                    </div>
                    @error('email')<p class="text-red-500 text-[10px] mt-1">{{ $message }}</p>@enderror
                </div>
                
                {{-- Nomor Telepon --}}
                <div>
                    <label class="text-[11px] font-bold text-gray-700 mb-1.5 block">Nomor Telepon</label>
                    <div class="relative flex items-center">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <input type="tel" name="no_telepon" value="{{ old('no_telepon', Auth::user()->no_telepon) ?? '081234567891' }}" class="w-full border border-gray-200 rounded-xl py-3.5 pl-11 pr-4 text-[13px] text-gray-800 focus:border-[#008080] focus:ring-1 focus:ring-[#008080] outline-none transition" placeholder="08xx-xxxx-xxxx">
                    </div>
                    @error('no_telepon')<p class="text-red-500 text-[10px] mt-1">{{ $message }}</p>@enderror
                </div>
                
                <div class="pt-2">
                    <button type="submit" class="w-full bg-[#008080] text-white rounded-xl py-3.5 text-[13px] font-bold flex items-center justify-center gap-2 shadow-lg shadow-[#008080]/30 hover:bg-[#006e6d] transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                        Simpan Perubahan
                    </button>
                </div>

                {{-- Alert Box Data Aman --}}
                <div class="bg-[#F0FDF4] border border-[#DCFCE7] rounded-xl p-4 flex gap-3 mt-6">
                    <div class="text-[#059669] mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-[11px] font-bold text-gray-800 mb-1">Data Anda aman bersama kami</h4>
                        <p class="text-[10px] text-gray-600 leading-relaxed">Informasi akun Anda dilindungi dengan sistem keamanan berlapis sesuai standar keamanan PLN.</p>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function previewAvatar(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('avatar-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush
@endsection
