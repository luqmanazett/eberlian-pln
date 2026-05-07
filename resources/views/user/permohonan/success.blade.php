@extends('components.pln-layout')

@section('title', 'Permohonan Berhasil - SIPEL PLN')
@section('header-title', 'Berhasil')

@section('content')
<div class="max-w-lg mx-auto text-center py-6">
    
    {{-- Success Icon --}}
    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
        <span class="text-5xl text-green-600">✓</span>
    </div>
    
    {{-- Success Message --}}
    <h2 class="text-2xl font-bold text-gray-800 mb-3">Permohonan Berhasil Diajukan!</h2>
    <p class="text-gray-600 mb-6">
        ID Register: <strong>{{ $permohonan->id_register ?? ('PMH-' . $permohonan->id) }}</strong>
    </p>
    <p class="text-gray-500 text-sm mb-8">
        Permohonan Anda sedang dalam proses verifikasi. 
        Anda akan mendapatkan notifikasi setelah diverifikasi oleh petugas.
    </p>
    
    {{-- Actions --}}
    <div class="space-y-3">
        <a href="{{ route('user.permohonan.history') }}" class="block w-full btn btn-primary">
            Lihat Riwayat Permohonan
        </a>
        <a href="{{ route('user.dashboard') }}" class="block w-full btn btn-outline">
            Kembali ke Beranda
        </a>
    </div>
    
    {{-- Spacer --}}
    <div class="h-16"></div>
    
  
    
</div>
@endsection