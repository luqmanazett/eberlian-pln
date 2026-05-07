@extends('components.pln-layout')

@section('title', 'Riwayat Perbaikan - SIPEL PLN')
@section('header-title', 'Riwayat Perbaikan')

@section('content')
<div class="space-y-4 ">
    
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
                <p class="font-semibold text-gray-800">{{ $permohonan->nama_pelanggan }}</p>
                <p class="text-sm text-gray-500">ID Register: {{ $permohonan->id_register ?? ('PMH-' . $permohonan->id) }}</p>
            </div>
            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                Total: {{ $permohonan->jumlah_perbaikan }}/3
            </span>
        </div>
    </div>
    
    {{-- Timeline Perbaikan dengan Card --}}
    @if($riwayatPerbaikan->count() > 0)
    <div class="relative">
        
        @foreach($riwayatPerbaikan as $index => $riwayat)
        <div class="flex">
            
            {{-- Kolom Timeline (Kiri) --}}
            <div class="flex flex-col items-center mr-4" style="width: 12px;">
                {{-- Bulatan --}}
                <div class="w-3 h-3 rounded-full flex-shrink-0 mt-5"
                     style="background: 
                        {{ $riwayat->status_perbaikan == 'submitted' ? '#9CA3AF' : '' }}
                        {{ $riwayat->status_perbaikan == 'rejected' ? '#EF4444' : '' }}
                        {{ $riwayat->status_perbaikan == 'approved' ? '#10B981' : '' }};">
                </div>
                
                {{-- Garis penghubung ke card berikutnya --}}
                @if(!$loop->last)
                <div class="flex-1 my-1" style="width: 2px; background: #D1D5DB; min-height: 20px;"></div>
                @endif
            </div>
            
            {{-- Card (Kanan) --}}
            <div class="flex-1 {{ !$loop->last ? 'mb-4' : '' }}">
                <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                    
                    {{-- Tanggal & Jam --}}
                    <p class="text-sm text-gray-500 mb-1">
                        {{ \Carbon\Carbon::parse($riwayat->submitted_at)->format('d M Y, H:i') }}
                    </p>
                    
                    {{-- Nama Akun --}}
                    <p class="text-sm text-gray-600 mb-1">
                        {{ $riwayat->user->name ?? 'User' }}
                    </p>
                    
                    {{-- Status --}}
                    <p class="text-sm font-medium mb-3" style="color: 
                        {{ $riwayat->status_perbaikan == 'submitted' ? '#D97706' : '' }}
                        {{ $riwayat->status_perbaikan == 'rejected' ? '#DC2626' : '' }}
                        {{ $riwayat->status_perbaikan == 'approved' ? '#059669' : '' }};">
                        @if($riwayat->status_perbaikan == 'submitted')
                            Upload Ulang
                        @elseif($riwayat->status_perbaikan == 'rejected')
                            Ditolak
                        @else
                            Disetujui
                        @endif
                    </p>
                    
                    {{-- Dokumen yang Ditolak (HANYA untuk status submitted dan rejected) --}}
                    @if($riwayat->status_perbaikan != 'approved')
                    <p class="text-sm font-medium text-gray-800 mb-2">Dokumen yang ditolak :</p>
                    <ul class="space-y-1 mb-3">
                        @foreach($riwayat->dokumen_yang_diperbaiki as $dokumen)
                        <li class="text-sm text-gray-700">
                            • {{ \App\Models\DetailPenolakan::getDokumenLabels()[$dokumen] ?? $dokumen }}
                        </li>
                        @endforeach
                    </ul>
                    @endif
                    
                    {{-- Alasan (untuk submitted/rejected) / Catatan (untuk approved) --}}
                    <p class="text-sm font-medium text-gray-800 mb-2">
                        @if($riwayat->status_perbaikan == 'approved')
                            Catatan :
                        @else
                            Alasan :
                        @endif
                    </p>
                    <ul class="space-y-1">
                        @if($riwayat->status_perbaikan == 'approved')
                            {{-- Untuk disetujui, tampilkan catatan jika ada --}}
                            @if(isset($riwayat->alasan_penolakan_sebelumnya) && $riwayat->alasan_penolakan_sebelumnya && $riwayat->alasan_penolakan_sebelumnya !== 'Permohonan disetujui.')
                            <li class="text-sm text-gray-700">
                                • {{ $riwayat->alasan_penolakan_sebelumnya }}
                            </li>
                            @elseif(isset($riwayat->alasan_penolakan_sebelumnya) && $riwayat->alasan_penolakan_sebelumnya === 'Permohonan disetujui.')
                            <li class="text-sm text-gray-700">
                                • {{ $riwayat->alasan_penolakan_sebelumnya }}
                            </li>
                            @else
                            <li class="text-sm text-gray-400 italic">
                                • Tidak ada catatan
                            </li>
                            @endif
                        @else
                            {{-- Untuk submitted/rejected, tampilkan alasan per dokumen --}}
                            @foreach($riwayat->dokumen_yang_diperbaiki as $dokumen)
                            @if(isset($riwayat->dokumen_yang_ditolak[$dokumen]))
                            <li class="text-sm text-gray-700">
                                • {{ $riwayat->dokumen_yang_ditolak[$dokumen] }}
                            </li>
                            @endif
                            @endforeach
                        @endif
                    </ul>
                    
                </div>
            </div>
            
        </div>
        @endforeach
        
    </div>
    @else
    <div class="bg-white rounded-xl p-8 text-center shadow-sm border border-gray-100">
        <p class="text-gray-500">Belum ada riwayat perbaikan</p>
    </div>
    @endif
    
</div>
@endsection
