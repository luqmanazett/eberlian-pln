@extends('components.pln-layout')

@section('title', 'Form Permohonan - SIPEL PLN')
@section('header-title', 'Permohonan')
<div class="max-w-lg mx-auto pb-20">
    
    {{-- Header --}}
    <div class="mb-6">
        <a href="{{ route('user.dashboard') }}" class="text-pln-blue inline-flex items-center gap-1 mb-3">
            <span>←</span> Kembali
        </a>
        <h2 class="text-xl font-bold text-gray-800">
            @if($jenis == 'pasang_baru')
                Form Pasang Baru
            @elseif($jenis == 'tambah_daya')
                Form Tambah Daya
            @else
                Form Peningkatan Keandalan
            @endif
        </h2>
        <p class="text-gray-500 text-sm">Isi data dengan lengkap dan benar</p>
    </div>
    
    {{-- Progress Steps --}}
    <div class="bg-white rounded-xl p-4 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-pln-blue text-white rounded-full flex items-center justify-center text-sm font-bold">1</div>
                <span class="text-sm font-medium">Data Diri</span>
            </div>
            <div class="w-8 h-0.5 bg-gray-300"></div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-gray-300 text-gray-500 rounded-full flex items-center justify-center text-sm">2</div>
                <span class="text-sm text-gray-400">Upload Dokumen</span>
            </div>
            <div class="w-8 h-0.5 bg-gray-300"></div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-gray-300 text-gray-500 rounded-full flex items-center justify-center text-sm">3</div>
                <span class="text-sm text-gray-400">Tanda Tangan</span>
            </div>
        </div>
    </div>
    
    {{-- Form --}}
    <form action="{{ route('user.permohonan.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="jenis_permohonan" value="{{ $jenis }}">
        
        {{-- IDPEL (hanya untuk tambah daya & peningkatan keandalan) --}}
        @if(in_array($jenis, ['tambah_daya', 'peningkatan_keandalan']))
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <label class="block font-medium mb-2">
                IDPEL <span class="text-red-500">*</span>
            </label>
            <input type="text" name="idpel" value="{{ old('idpel') }}" 
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-pln-blue focus:ring-1 focus:ring-pln-blue"
                   placeholder="Masukkan IDPEL" required>
            @error('idpel')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        @endif
        
        {{-- No KTP --}}
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <label class="block font-medium mb-2">
                Nomor KTP <span class="text-red-500">*</span>
            </label>
            <input type="text" name="no_ktp" value="{{ old('no_ktp') }}" 
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-pln-blue focus:ring-1 focus:ring-pln-blue"
                   placeholder="Masukkan 16 digit Nomor KTP" maxlength="16" required>
            @error('no_ktp')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        {{-- Nama Pelanggan --}}
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <label class="block font-medium mb-2">
                Nama Pelanggan <span class="text-red-500">*</span>
            </label>
            <input type="text" name="nama_pelanggan" value="{{ old('nama_pelanggan') }}" 
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-pln-blue focus:ring-1 focus:ring-pln-blue"
                   placeholder="Masukkan nama lengkap" required>
            @error('nama_pelanggan')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        {{-- ULP --}}
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <label class="block font-medium mb-2">
                ULP <span class="text-red-500">*</span>
            </label>
            <select name="ulp" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-pln-blue focus:ring-1 focus:ring-pln-blue" required>
                <option value="">Pilih ULP</option>
                <option value="ULP Jakarta Pusat" {{ old('ulp') == 'ULP Jakarta Pusat' ? 'selected' : '' }}>ULP Jakarta Pusat</option>
                <option value="ULP Jakarta Barat" {{ old('ulp') == 'ULP Jakarta Barat' ? 'selected' : '' }}>ULP Jakarta Barat</option>
                <option value="ULP Jakarta Selatan" {{ old('ulp') == 'ULP Jakarta Selatan' ? 'selected' : '' }}>ULP Jakarta Selatan</option>
                <option value="ULP Jakarta Timur" {{ old('ulp') == 'ULP Jakarta Timur' ? 'selected' : '' }}>ULP Jakarta Timur</option>
                <option value="ULP Jakarta Utara" {{ old('ulp') == 'ULP Jakarta Utara' ? 'selected' : '' }}>ULP Jakarta Utara</option>
            </select>
            @error('ulp')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        {{-- Alamat Gardu --}}
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <label class="block font-medium mb-2">
                Alamat Gardu <span class="text-red-500">*</span>
            </label>
            <textarea name="alamat_gardu" rows="3" 
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-pln-blue focus:ring-1 focus:ring-pln-blue"
                      placeholder="Masukkan alamat gardu lengkap" required>{{ old('alamat_gardu') }}</textarea>
            @error('alamat_gardu')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        {{-- Nama Gardu --}}
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <label class="block font-medium mb-2">
                Nama Gardu <span class="text-red-500">*</span>
            </label>
            <input type="text" name="nama_gardu" value="{{ old('nama_gardu') }}" 
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-pln-blue focus:ring-1 focus:ring-pln-blue"
                   placeholder="Masukkan nama gardu" required>
            @error('nama_gardu')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        {{-- No Telepon --}}
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <label class="block font-medium mb-2">
                Nomor Telepon <span class="text-red-500">*</span>
            </label>
            <input type="tel" name="no_telepon" value="{{ old('no_telepon') }}" 
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-pln-blue focus:ring-1 focus:ring-pln-blue"
                   placeholder="Contoh: 081234567890" required>
            @error('no_telepon')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        {{-- Submit Button --}}
        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4">
            <div class="max-w-lg mx-auto">
                <button type="submit" class="w-full bg-pln-blue text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition">
                    Lanjutkan ke Upload Dokumen
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

