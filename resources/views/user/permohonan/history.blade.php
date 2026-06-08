@extends('components.pln-layout')

@section('title', 'Riwayat Permohonan - E-Berlian')
@section('header-title', 'Riwayat')

@section('content')
<div class="space-y-4">
    
    {{-- Header --}}
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('user.dashboard') }}" class="text-gray-600">
            <span class="text-2xl">←</span>
        </a>
        <h2 class="text-xl font-bold text-gray-800">Riwayat Permohonan</h2>
    </div>
    
    {{-- Search Bar --}}
    <form action="{{ route('user.permohonan.history') }}" method="GET" class="flex flex-col gap-2 mb-2">
        <input type="hidden" name="status" value="{{ request('status', 'semua') }}">
        <div class="flex items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" 
                   class="flex-1 px-4 py-3.5 bg-white border border-gray-200 rounded-2xl text-sm shadow-sm" 
                   placeholder="Cari ID Register atau Nama Pelanggan...">
            
            <button type="submit" class="w-12 h-12 flex-shrink-0 bg-white border border-gray-200 rounded-2xl flex items-center justify-center shadow-sm">
                @if(file_exists(public_path('images/cari.png')))
                <img src="{{ asset('images/cari.png') }}" alt="Cari" style="width: 22px; height: 22px;">
                @else
                <span class="text-gray-400 text-lg">🔍</span>
                @endif
            </button>
        </div>
    </form>
    
    {{-- Filter Tabs --}}
    <div class="bg-white rounded-2xl p-1 shadow-sm border border-gray-100">
        <div class="flex items-center justify-around">
            @php
                $currentStatus = request()->get('status', 'semua');
            @endphp
            
            <a href="{{ route('user.permohonan.history', ['status' => 'semua', 'search' => request('search')]) }}" 
               class="flex-1 text-center py-2 px-1 rounded-xl text-sm font-medium transition
                      {{ $currentStatus == 'semua' ? 'bg-yellow-100 text-yellow-800' : 'text-gray-500 hover:text-gray-700' }}">
                Semua
            </a>
            <a href="{{ route('user.permohonan.history', ['status' => 'pending', 'search' => request('search')]) }}" 
               class="flex-1 text-center py-2 px-1 rounded-xl text-sm font-medium transition
                      {{ $currentStatus == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'text-gray-500 hover:text-gray-700' }}">
                Menunggu
            </a>
            <a href="{{ route('user.permohonan.history', ['status' => 'approved', 'search' => request('search')]) }}" 
               class="flex-1 text-center py-2 px-1 rounded-xl text-sm font-medium transition
                      {{ $currentStatus == 'approved' ? 'bg-green-100 text-green-800' : 'text-gray-500 hover:text-gray-700' }}">
                Disetujui
            </a>
            <a href="{{ route('user.permohonan.history', ['status' => 'rejected', 'search' => request('search')]) }}" 
               class="flex-1 text-center py-2 px-1 rounded-xl text-sm font-medium transition
                      {{ $currentStatus == 'rejected' ? 'bg-red-100 text-red-800' : 'text-gray-500 hover:text-gray-700' }}">
                Ditolak
            </a>
        </div>
    </div>
    
    {{-- List Permohonan --}}
    <div class="space-y-2">
@forelse($permohonans as $item)
<a href="{{ route('user.permohonan.show', $item->id) }}" class="block">
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between mb-2">
            <div>
                {{-- 👇 NAMA PELANGGAN --}}
                <h4 class="font-semibold text-gray-800 text-base">{{ $item->nama_pelanggan }}</h4>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-sm text-gray-500">
                        @if($item->jenis_permohonan == 'pasang_baru')
                            Pasang Baru
                        @elseif($item->jenis_permohonan == 'tambah_daya')
                            Tambah Daya
                        @else
                            Peningkatan Keandalan
                        @endif
                    </span>
                    <span class="text-xs text-gray-400">•</span>
                    <span class="text-sm text-gray-500">{{ $item->created_at->format('d M Y - H:i') }}</span>
                </div>
            </div>
            <div class="flex-shrink-0 flex items-center ml-2">
                @if($item->status == 'pending')
                    @if($item->locked_by && $item->locked_at && $item->locked_at->diffInMinutes(now()) < 3)
                        <span class="px-3 py-1 bg-orange-100 text-orange-700 text-xs font-bold rounded-full border border-orange-200 whitespace-nowrap">Sedang Diverifikasi</span>
                    @else
                        <span class="badge badge-pending whitespace-nowrap">Menunggu</span>
                    @endif
                @elseif($item->status == 'approved')
                <span class="badge badge-approved whitespace-nowrap">Disetujui</span>
                @elseif($item->status == 'cancelled')
                <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded-full border border-gray-200 whitespace-nowrap">Dibatalkan</span>
                @else
                <span class="badge badge-rejected whitespace-nowrap">Ditolak</span>
                @endif
            </div>
        </div>
        <div class="flex items-center justify-between">
            <p class="text-xs text-gray-400">
                ID Register: {{ $item->id_register ?? ('PMH-' . $item->id) }}
            </p>
            <span class="text-gray-400 text-sm">→</span>
        </div>
    </div>
</a>
@empty
<div class="bg-white rounded-xl p-8 text-center border border-gray-100">
    <div class="text-5xl mb-4">📋</div>
    <p class="text-gray-500">Belum ada riwayat permohonan</p>
    <a href="{{ route('user.permohonan.create') }}" class="inline-block mt-4 text-pln-primary font-medium">
        Ajukan Permohonan Sekarang →
    </a>
</div>
@endforelse
    </div>
    
    {{-- Pagination --}}
    @if($permohonans->hasPages())
    <div class="mt-6">
        {{ $permohonans->appends(['status' => $currentStatus])->links() }}
    </div>
    @endif
    
</div>
@endsection
