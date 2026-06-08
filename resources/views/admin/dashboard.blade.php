@extends('components.pln-layout')

@section('title', 'Dashboard Admin - E-Berlian')
@section('header-title', 'E-Berlian')

@section('content')

{{-- Background Hijau Gradient --}}
<div style="margin: -16px -16px 0 -16px; padding: 16px 16px 0 16px; background: linear-gradient(to bottom, #059669 0%, #D1FAE5 40%, #F5F7FA 100%);">
    
    {{-- Welcome Card - UJUNG TAJAM --}}
    <div style="background: white; border-radius: 0px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); display: flex; align-items: stretch; overflow: hidden;">
        
        {{-- Teks Welcome --}}
        <div style="flex: 1; padding: 16px;">
            <h2 style="font-size: 20px; font-weight: 700; color: #1F2937; margin: 0 0 4px 0;">
                Halo, {{ Auth::user()->name }}
            </h2>
            <p style="font-size: 14px; color: #6B7280; margin: 0;">
                Selamat datang kembali
            </p>
        </div>
        
        {{-- Ilustrasi logo-ilustrasi3.png - Setinggi Card --}}
        <div style="display: flex; align-items: center; justify-content: center; background: linear-gradient(to left, #D1FAE5, white); padding: 0 12px;">
            <img src="{{ asset('images/logo-ilustrasi3.png') }}" 
                 alt="PLN" 
                 style="height: 80px; width: auto; display: block;"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div style="display: none; align-items: center; gap: 3px;">
                <span style="font-size: 40px;">👨‍🔧</span>
                <span style="font-size: 30px;">⚡</span>
            </div>
        </div>
        
    </div>
    
</div>

{{-- Content Normal --}}
<div class="space-y-4 mt-4">
    
    {{-- Ringkasan Hari Ini --}}
    <div>
        <h3 class="font-semibold text-gray-800 mb-3 text-base">Ringkasan Hari Ini</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            
            {{-- Total Permohonan --}}
            <div style="background: white; border-radius: 12px; padding: 12px 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.04); border: 1px solid #f0f0f0; display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: #DBEAFE; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #2563EB; font-size: 20px;">📊</div>
                <div>
                    <p style="font-size: 20px; font-weight: bold; color: #1F2937; margin: 0;">{{ $stats['total'] ?? 0 }}</p>
                    <p style="font-size: 12px; color: #6B7280; margin: 0;"> Permohonan</p>
                </div>
            </div>
            
            {{-- Pending --}}
            <div style="background: white; border-radius: 12px; padding: 12px 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.04); border: 1px solid #f0f0f0; display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: #FEF3C7; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #D97706; font-size: 20px;">⏳</div>
                <div>
                    <p style="font-size: 20px; font-weight: bold; color: #D97706; margin: 0;">{{ $stats['pending'] ?? 0 }}</p>
                    <p style="font-size: 12px; color: #6B7280; margin: 0;">Menunggu </p>
                </div>
            </div>
            
            {{-- Disetujui --}}
            <div style="background: white; border-radius: 12px; padding: 12px 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.04); border: 1px solid #f0f0f0; display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: #D1FAE5; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #059669; font-size: 20px;">✅</div>
                <div>
                    <p style="font-size: 20px; font-weight: bold; color: #059669; margin: 0;">{{ $stats['approved'] ?? 0 }}</p>
                    <p style="font-size: 12px; color: #6B7280; margin: 0;">Disetujui</p>
                </div>
            </div>
            
            {{-- Ditolak --}}
            <div style="background: white; border-radius: 12px; padding: 12px 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.04); border: 1px solid #f0f0f0; display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: #FEE2E2; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #DC2626; font-size: 20px;">❌</div>
                <div>
                    <p style="font-size: 20px; font-weight: bold; color: #DC2626; margin: 0;">{{ $stats['rejected'] ?? 0 }}</p>
                    <p style="font-size: 12px; color: #6B7280; margin: 0;"> Ditolak</p>
                </div>
            </div>
            
        </div>
    </div>
    
    {{-- Permohonan per Jenis - HANYA ADMIN UTAMA --}}
    @if(Auth::user()->admin_level == 1)
    <div>
        <h3 class="font-semibold text-gray-800 mb-3 text-base">Permohonan per Jenis</h3>
        <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 2px 4px rgba(0,0,0,0.04); border: 1px solid #f0f0f0;">
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
                        <span style="width: 12px; height: 12px; border-radius: 50%; background: #EAB308;"></span>
                        <div>
                            <p style="font-size: 14px; font-weight: 500; color: #1F2937; margin: 0;">Pasang Baru</p>
                            <p style="font-size: 12px; color: #6B7280; margin: 0;">{{ $pbPersen }}%</p>
                        </div>
                    </div>
                    
                    {{-- Tambah Daya --}}
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="width: 12px; height: 12px; border-radius: 50%; background: #22C55E;"></span>
                        <div>
                            <p style="font-size: 14px; font-weight: 500; color: #1F2937; margin: 0;">Tambah Daya</p>
                            <p style="font-size: 12px; color: #6B7280; margin: 0;">{{ $tdPersen }}%</p>
                        </div>
                    </div>
                    
                    {{-- Keandalan --}}
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span style="width: 12px; height: 12px; border-radius: 50%; background: #EF4444;"></span>
                        <div>
                            <p style="font-size: 14px; font-weight: 500; color: #1F2937; margin: 0;">Keandalan</p>
                            <p style="font-size: 12px; color: #6B7280; margin: 0;">{{ $pkPersen }}%</p>
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
            const pieCanvas = document.getElementById('pieChart');
            if (pieCanvas) {
                const ctx = pieCanvas.getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Pasang Baru', 'Tambah Daya', 'Keandalan'],
                        datasets: [{
                            data: [{{ $pasangBaru }}, {{ $tambahDaya }}, {{ $peningkatan }}],
                            backgroundColor: ['#EAB308', '#22C55E', '#EF4444'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: { legend: { display: false } },
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
            <a href="{{ route('admin.verifikasi.index', ['status' => 'pending']) }}" class="text-sm font-medium" style="color: #059669;">Lihat semua →</a>
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
                        @if($item->locked_by && $item->locked_at && $item->locked_at->diffInMinutes(now()) < 3)
                            <span class="px-3 py-1 rounded-full text-xs font-medium border border-orange-200" style="background: #FFF7ED; color: #C2410C;">👀 Sedang Direview</span>
                        @else
                            <span class="badge badge-pending">Menunggu</span>
                        @endif
                    @elseif($item->status == 'approved')
                    <span class="badge badge-approved">Disetujui</span>
                    @elseif($item->status == 'cancelled')
                    <span class="px-3 py-1 rounded-full text-xs font-medium" style="background: #F3F4F6; color: #374151;">Dibatalkan</span>
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
