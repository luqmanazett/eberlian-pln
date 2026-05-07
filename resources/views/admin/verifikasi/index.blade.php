@extends('components.pln-layout')

@section('title', 'Permohonan - SIPEL PLN')
@section('header-title', 'Permohonan')

@section('content')
<div class="space-y-4 " style="max-width: 360px; margin: 0 auto;">
    
   {{-- Search Bar + Tombol Search --}}
<form method="GET" action="{{ route('admin.verifikasi.index') }}" class="flex flex-col gap-2">
    <div class="flex items-center gap-2">
        <input type="text" name="search" value="{{ request('search') }}" 
               class="flex-1 px-4 py-3.5 bg-white border border-gray-200 rounded-2xl text-sm shadow-sm" 
               placeholder="Cari permohonan...">
        
        <button type="submit" class="w-12 h-12 flex-shrink-0 bg-white border border-gray-200 rounded-2xl flex items-center justify-center shadow-sm">
            @if(file_exists(public_path('images/cari.png')))
            <img src="{{ asset('images/cari.png') }}" alt="Cari" style="width: 22px; height: 22px;">
            @else
            <span class="text-gray-400 text-lg">🔍</span>
            @endif
        </button>
    </div>

    {{-- Filter Dropdowns (Jenis & Sort) --}}
    <div style="display: flex; gap: 8px; width: 100%;">
        <select name="jenis" onchange="this.form.submit()" style="flex: 1; min-width: 0; font-size: 13px; padding-top: 10px; padding-bottom: 10px; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%236B7280%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 0.65rem auto;" class="px-3 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-600 outline-none focus:border-[#46C2B3] focus:ring-1 focus:ring-[#46C2B3] appearance-none">
            <option value="">Semua Jenis</option>
            <option value="pasang_baru" {{ request('jenis') == 'pasang_baru' ? 'selected' : '' }}>Pasang Baru</option>
            <option value="tambah_daya" {{ request('jenis') == 'tambah_daya' ? 'selected' : '' }}>Tambah Daya</option>
            <option value="peningkatan_keandalan" {{ request('jenis') == 'peningkatan_keandalan' ? 'selected' : '' }}>Peningkatan Keandalan</option>
        </select>
        
        <select name="sort" onchange="this.form.submit()" style="flex: 1; min-width: 0; font-size: 13px; padding-top: 10px; padding-bottom: 10px; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%236B7280%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 0.65rem auto;" class="px-3 bg-white border border-gray-200 rounded-xl shadow-sm text-gray-600 outline-none focus:border-[#46C2B3] focus:ring-1 focus:ring-[#46C2B3] appearance-none">
            <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Waktu: Terbaru</option>
            <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Waktu: Terlama</option>
        </select>
    </div>
    
    {{-- Pertahankan filter status jika ada --}}
    @if(request('status'))
    <input type="hidden" name="status" value="{{ request('status') }}">
    @endif
</form>
    
    {{-- Tab Filter - Pill Style (dengan margin top) --}}
    <div class="flex items-center gap-2 overflow-x-auto pb-1 mt-2" style="-webkit-overflow-scrolling: touch; scrollbar-width: none;">
        <a href="{{ route('admin.verifikasi.index', array_merge(request()->except('status'), ['status' => ''])) }}" 
           class="flex-shrink-0 px-5 py-2.5 rounded-full text-sm font-medium transition-all
                  {{ !request('status') ? 'text-white shadow-md' : 'bg-white border border-gray-200 text-gray-600' }}"
                  style="{{ !request('status') ? 'background: #46C2B3;' : '' }}">
            Semua
        </a>
        <a href="{{ route('admin.verifikasi.index', array_merge(request()->except('status'), ['status' => 'pending'])) }}" 
           class="flex-shrink-0 px-5 py-2.5 rounded-full text-sm font-medium transition-all
                  {{ request('status') == 'pending' ? 'text-white shadow-md' : 'bg-white border border-gray-200 text-gray-600' }}"
                  style="{{ request('status') == 'pending' ? 'background: #46C2B3;' : '' }}">
            Menunggu
        </a>
        <a href="{{ route('admin.verifikasi.index', array_merge(request()->except('status'), ['status' => 'approved'])) }}" 
           class="flex-shrink-0 px-5 py-2.5 rounded-full text-sm font-medium transition-all
                  {{ request('status') == 'approved' ? 'text-white shadow-md' : 'bg-white border border-gray-200 text-gray-600' }}"
                  style="{{ request('status') == 'approved' ? 'background: #46C2B3;' : '' }}">
            Disetujui
        </a>
        <a href="{{ route('admin.verifikasi.index', array_merge(request()->except('status'), ['status' => 'rejected'])) }}" 
           class="flex-shrink-0 px-5 py-2.5 rounded-full text-sm font-medium transition-all
                  {{ request('status') == 'rejected' ? 'text-white shadow-md' : 'bg-white border border-gray-200 text-gray-600' }}"
                  style="{{ request('status') == 'rejected' ? 'background: #46C2B3;' : '' }}">
            Ditolak
        </a>
    </div>
    
  {{-- List Permohonan - Desain Code 1 + Ukuran Code 2 --}}
