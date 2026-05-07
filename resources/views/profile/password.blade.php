@extends('components.pln-layout')

@section('title', 'Password & Keamanan - SIPEL PLN')
@section('header-title', 'Password & Keamanan')
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
    
    .password-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 32px 24px;
        margin-top: -60px;
        position: relative;
        z-index: 20;
    }
</style>
@endpush

@section('content')
<div>
    {{-- Header Background Extension --}}
    <div class="bg-pln-gradient w-full h-16"></div>
    
    <div class="px-5">
        <div class="password-card">
        
        {{-- Icon Shield Top --}}
        <div class="flex flex-col items-center mb-8">
            <div class="relative w-20 h-20 bg-[#E6F7F5] rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-[#008080]" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div class="absolute bottom-0 right-0 bg-[#008080] text-white w-6 h-6 rounded-full flex items-center justify-center border-2 border-white">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                </div>
            </div>
            <h2 class="text-[17px] font-bold text-gray-800">Ubah Password</h2>
            <p class="text-[11px] text-gray-500 text-center mt-1 px-4">Pastikan password baru Anda kuat dan tidak mudah ditebak.</p>
        </div>

        @if(session('status') === 'password-updated')
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-xs flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>Password berhasil diperbarui!</span>
        </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            @method('PUT')
            
            {{-- Password Saat Ini --}}
            <div>
                <label class="text-[11px] font-bold text-gray-700 mb-1.5 block">Password Saat Ini</label>
                <div class="relative flex items-center">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <input type="password" id="current_password" name="current_password" class="w-full border border-gray-200 rounded-xl py-3.5 pl-11 pr-11 text-[13px] text-gray-700 focus:border-[#008080] focus:ring-1 focus:ring-[#008080] outline-none transition" placeholder="Masukkan password saat ini" required>
                    <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-[#008080] transition" onclick="togglePassword('current_password', this)">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                    </button>
                </div>
                @error('current_password')<p class="text-red-500 text-[10px] mt-1">{{ $message }}</p>@enderror
            </div>
            
            {{-- Password Baru --}}
            <div class="mt-5">
                <label class="text-[11px] font-bold text-gray-700 mb-1.5 block">Password Baru</label>
                <div class="relative flex items-center">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <input type="password" id="password" name="password" class="w-full border border-gray-200 rounded-xl py-3.5 pl-11 pr-11 text-[13px] text-gray-700 focus:border-[#008080] focus:ring-1 focus:ring-[#008080] outline-none transition" placeholder="Minimal 8 karakter" onkeyup="checkStrength(this.value)" required>
                    <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-[#008080] transition" onclick="togglePassword('password', this)">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                    </button>
                </div>
                @error('password')<p class="text-red-500 text-[10px] mt-1 mb-0">{{ $message }}</p>@enderror
                
                {{-- Password Strength --}}
                <div class="flex justify-between items-center mt-3 mb-1.5">
                    <span class="text-[9px] text-gray-400 font-bold uppercase tracking-wider">Kekuatan Password</span>
                    <span id="strength-text" class="text-[9px] text-gray-400 font-bold">Belum diisi</span>
                </div>
                <div class="flex gap-1.5">
                    <div id="str-1" class="h-1.5 flex-1 bg-gray-200 rounded-full transition-colors duration-300"></div>
                    <div id="str-2" class="h-1.5 flex-1 bg-gray-200 rounded-full transition-colors duration-300"></div>
                    <div id="str-3" class="h-1.5 flex-1 bg-gray-200 rounded-full transition-colors duration-300"></div>
                    <div id="str-4" class="h-1.5 flex-1 bg-gray-200 rounded-full transition-colors duration-300"></div>
                    <div id="str-5" class="h-1.5 flex-1 bg-gray-200 rounded-full transition-colors duration-300"></div>
                </div>
            </div>
            
            {{-- Konfirmasi Password --}}
            <div class="pt-2">
                <label class="text-[11px] font-bold text-gray-700 mb-1.5 block">Konfirmasi Password Baru</label>
                <div class="relative flex items-center">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="w-full border border-gray-200 rounded-xl py-3.5 pl-11 pr-11 text-[13px] text-gray-700 focus:border-[#008080] focus:ring-1 focus:ring-[#008080] outline-none transition" placeholder="Masukkan ulang password baru" required>
                    <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-[#008080] transition" onclick="togglePassword('password_confirmation', this)">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                    </button>
                </div>
            </div>
            
            {{-- Tips Box --}}
            <div class="bg-[#F0FDF4] border border-[#DCFCE7] rounded-xl p-4 flex gap-3 my-6">
                <div class="text-[#059669] mt-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div>
                    <h4 class="text-[11px] font-bold text-gray-800 mb-1.5">Tips membuat password yang kuat</h4>
                    <ul class="text-[10px] text-gray-600 space-y-1 list-disc pl-3 marker:text-[#059669]">
                        <li>Gunakan minimal 8 karakter</li>
                        <li>Kombinasikan huruf besar, huruf kecil, angka, dan simbol</li>
                        <li>Hindari informasi pribadi (nama, tanggal lahir, dll.)</li>
                    </ul>
                </div>
            </div>
            
            <button type="submit" class="w-full bg-[#008080] text-white rounded-xl py-3.5 text-[13px] font-bold flex items-center justify-center gap-2 shadow-lg shadow-[#008080]/30 hover:bg-[#006e6d] transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Ganti Password
            </button>
        </form>
    </div>
</div>

<script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const iconEyeOff = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>';
        const iconEye = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>';
        
        if (input.type === 'password') {
            input.type = 'text';
            btn.innerHTML = iconEye;
            btn.style.color = '#008080';
        } else {
            input.type = 'password';
            btn.innerHTML = iconEyeOff;
            btn.style.color = '#9CA3AF';
        }
    }
    
    function checkStrength(pwd) {
        const bars = [
            document.getElementById('str-1'),
            document.getElementById('str-2'),
            document.getElementById('str-3'),
            document.getElementById('str-4'),
            document.getElementById('str-5')
        ];
        const text = document.getElementById('strength-text');
        
        // Reset all
        bars.forEach(bar => bar.className = 'h-1.5 flex-1 bg-gray-200 rounded-full transition-colors duration-300');
        
        if (!pwd) {
            text.textContent = 'Belum diisi';
            text.style.color = '#9CA3AF';
            return;
        }
        
        let strength = 0;
        if (pwd.length >= 8) strength += 1;
        if (pwd.match(/[a-z]+/)) strength += 1;
        if (pwd.match(/[A-Z]+/)) strength += 1;
        if (pwd.match(/[0-9]+/)) strength += 1;
        if (pwd.match(/[$@#&!]+/)) strength += 1;
        
        const colors = ['#EF4444', '#F59E0B', '#F59E0B', '#10B981', '#059669'];
        const labels = ['Sangat Lemah', 'Lemah', 'Sedang', 'Kuat', 'Sangat Kuat'];
        
        if(strength === 0) strength = 1;
        
        for (let i = 0; i < strength; i++) {
            bars[i].style.backgroundColor = colors[strength-1];
            bars[i].classList.remove('bg-gray-200');
        }
        
        text.textContent = labels[strength-1];
        text.style.color = colors[strength-1];
    }
</script>
@endsection
