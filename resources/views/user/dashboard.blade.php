@extends('components.pln-layout')

@section('title', 'Beranda - SIPEL PLN')
@section('header-title', 'SIPEL PLN')

@section('content')
{{-- Background Hijau Gradient --}}
<div style="margin: -16px -16px 0 -16px; padding: 16px 16px 0 16px; background: linear-gradient(to bottom, #059669 0%, #D1FAE5 40%, #F5F7FA 100%);">
    
    {{-- Welcome Card - UJUNG TAJAM (border-radius: 0) --}}
    <div style="background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); display: flex; align-items: stretch; overflow: hidden;">
        
        {{-- Teks Welcome --}}
        <div style="flex: 1; padding: 16px;">
            <h2 style="font-size: 20px; font-weight: 700; color: #1F2937; margin: 0 0 4px 0;">
                Halo, {{ explode(' ', Auth::user()->name)[0] }}
            </h2>
            <p style="font-size: 14px; color: #6B7280; margin: 0;">
                Selamat datang di SIPEL PLN
            </p>
        </div>
        
        {{-- Ilustrasi PLN - Setinggi Card --}}
        <div style="display: flex; align-items: center; justify-content: center; background: linear-gradient(to left, #D1FAE5, white); padding: 0 12px;">
            @if(file_exists(public_path('images/pln-illustration.png')))
            <img src="{{ asset('images/pln-illustration.png') }}" alt="PLN" style="height: 80px; width: auto; display: block;">
            @else
            <div style="display: flex; align-items: center; gap: 3px;">
                <span style="font-size: 40px;">👨‍🔧</span>
                <span style="font-size: 30px;">⚡</span>
            </div>
            @endif
        </div>
        
    </div>
    
</div>
{{-- Content Normal --}}
<div class="space-y-4 mt-4">
    
    {{-- Ringkasan Permohonan - Grid 2x2 --}}
<div style="margin-top: 16px; margin-bottom: 8px;">
    <h3 class="font-semibold text-gray-800 mb-3 text-base">Ringkasan Permohonan</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            
            {{-- Total Permohonan --}}
            <div style="background: white; border-radius: 12px; padding: 12px 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.04); border: 1px solid #f0f0f0; display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: #DBEAFE; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #2563EB; font-size: 20px;">📊</div>
                <div>
                    <p style="font-size: 20px; font-weight: bold; color: #1F2937; margin: 0;">{{ $stats['total_permohonan'] ?? 0 }}</p>
                    <p style="font-size: 12px; color: #6B7280; margin: 0;">Total Permohonan</p>
                </div>
            </div>
            
            {{-- Menunggu Verifikasi --}}
            <div style="background: white; border-radius: 12px; padding: 12px 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.04); border: 1px solid #f0f0f0; display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: #FEF3C7; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #D97706; font-size: 20px;">⏳</div>
                <div>
                    <p style="font-size: 20px; font-weight: bold; color: #D97706; margin: 0;">{{ $stats['pending'] ?? 0 }}</p>
                    <p style="font-size: 12px; color: #6B7280; margin: 0;">Menunggu</p>
                </div>
            </div>
            
            {{-- Disetujui --}}
            <div style="background: white; border-radius: 12px; padding: 12px 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.04); border: 1px solid #f0f0f0; display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: #D1FAE5; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #059669; font-size: 20px;">✅</div>
                <div>
                    <p style="font-size: 20px; font-weight: bold; color: #059669; margin: 0;">{{ $stats['approved'] ?? 0 }}</p>
                    <p style="font-size: 12px; color: #6B7280; margin: 0;">Disetujui</p>
                </div>
            </div>
            
            {{-- Ditolak --}}
            <div style="background: white; border-radius: 12px; padding: 12px 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.04); border: 1px solid #f0f0f0; display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: #FEE2E2; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #DC2626; font-size: 20px;">❌</div>
                <div>
                    <p style="font-size: 20px; font-weight: bold; color: #DC2626; margin: 0;">{{ $stats['rejected'] ?? 0 }}</p>
                    <p style="font-size: 12px; color: #6B7280; margin: 0;">Ditolak</p>
                </div>
            </div>
            
        </div>
    </div>
    
   {{-- Menu Utama - List Vertical --}}
