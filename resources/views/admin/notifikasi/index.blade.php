@extends('components.pln-layout')

@section('title', 'Notifikasi - SIPEL PLN')
@section('header-title', 'Notifikasi')

@section('content')
<div class="space-y-4 pb-20">
    
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600">
            <span class="text-2xl">←</span>
        </a>
        <h2 class="text-xl font-bold text-gray-800">Notifikasi</h2>
    </div>
    
    @if($notifikasis->count() > 0)
    <div class="space-y-2">
        @foreach($notifikasis as $item)
        <a href="{{ route('admin.notifikasi.read', $item->id) }}" class="block">
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 {{ !$item->sudah_dibaca ? 'bg-blue-50/50' : '' }}">
                <div class="flex items-start gap-3">
                    
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 text-lg">
                                @if(str_contains($item->pesan, 'Baru')) 📋
                                @elseif(str_contains($item->pesan, 'Revisi')) 🔄
                                @else 📌
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-gray-800">{{ $item->pesan }}</p>
                        <p class="text-sm text-gray-500 mt-0.5">{{ $item->alasan }}</p>
                        <p class="text-xs text-gray-400 mt-2">{{ $item->created_at->diffForHumans() }}</p>
                    </div>
                    
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
        <p class="text-gray-500">Belum ada notifikasi</p>
    </div>
    @endif
    
    {{ $notifikasis->links() }}
    
</div>
@endsection