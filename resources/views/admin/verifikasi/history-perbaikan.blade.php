@extends('components.pln-layout')

@section('title', 'History Perbaikan - SIPEL PLN')
@section('header-title', 'Riwayat Perbaikan')

@section('content')
<div class="space-y-4 pb-20">
    
    {{-- Header --}}
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('admin.verifikasi.show', $permohonan->id) }}" class="text-gray-600">
            <span class="text-2xl">←</span>
        </a>
        <h2 class="text-xl font-bold text-gray-800">Riwayat Perbaikan</h2>
    </div>
    
    {{-- Info Pemohon --}}
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="font-semibold">{{ $permohonan->nama_pelanggan }}</p>
                <p class="text-sm text-gray-500">ID: #{{ str_pad($permohonan->id, 11, '0', STR_PAD_LEFT) }}</p>
            </div>
            <span class="badge badge-info">Total Perbaikan: {{ $permohonan->jumlah_perbaikan }}/3</span>
        </div>
    </div>
    
    {{-- List Versi Perbaikan --}}
    @forelse($riwayatPerbaikan as $riwayat)
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-3">
            <div>
                <h3 class="font-semibold">
                    Versi {{ $riwayat->versi_ke }}
                    @if($riwayat->versi_ke == $permohonan->jumlah_perbaikan && $permohonan->status == 'pending')
                    <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full ml-2">Terbaru</span>
                    @endif
                </h3>
                <p class="text-sm text-gray-500">
                    {{ $riwayat->submitted_at->format('d M Y - H:i') }}
                </p>
                <p class="text-sm text-gray-500">
                    Oleh: {{ $riwayat->user->name }}
                </p>
            </div>
            <div>
                @if($riwayat->status_perbaikan == 'submitted')
                <span class="badge badge-pending">Menunggu</span>
                @elseif($riwayat->status_perbaikan == 'approved')
                <span class="badge badge-approved">Disetujui</span>
                @else
                <span class="badge badge-rejected">Ditolak</span>
                @endif
            </div>
        </div>
        
        {{-- Alasan Penolakan Sebelumnya --}}
        <div class="bg-red-50 p-3 rounded-lg mb-3">
            <p class="text-sm font-medium text-red-800">Alasan Penolakan Sebelumnya:</p>
            <p class="text-sm text-red-700">{{ $riwayat->alasan_penolakan_sebelumnya }}</p>
        </div>
        
        {{-- Dokumen yang Diperbaiki --}}
        <div>
            <p class="text-sm font-medium text-gray-700 mb-2">Dokumen yang Diperbaiki:</p>
            <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                @foreach($riwayat->dokumen_yang_diperbaiki as $dokumen)
                <li>
                    {{ \App\Models\DetailPenolakan::getDokumenLabels()[$dokumen] }}
                    @if(isset($riwayat->dokumen_yang_ditolak[$dokumen]))
                    <br><span class="text-xs text-red-600 ml-5">Alasan: {{ $riwayat->dokumen_yang_ditolak[$dokumen] }}</span>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-xl p-8 text-center">
        <p class="text-gray-500">Belum ada riwayat perbaikan</p>
    </div>
    @endforelse
    
</div>
@endsection