@extends('components.pln-layout')

@section('title', 'Notifikasi - E-Berlian')
@section('header-title', 'Notifikasi')

@section('content')
<div class="space-y-4 ">
    
    {{-- Header dengan Tombol Tandai Semua Dibaca --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('user.dashboard') }}" class="text-gray-600">
                <span class="text-2xl">←</span>
            </a>
            <h2 class="text-xl font-bold text-gray-800">Notifikasi</h2>
        </div>
        
        @if($notifikasis->where('sudah_dibaca', false)->count() > 0)
        <form action="{{ route('user.notifikasi.markAllRead') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="text-sm font-medium text-pln-primary">
                Tandai semua dibaca
            </button>
        </form>
        @endif
    </div>
    
    {{-- List Notifikasi --}}
    @if($notifikasis->count() > 0)
    <div class="space-y-5">
        @foreach($notifikasis as $item)
        <a href="{{ route('user.notifikasi.read', $item->id) }}" class="block">
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 {{ !$item->sudah_dibaca ? 'bg-yellow-50/30' : '' }}">
                <div class="flex items-start gap-3">
                    
                    {{-- Icon Status (Gambar Custom) --}}
                    <div class="flex-shrink-0">
                        @if($item->jenis_notifikasi == 'approved')
                            @if(file_exists(public_path('images/notifikasi/approved.png')))
                            <img src="{{ asset('images/notifikasi/approved.png') }}" alt="Approved" style="width: 40px; height: 40px;">
                            @else
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <span class="text-green-600 text-lg">✅</span>
                            </div>
                            @endif
                        @elseif($item->jenis_notifikasi == 'rejected')
                            @if(file_exists(public_path('images/notifikasi/rejected.png')))
                            <img src="{{ asset('images/notifikasi/rejected.png') }}" alt="Rejected" style="width: 40px; height: 40px;">
                            @else
                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                <span class="text-red-600 text-lg">❌</span>
                            </div>
                            @endif
                        @elseif($item->jenis_notifikasi == 'perlu_perbaikan')
                            @if(file_exists(public_path('images/notifikasi/perbaikan.png')))
                            <img src="{{ asset('images/notifikasi/perbaikan.png') }}" alt="Perbaikan" style="width: 40px; height: 40px;">
                            @else
                            <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                <span class="text-orange-600 text-lg">📄</span>
                            </div>
                            @endif
                        @else
                            @if(file_exists(public_path('images/notifikasi/info.png')))
                            <img src="{{ asset('images/notifikasi/info.png') }}" alt="Info" style="width: 40px; height: 40px;">
                            @else
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 text-lg">📋</span>
                            </div>
                            @endif
                        @endif
                    </div>
                    
                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        {{-- Judul --}}
                        <p class="font-semibold text-gray-800 text-base">
                            @if($item->jenis_notifikasi == 'approved')
                                Permohonan Anda disetujui
                            @elseif($item->jenis_notifikasi == 'rejected')
                                Permohonan ditolak
                            @elseif($item->jenis_notifikasi == 'perlu_perbaikan')
                                Dokumen diperlukan
                            @else
                                Permohonan baru diterima
                            @endif
                        </p>
                        
                        {{-- Pesan --}}
                        <p class="text-sm text-gray-500 mt-0.5">
                            {{ $item->pesan }}
                        </p>
                        
                        {{-- Alasan (jika ada) --}}
                        @if($item->alasan)
                        <p class="text-sm text-gray-400 mt-1 whitespace-pre-line">
                            {{ $item->alasan }}
                        </p>
                        @endif
                        
                        {{-- Waktu --}}
                        <p class="text-xs text-gray-400 mt-2">
                            {{ $item->created_at->diffForHumans() }}
                        </p>
                    </div>
                    
                    {{-- Unread indicator (titik biru) --}}
                    @if(!$item->sudah_dibaca)
                    <div class="flex-shrink-0">
                        <span class="w-2 h-2 bg-pln-primary rounded-full block"></span>
                    </div>
                    @endif
                    
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div class="bg-white rounded-xl p-8 text-center border border-gray-100">
        <div class="text-5xl mb-4">🔔</div>
        <p class="text-gray-500">Belum ada notifikasi</p>
        <p class="text-sm text-gray-400 mt-2">Notifikasi akan muncul saat permohonan Anda diverifikasi</p>
    </div>
    @endif
    
    {{-- Pagination --}}
    @if($notifikasis->hasPages())
    <div class="mt-6">
        {{ $notifikasis->links() }}
    </div>
    @endif
    
</div>
@endsection