<div style="margin-top: 16px; margin-bottom: 8px;">
    <h3 class="font-semibold text-gray-800 mb-3 text-base">Buat Permohonan Baru</h3>
    <div class="space-y-2">
        
        {{-- Pasang Baru --}}
        <a href="{{ route('user.permohonan.create', ['jenis' => 'pasang_baru']) }}" class="card flex items-center gap-3 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-2xl">🔌</div>
            <div class="flex-1">
                <h4 class="font-semibold text-gray-800 text-base">Pasang Baru</h4>
                <p class="text-sm text-gray-500">Instalasi listrik baru</p>
            </div>
            <div style="width: 32px; height: 32px; background: #059669; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <span style="color: white; font-size: 22px; font-weight: 300; line-height: 1;">+</span>
            </div>
        </a>
        
        {{-- Tambah Daya --}}
        <a href="{{ route('user.permohonan.create', ['jenis' => 'tambah_daya']) }}" class="card flex items-center gap-3 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600 text-2xl">⚡</div>
            <div class="flex-1">
                <h4 class="font-semibold text-gray-800 text-base">Tambah Daya</h4>
                <p class="text-sm text-gray-500">Upgrade kapasitas listrik</p>
            </div>
            <div style="width: 32px; height: 32px; background: #059669; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <span style="color: white; font-size: 22px; font-weight: 300; line-height: 1;">+</span>
            </div>
        </a>
        
        {{-- Peningkatan Keandalan --}}
        <a href="{{ route('user.permohonan.create', ['jenis' => 'peningkatan_keandalan']) }}" class="card flex items-center gap-3 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-2xl">🛡️</div>
            <div class="flex-1">
                <h4 class="font-semibold text-gray-800 text-base">Peningkatan Keandalan</h4>
                <p class="text-sm text-gray-500">Peningkatan sistem kelistrikan</p>
            </div>
            <div style="width: 32px; height: 32px; background: #059669; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <span style="color: white; font-size: 22px; font-weight: 300; line-height: 1;">+</span>
            </div>
        </a>
        
    </div>
</div>
    
   {{-- Riwayat Terbaru --}}
<div>
    <div class="flex items-center justify-between mb-3">
        <h3 class="font-semibold text-gray-800 text-base">Riwayat Terbaru</h3>
        <a href="{{ route('user.permohonan.history') }}" class="text-sm font-medium" style="color: #059669;">Lihat semua →</a>
    </div>
    
    @php
        $recentPermohonans = App\Models\Permohonan::where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->limit(3)
            ->get();
    @endphp
    
    <div class="space-y-2">
        @forelse($recentPermohonans as $permohonan)
        <a href="{{ route('user.permohonan.show', $permohonan->id) }}" class="card flex items-center justify-between">
            <div>
                <p class="font-medium text-gray-800">{{ $permohonan->nama_pelanggan }}</p>
                <p class="text-sm text-gray-500">
                    @if($permohonan->jenis_permohonan == 'pasang_baru')
                        Pasang Baru
                    @elseif($permohonan->jenis_permohonan == 'tambah_daya')
                        Tambah Daya
                    @else
                        Peningkatan Keandalan
                    @endif
                    • {{ $permohonan->created_at->format('d M Y - H:i') }}
                </p>
            </div>
            <div>
                @if($permohonan->status == 'pending')
                <span class="badge badge-pending">Menunggu</span>
                @elseif($permohonan->status == 'approved')
                <span class="badge badge-approved">Disetujui</span>
                @else
                <span class="badge badge-rejected">Ditolak</span>
                @endif
            </div>
        </a>
        @empty
        <div class="card text-center py-6">
            <p class="text-gray-500">Belum ada riwayat permohonan</p>
        </div>
        @endforelse
    </div>
</div>
</div>
@endsection