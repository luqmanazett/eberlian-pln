@extends('components.pln-layout')

@section('title', 'Dashboard Admin - SIPEL PLN')
@section('header-title', 'SIPEL PLN')

@section('content')
<div class="space-y-4 pb-20">
    
    {{-- Welcome Card --}}
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <h2 class="text-xl font-bold text-gray-800">Selamat datang, Admin 👋</h2>
        <p class="text-sm text-gray-500 mt-1">Pengelolaan Permohonan PLN</p>
    </div>
    
    {{-- Ringkasan - Grid 2x2 --}}
    <div>
        <h3 class="font-semibold text-gray-800 mb-3">Ringkasan</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            
            {{-- Semua (Total) --}}
            <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border: 1px solid #f0f0f0;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; background: #E0F2F2; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <span style="color: #008080; font-size: 20px;">📄</span>
                    </div>
                    <div>
                        <p style="font-size: 24px; font-weight: bold; color: #1F2937; margin: 0;">{{ $stats['total'] }}</p>
                        <p style="font-size: 12px; color: #6B7280; margin: 0;">Semua</p>
                    </div>
                </div>
            </div>
            
            {{-- Pending --}}
            <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border: 1px solid #f0f0f0;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; background: #FEF3C7; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <span style="color: #D97706; font-size: 20px;">⏳</span>
                    </div>
                    <div>
                        <p style="font-size: 24px; font-weight: bold; color: #D97706; margin: 0;">{{ $stats['pending'] }}</p>
                        <p style="font-size: 12px; color: #6B7280; margin: 0;">Pending</p>
                    </div>
                </div>
            </div>
            
            {{-- Approved --}}
            <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border: 1px solid #f0f0f0;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; background: #D1FAE5; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <span style="color: #059669; font-size: 20px;">✅</span>
                    </div>
                    <div>
                        <p style="font-size: 24px; font-weight: bold; color: #059669; margin: 0;">{{ $stats['approved'] }}</p>
                        <p style="font-size: 12px; color: #6B7280; margin: 0;">Approved</p>
                    </div>
                </div>
            </div>
            
            {{-- Rejected --}}
            <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border: 1px solid #f0f0f0;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; background: #FEE2E2; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <span style="color: #DC2626; font-size: 20px;">❌</span>
                    </div>
                    <div>
                        <p style="font-size: 24px; font-weight: bold; color: #DC2626; margin: 0;">{{ $stats['rejected'] }}</p>
                        <p style="font-size: 12px; color: #6B7280; margin: 0;">Rejected</p>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
    {{-- Grafik Pie - HANYA ADMIN UTAMA (LEVEL 1) --}}
    @if(Auth::user()->admin_level == 1)
    <div>
        <h3 class="font-semibold text-gray-800 mb-3">Permohonan Berdasarkan Jenis</h3>
        <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); border: 1px solid #f0f0f0;">
            <div style="display: flex; align-items: center; gap: 16px;">
                {{-- Grafik Pie --}}
                <div style="flex: 1; min-width: 120px;">
                    <canvas id="pieChart" style="width: 100%; height: 150px;"></canvas>
                </div>
                
                {{-- Legend Vertikal --}}
                <div style="flex: 1; display: flex; flex-direction: column; gap: 12px;">
                    @php
                        $totalJenis = $jenisData->sum('total');
                        $pasangBaru = $jenisData->where('jenis_permohonan', 'pasang_baru')->first()->total ?? 0;
                        $tambahDaya = $jenisData->where('jenis_permohonan', 'tambah_daya')->first()->total ?? 0;
                        $peningkatan = $jenisData->where('jenis_permohonan', 'peningkatan_keandalan')->first()->total ?? 0;
                        
                        $pbPersen = $totalJenis > 0 ? round(($pasangBaru / $totalJenis) * 100) : 0;
                        $tdPersen = $totalJenis > 0 ? round(($tambahDaya / $totalJenis) * 100) : 0;
                        $pkPersen = $totalJenis > 0 ? round(($peningkatan / $totalJenis) * 100) : 0;
                    @endphp
                    
                    {{-- Pasang Baru --}}
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="width: 12px; height: 12px; border-radius: 50%; background: #4ADE80;"></span>
                        <div>
                            <p style="font-size: 14px; font-weight: 500; color: #1F2937; margin: 0;">Pasang Baru</p>
                            <p style="font-size: 12px; color: #6B7280; margin: 0;">{{ $pasangBaru }} ({{ $pbPersen }}%)</p>
                        </div>
                    </div>
                    
                    {{-- Tambah Daya --}}
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="width: 12px; height: 12px; border-radius: 50%; background: #166534;"></span>
                        <div>
                            <p style="font-size: 14px; font-weight: 500; color: #1F2937; margin: 0;">Tambah Daya</p>
                            <p style="font-size: 12px; color: #6B7280; margin: 0;">{{ $tambahDaya }} ({{ $tdPersen }}%)</p>
                        </div>
                    </div>
                    
                    {{-- Peningkatan Keandalan --}}
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="width: 12px; height: 12px; border-radius: 50%; background: #A3E635;"></span>
                        <div>
                            <p style="font-size: 14px; font-weight: 500; color: #1F2937; margin: 0;">Peningkatan Keandalan</p>
                            <p style="font-size: 12px; color: #6B7280; margin: 0;">{{ $peningkatan }} ({{ $pkPersen }}%)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('pieChart');
            if (canvas) {
                const ctx = canvas.getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Pasang Baru', 'Tambah Daya', 'Peningkatan Keandalan'],
                        datasets: [{
                            data: [
                                {{ $pasangBaru }},
                                {{ $tambahDaya }},
                                {{ $peningkatan }}
                            ],
                            backgroundColor: ['#4ADE80', '#166534', '#A3E635'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: { display: false }
                        },
                        cutout: '65%'
                    }
                });
            }
        });
    </script>
    @endif
    
    {{-- Permohonan Terbaru --}}
    <div>
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-semibold text-gray-800 text-base">Permohonan Terbaru</h3>
            <a href="{{ route('admin.verifikasi.index', ['status' => 'pending']) }}" class="text-sm font-medium text-pln-primary">Lihat semua →</a>
        </div>
        
        @php
            $recentPermohonans = App\Models\Permohonan::with('user')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        @endphp
        
        <div class="space-y-2">
            @forelse($recentPermohonans as $item)
            <a href="{{ route('admin.verifikasi.show', $item->id) }}" class="card flex items-center justify-between">
                <div>
                    <p class="font-medium text-gray-800">{{ $item->nama_pelanggan }}</p>
                    <p class="text-sm text-gray-500">
                        👤 {{ $item->user->name ?? 'User' }} - 
                        @if($item->jenis_permohonan == 'pasang_baru') Pasang Baru
                        @elseif($item->jenis_permohonan == 'tambah_daya') Tambah Daya
                        @else Peningkatan Keandalan @endif
                    </p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ $item->created_at->format('d M Y - H:i') }}
                    </p>
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
            </a>
            @empty
            <div class="card text-center py-6">
                <p class="text-gray-500">Belum ada permohonan</p>
            </div>
            @endforelse
        </div>
    </div>
    
</div>
@endsection

@section('bottom-nav')
<a href="{{ route('admin.dashboard') }}" class="nav-item active">
    <span>🏠</span>
    <span>Dashboard</span>
</a>
<a href="{{ route('admin.verifikasi.index') }}" class="nav-item">
    <span>📄</span>
    <span>Permohonan</span>
</a>
@if(Auth::user()->admin_level == 1)
<a href="{{ route('admin.log.index') }}" class="nav-item">
    <span>📊</span>
    <span>Laporan</span>
</a>
@endif
<a href="{{ route('profile.edit') }}" class="nav-item">
    <span>👤</span>
    <span>Profil</span>
</a>
@endsection