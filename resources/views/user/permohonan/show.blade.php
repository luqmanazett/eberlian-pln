@extends('components.pln-layout')

@section('title', 'Detail Permohonan - SIPEL PLN')
@section('header-title', 'Detail Permohonan')

@section('content')
<div class="space-y-4 pb-20">
    
    {{-- Header --}}
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ url()->previous() }}" class="text-gray-600">
            <span class="text-2xl">←</span>
        </a>
        <h2 class="text-xl font-bold text-gray-800">Detail Permohonan</h2>
    </div>
    
    {{-- Status Card --}}
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-semibold text-gray-800">
                ID Register: {{ $permohonan->id_register ?? ('PMH-' . $permohonan->id) }}
            </h3>
            @if($permohonan->status == 'pending')
            <span class="badge badge-pending">Menunggu</span>
            @elseif($permohonan->status == 'approved')
            <span class="badge badge-approved">Disetujui</span>
            @else
            <span class="badge badge-rejected">Ditolak</span>
            @endif
        </div>
        
        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500">Jenis Permohonan</span>
                <span class="font-medium">
                    @if($permohonan->jenis_permohonan == 'pasang_baru') Pasang Baru
                    @elseif($permohonan->jenis_permohonan == 'tambah_daya') Tambah Daya
                    @else Peningkatan Keandalan @endif
                </span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Nama Pelanggan</span>
                <span class="font-medium">{{ $permohonan->nama_pelanggan }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">No KTP</span>
                <span class="font-medium">{{ $permohonan->no_ktp }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">ID Register</span>
                <span class="font-medium">{{ $permohonan->id_register ?? ('PMH-' . $permohonan->id) }}</span>
            </div>
            @if($permohonan->idpel)
            <div class="flex justify-between">
                <span class="text-gray-500">IDPEL</span>
                <span class="font-medium">{{ $permohonan->idpel }}</span>
            </div>
            @endif
            <div class="flex justify-between">
                <span class="text-gray-500">ULP</span>
                <span class="font-medium">{{ $permohonan->ulp }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Tanggal Pengajuan</span>
                <span class="font-medium">{{ $permohonan->created_at->format('d M Y - H:i') }}</span>
            </div>
        </div>
    </div>
    
   {{-- Alasan Penolakan (Jika ditolak) --}}
@if($permohonan->status == 'rejected')
<div class="bg-red-50 rounded-xl p-4 border border-red-200">
    <h4 class="font-bold text-red-800 mb-2">📋 Catatan Penolakan</h4>
    
    @if($permohonan->catatan_reject_global)
    <p class="text-sm text-red-700 font-medium">{{ $permohonan->catatan_reject_global }}</p>
    @else
    <p class="text-sm text-red-700 font-medium italic">Silakan perbaiki dokumen yang ditolak di bawah ini.</p>
    @endif
    
    {{-- Detail dokumen yang ditolak --}}
    @if($permohonan->detailPenolakan->where('ditolak', true)->count() > 0)
    <div class="mt-3 pt-3 border-t border-red-200">
        <p class="font-medium text-red-800 mb-2">Dokumen yang perlu diperbaiki:</p>
        <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
            @foreach($permohonan->detailPenolakan->where('ditolak', true) as $detail)
            <li>
                <span class="font-medium">{{ \App\Models\DetailPenolakan::getDokumenLabels()[$detail->dokumen_type] ?? $detail->dokumen_type }}</span>
                @if($detail->alasan_penolakan)
                <br><span class="text-xs text-red-600 ml-5">Alasan: {{ $detail->alasan_penolakan }}</span>
                @endif
            </li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
@endif
    
    {{-- Tombol Upload Ulang (Jika ditolak dan masih bisa) --}}
    @if($permohonan->status == 'rejected' && $permohonan->canUploadUlang())
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
        <a href="{{ route('user.upload-ulang', $permohonan->id) }}" class="btn btn-primary">
            📤 Upload Ulang Dokumen
        </a>
        <p class="text-xs text-gray-500 mt-2 text-center">
            Batas waktu: {{ $permohonan->tanggal_reject->addHours(24)->format('d M Y H:i') }}
            (Sisa {{ $permohonan->tanggal_reject->addHours(24)->diffForHumans() }})
        </p>
    </div>
    @endif
    
    {{-- Info jika sudah tidak bisa upload ulang --}}
    @if($permohonan->status == 'rejected' && !$permohonan->canUploadUlang())
    <div class="bg-yellow-50 rounded-xl p-4 border border-yellow-200">
        <p class="text-yellow-800 text-sm">
            @if($permohonan->jumlah_perbaikan >= 3)
            ⚠️ Anda sudah mencapai batas maksimal 3 kali upload ulang. Silakan hubungi petugas PLN.
            @else
            ⚠️ Batas waktu 24 jam untuk upload ulang sudah habis. Silakan hubungi petugas PLN.
            @endif
        </p>
    </div>
    @endif
    
    {{-- Catatan Admin (Jika disetujui) --}}
    @if($permohonan->status == 'approved' && $permohonan->catatan_admin)
    <div class="bg-green-50 rounded-xl p-4 border border-green-200">
        <h4 class="font-semibold text-green-800 mb-2">Catatan Admin</h4>
        <p class="text-sm text-green-700">{{ $permohonan->catatan_admin }}</p>
    </div>
    @endif
    
    {{-- Tombol Kembali --}}
    <div class="pt-4">
        <a href="{{ route('user.permohonan.history') }}" class="btn btn-outline">
            ← Kembali ke Riwayat
        </a>
    </div>
    
</div>
@endsection