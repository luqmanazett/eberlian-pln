@extends('components.pln-layout')

@section('title', 'Dashboard Admin - SIPEL PLN')
@section('header-title', 'Dashboard')

@section('content')
<div class="space-y-4 pb-20">
    
    {{-- Welcome Card dengan Logout --}}
    <div class="bg-gradient-to-r from-pln-primary to-teal-600 rounded-xl p-5 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold">Selamat datang, {{ explode(' ', Auth::user()->name)[0] }}</h2>
                <p class="text-sm opacity-80">
                    @if(Auth::user()->admin_level == 1)
                        Admin Utama (Akses Penuh)
                    @elseif(Auth::user()->admin_level == 2)
                        Admin Verifikator
                    @else
                        Petugas Verifikator
                    @endif
                </p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-4xl">👨‍💼</span>
                {{-- Tombol Logout --}}
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                        🚪 Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    {{-- Ringkasan Statistik --}}
    <div>
        <h3 class="font-semibold text-gray-800 mb-3">Ringkasan</h3>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-2">
            <div class="bg-white rounded-xl p-3 text-center shadow-sm border border-gray-100">
                <p class="text-2xl font-bold text-pln-primary">{{ $stats['total'] }}</p>
                <p class="text-xs text-gray-500">Total Permohonan</p>
            </div>
            <div class="bg-white rounded-xl p-3 text-center shadow-sm border border-gray-100">
                <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                <p class="text-xs text-gray-500">Menunggu Verifikasi</p>
            </div>
            <div class="bg-white rounded-xl p-3 text-center shadow-sm border border-gray-100">
                <p class="text-2xl font-bold text-green-600">{{ $stats['approved'] }}</p>
                <p class="text-xs text-gray-500">Disetujui</p>
            </div>
            <div class="bg-white rounded-xl p-3 text-center shadow-sm border border-gray-100">
                <p class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</p>
                <p class="text-xs text-gray-500">Ditolak</p>
            </div>
            <div class="bg-white rounded-xl p-3 text-center shadow-sm border border-gray-100">
                <p class="text-2xl font-bold text-blue-600">{{ $stats['perlu_perbaikan'] }}</p>
                <p class="text-xs text-gray-500">Perlu Perbaikan</p>
            </div>
        </div>
    </div>
    {{-- Permohonan Berdasarkan Jenis --}}
    <div>
        <h3 class="font-semibold text-gray-800 mb-3">Permohonan Berdasarkan Jenis</h3>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            @foreach($jenisData as $jenis)
            <div class="mb-3 last:mb-0">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700">
                        @if($jenis->jenis_permohonan == 'pasang_baru')
                            Pasang Baru
                        @elseif($jenis->jenis_permohonan == 'tambah_daya')
                            Tambah Daya
                        @else
                            Peningkatan Keandalan
                        @endif
                    </span>
                    <span class="text-sm text-gray-600">{{ $jenis->persentase }}% ({{ $jenis->total }})</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="h-2 rounded-full 
                        @if($jenis->jenis_permohonan == 'pasang_baru') bg-blue-600
                        @elseif($jenis->jenis_permohonan == 'tambah_daya') bg-yellow-600
                        @else bg-green-600 @endif"
                        style="width: {{ $jenis->persentase }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
   {{-- Quick Actions --}}
<div class="grid grid-cols-2 gap-2">
    <a href="{{ route('admin.verifikasi.index') }}" class="bg-pln-primary text-white rounded-xl p-4 text-center font-medium">
        📋 Verifikasi
    </a>
    <a href="{{ route('admin.verifikasi.index', ['status' => 'pending']) }}" class="bg-white border border-gray-200 rounded-xl p-4 text-center font-medium">
        ⏳ Pending ({{ $stats['pending'] }})
    </a>
    
    {{-- Hanya Admin Utama yang bisa lihat menu ini --}}
    @if(Auth::user()->canViewLogs())
    <a href="{{ route('admin.log.index') }}" class="bg-white border border-gray-200 rounded-xl p-4 text-center font-medium">
        📊 Log Aktivitas
    </a>
    @endif
    
    @if(Auth::user()->canExportData())
    <button onclick="openExportModal()" class="bg-white border border-gray-200 rounded-xl p-4 text-center font-medium">
        📥 Export Data
    </button>
    @endif
    
    @if(Auth::user()->canManageUsers())
    <a href="{{ route('admin.user.index') }}" class="bg-white border border-gray-200 rounded-xl p-4 text-center font-medium">
        👥 Manajemen User
    </a>
    @endif
</div>
    
    {{-- Permohonan Terbaru --}}
    <div>
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-semibold text-gray-800">Permohonan Terbaru</h3>
           <a href="{{ route('admin.verifikasi.index') }}" class="text-sm text-pln-primary">Lihat semua →</a>
        </div>
        
        <div class="space-y-2">
            @forelse($recentPermohonans as $item)
            <a href="{{ route('admin.verifikasi.show', $item->id) }}" class="block bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium">{{ $item->nama_pelanggan }}</p>
                        <p class="text-sm text-gray-500">
                            @if($item->jenis_permohonan == 'pasang_baru') Pasang Baru
                            @elseif($item->jenis_permohonan == 'tambah_daya') Tambah Daya
                            @else Peningkatan Keandalan @endif
                        </p>
                        <p class="text-xs text-gray-400">{{ $item->created_at->format('d M Y - H:i') }}</p>
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
            <div class="bg-white rounded-xl p-6 text-center">
                <p class="text-gray-500">Belum ada permohonan</p>
            </div>
            @endforelse
        </div>
    </div>
    
</div>

{{-- MODAL EXPORT --}}
<div id="exportModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-md p-6">
        <h3 class="text-xl font-bold mb-4">Export Data Permohonan</h3>
        
        <form action="{{ route('admin.export') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-sm font-medium mb-1">Tanggal Awal</label>
                    <input type="date" name="start_date" class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Tanggal Akhir</label>
                    <input type="date" name="end_date" class="input-field">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Status</label>
                <select name="status" class="input-field">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Jenis Permohonan</label>
                <select name="jenis" class="input-field">
                    <option value="">Semua Jenis</option>
                    <option value="pasang_baru">Pasang Baru</option>
                    <option value="tambah_daya">Tambah Daya</option>
                    <option value="peningkatan_keandalan">Peningkatan Keandalan</option>
                </select>
            </div>
            
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeExportModal()" class="btn btn-outline flex-1">Batal</button>
                <button type="submit" class="btn btn-success flex-1">📥 Export Excel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openExportModal() {
        document.getElementById('exportModal').classList.remove('hidden');
        document.getElementById('exportModal').classList.add('flex');
    }
    function closeExportModal() {
        document.getElementById('exportModal').classList.add('hidden');
        document.getElementById('exportModal').classList.remove('flex');
    }
</script>
@endsection