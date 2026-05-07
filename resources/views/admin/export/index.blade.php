@extends('components.pln-layout')

@section('title', 'Eksport Data - SIPEL PLN')
@section('header-title', 'Eksport Data')

@section('content')
<div class="space-y-4 ">
    
    {{-- Header --}}
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600">
            <span class="text-2xl">←</span>
        </a>
        <h2 class="text-xl font-bold text-gray-800">Eksport Data Permohonan</h2>
    </div>
    
    {{-- Card Form Eksport --}}
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="mb-4 text-center">
            <div class="w-16 h-16 bg-pln-primary-light rounded-full flex items-center justify-center mx-auto mb-3">
                @if(file_exists(public_path('images/bottom-nav/export.png')))
                <img src="{{ asset('images/bottom-nav/export.png') }}" alt="Eksport" style="width: 36px; height: 36px; object-fit: contain;">
                @else
                <span class="text-3xl">📥</span>
                @endif
            </div>
            <h3 class="font-bold text-gray-800 text-lg">Rekap Semua Data</h3>
            <p class="text-sm text-gray-500 mt-1">Unduh laporan permohonan ke format Excel (XLSX)</p>
        </div>
        
        <form action="{{ route('admin.export') }}" method="GET" class="space-y-4">
            
            {{-- Filter Tanggal --}}
            <div class="space-y-2">
                <label class="input-label">Rentang Tanggal (Opsional)</label>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <input type="date" name="start_date" class="input-field text-sm" placeholder="Mulai">
                        <span class="text-xs text-gray-500 mt-1 block">Dari</span>
                    </div>
                    <div>
                        <input type="date" name="end_date" class="input-field text-sm" placeholder="Sampai">
                        <span class="text-xs text-gray-500 mt-1 block">Sampai</span>
                    </div>
                </div>
            </div>
            
            {{-- Filter Status --}}
            <div class="space-y-2">
                <label class="input-label">Status Permohonan (Opsional)</label>
                <select name="status" class="input-field text-sm">
                    <option value="">Semua Status</option>
                    <option value="pending">Menunggu</option>
                    <option value="approved">Disetujui</option>
                    <option value="rejected">Ditolak</option>
                </select>
            </div>
            
            {{-- Filter Jenis --}}
            <div class="space-y-2">
                <label class="input-label">Jenis Permohonan (Opsional)</label>
                <select name="jenis" class="input-field text-sm">
                    <option value="">Semua Jenis</option>
                    <option value="pasang_baru">Pasang Baru</option>
                    <option value="tambah_daya">Tambah Daya</option>
                    <option value="peningkatan_keandalan">Peningkatan Keandalan</option>
                </select>
            </div>
            
            <div class="pt-4 border-t border-gray-100 flex gap-3">
                <button type="submit" name="format" value="excel" class="btn flex-1 flex items-center justify-center gap-2 text-white" style="background-color: #059669; border: none;">
                    <span>Download Excel</span>
                </button>
                <button type="submit" name="format" value="pdf" class="btn flex-1 flex items-center justify-center gap-2 text-white" style="background-color: #DC2626; border: none;">
                    <span>Download PDF</span>
                </button>
            </div>
        </form>
    </div>
    
</div>
@endsection
