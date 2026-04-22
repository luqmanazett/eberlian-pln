@extends('components.pln-layout')

@section('title', 'Verifikasi Permohonan - SIPEL PLN')
@section('header-title', 'Permohonan')

@section('content')
<div class="space-y-4 pb-20">
    
    {{-- Search & Filter --}}
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
        <form method="GET" class="space-y-3">
            <input type="text" name="search" value="{{ request('search') }}" 
                   class="input-field" placeholder="🔍 Cari nama, KTP, IDPEL...">
            
            <div class="grid grid-cols-2 gap-2">
                <select name="status" class="input-field">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
                <select name="jenis" class="input-field">
                    <option value="">Semua Jenis</option>
                    <option value="pasang_baru" {{ request('jenis') == 'pasang_baru' ? 'selected' : '' }}>Pasang Baru</option>
                    <option value="tambah_daya" {{ request('jenis') == 'tambah_daya' ? 'selected' : '' }}>Tambah Daya</option>
                    <option value="peningkatan_keandalan" {{ request('jenis') == 'peningkatan_keandalan' ? 'selected' : '' }}>Peningkatan Keandalan</option>
                </select>
            </div>
            
            <div class="grid grid-cols-2 gap-2">
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="input-field">
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="input-field">
            </div>
            
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.verifikasi.index') }}" class="btn btn-outline block text-center">Reset</a>
        </form>
    </div>
    
    {{-- List Permohonan --}}
    <div class="space-y-2">
        @forelse($permohonans as $item)
        <a href="{{ route('admin.verifikasi.show', $item->id) }}" class="block bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <div class="flex items-start justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <p class="font-semibold">{{ $item->nama_pelanggan }}</p>
                        <span class="text-xs text-gray-400">|</span>
                        <p class="text-xs text-gray-500">👤 {{ $item->user->name ?? 'User' }}</p>
                    </div>
                    <p class="text-sm text-gray-600">
                        @if($item->jenis_permohonan == 'pasang_baru') Pasang Baru
                        @elseif($item->jenis_permohonan == 'tambah_daya') Tambah Daya
                        @else Peningkatan Keandalan @endif
                    </p>
                    @if($item->idpel)
                    <p class="text-xs text-gray-400">IDPEL: {{ $item->idpel }}</p>
                    @endif
                    <p class="text-xs text-gray-400">{{ $item->created_at->format('d M Y - H:i') }} WIB</p>
                </div>
                <div>
                    @if($item->status == 'pending')
                    <span class="badge badge-pending">Menunggu</span>
                    @elseif($item->status == 'approved')
                    <span class="badge badge-approved">Disetujui</span>
                    @else
                    <span class="badge badge-rejected">Ditolak</span>
                    @endif
                </div>
            </div>
        </a>
        @empty
        <div class="bg-white rounded-xl p-8 text-center">
            <p class="text-gray-500">Tidak ada permohonan</p>
        </div>
        @endforelse
    </div>
    
    {{ $permohonans->links() }}
    
</div>
@endsection