<div class="grid grid-cols-1 gap-3">
    @forelse($permohonans as $item)
    <a href="{{ route('admin.verifikasi.show', $item->id) }}" class="block">
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 transition-all active:scale-[0.99] relative overflow-hidden">
            
            {{-- Indikator Status Warna di Samping Kiri --}}
            <div class="absolute left-0 top-0 bottom-0 w-1" 
                 style="background: {{ $item->status == 'pending' ? '#FFD500' : ($item->status == 'approved' ? '#46C2B3' : '#EF4444') }}">
            </div>

            <div class="pl-2">
                {{-- Header: ID + Status Pill --}}
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-medium text-gray-500">ID Register: {{ $item->id_register ?? ('PMH-' . $item->id) }}</span>
                    
                    @if($item->status == 'pending')
                        <span class="px-3 py-1 rounded-full text-xs font-medium" style="background: #FEF3C7; color: #92400E;">Menunggu</span>
                    @elseif($item->status == 'approved')
                        <span class="px-3 py-1 rounded-full text-xs font-medium" style="background: #D1FAE5; color: #065F46;">Disetujui</span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs font-medium" style="background: #FEE2E2; color: #991B1B;">Ditolak</span>
                    @endif
                </div>
                
                {{-- Nama Pelanggan --}}
                <p class="font-semibold text-gray-800 text-base mb-1">{{ $item->nama_pelanggan }}</p>
                
                {{-- User & Jam --}}
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-xs text-gray-400">👤 {{ $item->user->name ?? 'User' }}</span>
                    <span class="text-gray-300 text-xs">•</span>
                    <span class="text-xs text-gray-400">🕒 {{ $item->created_at->format('H:i') }} WIB</span>
                </div>
                
                {{-- IDPEL (Jika ada) --}}
                @if($item->idpel)
                <p class="text-sm text-gray-500 mb-1">IDPEL: {{ $item->idpel }}</p>
                @endif
                
                {{-- Footer: Jenis Layanan, Tanggal & Tanda > --}}
<div class="flex items-center justify-between pt-2 border-t border-gray-50">
    <p class="text-sm font-medium" style="color: #46C2B3;">
        @if($item->jenis_permohonan == 'pasang_baru')
            Pasang Baru
        @elseif($item->jenis_permohonan == 'tambah_daya')
            Tambah Daya
        @else
            Peningkatan Keandalan
        @endif
    </p>
    <div class="flex items-center gap-2">
        <p class="text-xs text-gray-400">{{ $item->created_at->format('d M Y') }}</p>
        <span class="text-gray-300 text-xl">›</span>
    </div>
</div>
            </div>
        </div>
    </a>
    @empty
    <div class="bg-white rounded-2xl p-8 text-center shadow-sm border border-gray-100">
        <div class="text-3xl mb-2">📂</div>
        <p class="text-gray-500 text-sm">Tidak ada permohonan</p>
    </div>
    @endforelse
</div>
    
    {{-- Pagination --}}
    @if($permohonans->hasPages())
    <div class="mt-6">
        {{ $permohonans->appends(request()->query())->links() }}
    </div>
    @endif
    
</div>
@endsection

