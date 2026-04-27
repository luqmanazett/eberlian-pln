@extends('components.pln-layout')

@section('title', 'Detail Permohonan - SIPEL PLN')
@section('header-title', 'Detail Permohonan')

@section('content')
<div class="space-y-4 pb-20">
    
    {{-- Header --}}
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('admin.verifikasi.index') }}" class="text-gray-600">
            <span class="text-2xl">←</span>
        </a>
        <h2 class="text-xl font-bold text-gray-800">Verifikasi Permohonan</h2>
    </div>
    
    {{-- Link History Perbaikan (jika ada) --}}
    @if($permohonan->jumlah_perbaikan > 0)
    <div class="mb-2">
        <a href="{{ route('admin.verifikasi.history-perbaikan', $permohonan->id) }}" class="text-pln-primary text-sm flex items-center gap-1">
            📋 Lihat Riwayat Perbaikan ({{ $permohonan->jumlah_perbaikan }} versi) →
        </a>
    </div>
    @endif
    
    {{-- ==================== KODE PMH ==================== --}}
    <div class="bg-white rounded-[48px] p-6 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            {{-- Kiri: Kode PMH & Jenis Permohonan --}}
            <div>
                <span class="text-xs text-gray-400 uppercase tracking-wider font-medium">Kode PMH</span>
                <p class="font-bold text-gray-800 text-lg mt-1">PMH-{{ $permohonan->id }}</p>
                <p class="text-sm text-gray-500 mt-1">
                    @if($permohonan->jenis_permohonan == 'pasang_baru') 
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">🔌 Pasang Baru</span>
                    @elseif($permohonan->jenis_permohonan == 'tambah_daya') 
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-700">⚡ Tambah Daya</span>
                    @else 
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700">🛡️ Peningkatan Keandalan</span>
                    @endif
                </p>
            </div>
            
            {{-- Kanan: Tanggal, Jam, Status --}}
            <div class="text-right">
                <p class="text-sm text-gray-500">{{ $permohonan->created_at->format('d M Y') }}</p>
                <p class="text-sm text-gray-400">{{ $permohonan->created_at->format('H:i') }} WIB</p>
                <p class="mt-2">
                    @if($permohonan->status == 'pending')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">⏳ Menunggu Verifikasi</span>
                    @elseif($permohonan->status == 'approved')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">✅ Disetujui</span>
                    @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">❌ Ditolak</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
    
    {{-- ==================== DATA PEMOHON ==================== --}}
    <div class="bg-white rounded-[48px] p-6 shadow-sm border border-gray-100">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-8 h-8 rounded-full bg-pln-primary/10 flex items-center justify-center">
                <svg class="w-4 h-4 text-pln-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <h3 class="font-semibold text-gray-800">Data Pemohon</h3>
        </div>
        
        <div class="space-y-4">
            {{-- Nama & No KTP --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <span class="text-xs text-gray-400 uppercase tracking-wider font-medium">Nama</span>
                    <p class="font-semibold text-gray-800 mt-1 text-sm">{{ $permohonan->nama_pelanggan }}</p>
                </div>
                <div>
                    <span class="text-xs text-gray-400 uppercase tracking-wider font-medium">No. KTP</span>
                    <p class="font-semibold text-gray-800 mt-1 text-sm">{{ $permohonan->no_ktp }}</p>
                </div>
            </div>
            
            {{-- IDPEL & No. Telepon --}}
            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-100">
                <div>
                    <span class="text-xs text-gray-400 uppercase tracking-wider font-medium">IDPEL</span>
                    <p class="font-semibold text-gray-800 mt-1 text-sm">{{ $permohonan->idpel ?? '-' }}</p>
                </div>
                <div>
                    <span class="text-xs text-gray-400 uppercase tracking-wider font-medium">No. Telepon</span>
                    <p class="font-semibold text-gray-800 mt-1 text-sm">{{ $permohonan->no_telepon }}</p>
                </div>
            </div>
            
            {{-- ULP & Diajukan oleh --}}
            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-100">
                <div>
                    <span class="text-xs text-gray-400 uppercase tracking-wider font-medium">ULP</span>
                    <p class="font-semibold text-gray-800 mt-1 text-sm">{{ $permohonan->ulp }}</p>
                </div>
                <div>
                    <span class="text-xs text-gray-400 uppercase tracking-wider font-medium">Diajukan oleh</span>
                    <p class="font-semibold text-gray-800 mt-1 text-sm">{{ $permohonan->user->name ?? '-' }}</p>
                </div>
            </div>
            
            {{-- Alamat Gardu & Nama Gardu --}}
            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-100">
                <div>
                    <span class="text-xs text-gray-400 uppercase tracking-wider font-medium">Alamat Gardu</span>
                    <p class="font-semibold text-gray-800 mt-1 text-sm">{{ $permohonan->alamat_gardu }}</p>
                </div>
                <div>
                    <span class="text-xs text-gray-400 uppercase tracking-wider font-medium">Nama Gardu</span>
                    <p class="font-semibold text-gray-800 mt-1 text-sm">{{ $permohonan->nama_gardu }}</p>
                </div>
            </div>
        </div>
    </div>
    
    {{-- ==================== DOKUMEN ==================== --}}
    <div class="bg-white rounded-[48px] p-6 shadow-sm border border-gray-100">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-8 h-8 rounded-full bg-pln-primary/10 flex items-center justify-center">
                <svg class="w-4 h-4 text-pln-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h3 class="font-semibold text-gray-800">Dokumen</h3>
        </div>
        
        {{-- Header Label --}}
        <div class="flex items-center justify-end mb-2 px-1">
            <div class="flex items-center gap-6">
                <span class="text-xs text-gray-400 font-medium w-9 text-center">Lihat</span>
                <span class="text-xs text-gray-400 font-medium w-4 text-center">Tolak</span>
            </div>
        </div>
        
        <div class="space-y-2">
            
            {{-- BA Lahan --}}
            <div class="flex items-center justify-between p-3.5 bg-gray-50 rounded-[32px] hover:bg-gray-100/70 transition">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800 text-sm">BA Lahan</p>
                        @if($permohonan->ba_lahan_type == 'upload')
                            <span class="text-xs text-gray-400">File Upload</span>
                        @elseif($permohonan->ba_lahan_type == 'form')
                            <span class="text-xs text-gray-400">Form Isian</span>
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    @if($permohonan->ba_lahan_type == 'upload' && $permohonan->dokumen_ba_lahan)
                        @php $filePath = storage_path('app/public/' . $permohonan->dokumen_ba_lahan); $exists = file_exists($filePath); @endphp
                        @if($exists)
                        <a href="{{ asset('storage/' . $permohonan->dokumen_ba_lahan) }}" target="_blank" 
                           class="w-9 h-9 flex items-center justify-center rounded-full bg-white border border-gray-200 hover:bg-pln-primary hover:text-white hover:border-pln-primary transition group" title="Lihat Dokumen">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                        @else
                        <span class="text-xs text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full">⚠️ File tidak ditemukan</span>
                        @endif
                    @elseif($permohonan->ba_lahan_type == 'form' && $permohonan->ba_lahan_data)
                        <button onclick="toggleBaLahan()" 
                                class="w-9 h-9 flex items-center justify-center rounded-full bg-white border border-gray-200 hover:bg-pln-primary hover:text-white hover:border-pln-primary transition group" title="Lihat Form">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    @else
                        <span class="text-xs text-gray-400">-</span>
                    @endif
                    
                    @if($permohonan->status == 'pending')
                    <input type="checkbox" class="doc-reject-checkbox w-4 h-4 rounded border-gray-300 accent-red-500" data-doc="ba_lahan" title="Tandai untuk ditolak">
                    @else
                    <span class="w-4"></span>
                    @endif
                </div>
            </div>
            
            @if($permohonan->ba_lahan_type == 'form' && $permohonan->ba_lahan_data)
            <div id="baLahanDetail" style="display: none;" class="mt-2 p-4 bg-gray-50 rounded-[32px] text-sm space-y-2 border border-gray-100">
                @php $data = json_decode($permohonan->ba_lahan_data, true); @endphp
                <div class="grid grid-cols-2 gap-3">
                    <div><span class="text-xs text-gray-400">Unit PLN</span><p class="font-medium text-gray-800 text-sm">{{ $data['unit_pln'] ?? '-' }}</p></div>
                    <div><span class="text-xs text-gray-400">Nama Pekerjaan</span><p class="font-medium text-gray-800 text-sm">{{ $data['nama_pekerjaan'] ?? '-' }}</p></div>
                    <div><span class="text-xs text-gray-400">Desa/Kelurahan</span><p class="font-medium text-gray-800 text-sm">{{ $data['desa_kelurahan'] ?? '-' }}</p></div>
                    <div><span class="text-xs text-gray-400">Kecamatan</span><p class="font-medium text-gray-800 text-sm">{{ $data['kecamatan'] ?? '-' }}</p></div>
                    <div><span class="text-xs text-gray-400">Kabupaten/Kota</span><p class="font-medium text-gray-800 text-sm">{{ $data['kabupaten_kota'] ?? '-' }}</p></div>
                    <div><span class="text-xs text-gray-400">Nama Pemilik</span><p class="font-medium text-gray-800 text-sm">{{ $data['nama_pemilik'] ?? '-' }}</p></div>
                    <div><span class="text-xs text-gray-400">No Telepon Pemilik</span><p class="font-medium text-gray-800 text-sm">{{ $data['no_telepon_pemilik'] ?? '-' }}</p></div>
                    <div><span class="text-xs text-gray-400">Alamat Pemilik</span><p class="font-medium text-gray-800 text-sm">{{ $data['alamat_pemilik'] ?? '-' }}</p></div>
                    <div><span class="text-xs text-gray-400">Status</span><p class="font-medium text-gray-800 text-sm">{{ $data['status_pemilik'] ?? '-' }}</p></div>
                </div>
                <div class="pt-2 border-t border-gray-200 space-y-1">
                    <p class="text-sm">{{ !empty($data['pernyataan_1']) ? '✅' : '❌' }} Berdampak terhadap 200 orang atau lebih</p>
                    <p class="text-sm">{{ !empty($data['pernyataan_2']) ? '✅' : '❌' }} Berdampak terhadap berkurangnya pendapatan >10%</p>
                    <p class="text-sm">{{ !empty($data['pernyataan_3']) ? '✅' : '❌' }} Berlokasi di lahan masyarakat adat</p>
                    <p class="text-sm">{{ !empty($data['pernyataan_4']) ? '✅' : '❌' }} Berdampak negatif terhadap masyarakat adat</p>
                </div>
            </div>
            @endif
            
            {{-- BA Lingkungan --}}
            <div class="flex items-center justify-between p-3.5 bg-gray-50 rounded-[32px] hover:bg-gray-100/70 transition">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800 text-sm">BA Lingkungan</p>
                        @if($permohonan->ba_lingkungan_type == 'upload')
                            <span class="text-xs text-gray-400">File Upload</span>
                        @elseif($permohonan->ba_lingkungan_type == 'form')
                            <span class="text-xs text-gray-400">Form Isian</span>
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    @if($permohonan->ba_lingkungan_type == 'upload' && $permohonan->dokumen_ba_lingkungan)
                        @php $filePath = storage_path('app/public/' . $permohonan->dokumen_ba_lingkungan); $exists = file_exists($filePath); @endphp
                        @if($exists)
                        <a href="{{ asset('storage/' . $permohonan->dokumen_ba_lingkungan) }}" target="_blank" 
                           class="w-9 h-9 flex items-center justify-center rounded-full bg-white border border-gray-200 hover:bg-pln-primary hover:text-white hover:border-pln-primary transition group" title="Lihat Dokumen">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                        @else
                        <span class="text-xs text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full">⚠️ File tidak ditemukan</span>
                        @endif
                    @elseif($permohonan->ba_lingkungan_type == 'form' && $permohonan->ba_lingkungan_data)
                        <button onclick="toggleBaLingkungan()" 
                                class="w-9 h-9 flex items-center justify-center rounded-full bg-white border border-gray-200 hover:bg-pln-primary hover:text-white hover:border-pln-primary transition group" title="Lihat Form">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    @else
                        <span class="text-xs text-gray-400">-</span>
                    @endif
                    
                    @if($permohonan->status == 'pending')
                    <input type="checkbox" class="doc-reject-checkbox w-4 h-4 rounded border-gray-300 accent-red-500" data-doc="ba_lingkungan" title="Tandai untuk ditolak">
                    @else
                    <span class="w-4"></span>
                    @endif
                </div>
            </div>
            
            @if($permohonan->ba_lingkungan_type == 'form' && $permohonan->ba_lingkungan_data)
            <div id="baLingkunganDetail" style="display: none;" class="mt-2 p-4 bg-gray-50 rounded-[32px] text-sm space-y-2 border border-gray-100">
                @php $data = json_decode($permohonan->ba_lingkungan_data, true); @endphp
                <div class="grid grid-cols-2 gap-3">
                    <div><span class="text-xs text-gray-400">Nomor BA</span><p class="font-medium text-gray-800 text-sm">{{ $data['nomor_ba'] ?? '-' }}</p></div>
                    <div><span class="text-xs text-gray-400">Pihak Kesatu</span><p class="font-medium text-gray-800 text-sm">{{ $data['nama_pihak_kesatu'] ?? '-' }}</p></div>
                    <div><span class="text-xs text-gray-400">Jabatan Pihak Kesatu</span><p class="font-medium text-gray-800 text-sm">{{ $data['jabatan_pihak_kesatu'] ?? '-' }}</p></div>
                    <div><span class="text-xs text-gray-400">Pihak Kedua (PLN)</span><p class="font-medium text-gray-800 text-sm">{{ $data['nama_pihak_kedua'] ?? '-' }}</p></div>
                    <div><span class="text-xs text-gray-400">Luas Tanah</span><p class="font-medium text-gray-800 text-sm">{{ $data['luas_tanah'] ?? '-' }}</p></div>
                    <div><span class="text-xs text-gray-400">Lokasi</span><p class="font-medium text-gray-800 text-sm">{{ $data['lokasi'] ?? '-' }}</p></div>
                    <div><span class="text-xs text-gray-400">Nomor Sertifikat</span><p class="font-medium text-gray-800 text-sm">{{ $data['nomor_sertifikat'] ?? '-' }}</p></div>
                    <div><span class="text-xs text-gray-400">Batas Utara</span><p class="font-medium text-gray-800 text-sm">{{ $data['batas_utara'] ?? '-' }}</p></div>
                    <div><span class="text-xs text-gray-400">Batas Timur</span><p class="font-medium text-gray-800 text-sm">{{ $data['batas_timur'] ?? '-' }}</p></div>
                    <div><span class="text-xs text-gray-400">Batas Selatan</span><p class="font-medium text-gray-800 text-sm">{{ $data['batas_selatan'] ?? '-' }}</p></div>
                    <div><span class="text-xs text-gray-400">Batas Barat</span><p class="font-medium text-gray-800 text-sm">{{ $data['batas_barat'] ?? '-' }}</p></div>
                </div>
            </div>
            @endif
            
            {{-- Written Agreement --}}
            <div class="flex items-center justify-between p-3.5 bg-gray-50 rounded-[32px] hover:bg-gray-100/70 transition">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-purple-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <p class="font-medium text-gray-800 text-sm">Written Agreement</p>
                </div>
                <div class="flex items-center gap-6">
                    @if($permohonan->dokumen_return_agrimen)
                        @php $filePath = storage_path('app/public/' . $permohonan->dokumen_return_agrimen); $exists = file_exists($filePath); @endphp
                        @if($exists)
                        <a href="{{ asset('storage/' . $permohonan->dokumen_return_agrimen) }}" target="_blank" 
                           class="w-9 h-9 flex items-center justify-center rounded-full bg-white border border-gray-200 hover:bg-pln-primary hover:text-white hover:border-pln-primary transition group" title="Lihat Dokumen">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                        @else
                        <span class="text-xs text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full">⚠️ File tidak ditemukan</span>
                        @endif
                    @else
                        <span class="text-xs text-gray-400">-</span>
                    @endif
                    
                    @if($permohonan->status == 'pending')
                    <input type="checkbox" class="doc-reject-checkbox w-4 h-4 rounded border-gray-300 accent-red-500" data-doc="return_agrimen" title="Tandai untuk ditolak">
                    @else
                    <span class="w-4"></span>
                    @endif
                </div>
            </div>
            
            {{-- IMB --}}
            <div class="flex items-center justify-between p-3.5 bg-gray-50 rounded-[32px] hover:bg-gray-100/70 transition">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-orange-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <p class="font-medium text-gray-800 text-sm">IMB <span class="text-xs text-gray-400">(Opsional)</span></p>
                </div>
                <div class="flex items-center gap-6">
                    @if($permohonan->dokumen_imb)
                        @php $filePath = storage_path('app/public/' . $permohonan->dokumen_imb); $exists = file_exists($filePath); @endphp
                        @if($exists)
                        <a href="{{ asset('storage/' . $permohonan->dokumen_imb) }}" target="_blank" 
                           class="w-9 h-9 flex items-center justify-center rounded-full bg-white border border-gray-200 hover:bg-pln-primary hover:text-white hover:border-pln-primary transition group" title="Lihat Dokumen">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                        @else
                        <span class="text-xs text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full">⚠️ File tidak ditemukan</span>
                        @endif
                    @else
                        <span class="text-xs text-gray-400">-</span>
                    @endif
                    
                    @if($permohonan->status == 'pending')
                    <input type="checkbox" class="doc-reject-checkbox w-4 h-4 rounded border-gray-300 accent-red-500" data-doc="imb" title="Tandai untuk ditolak">
                    @else
                    <span class="w-4"></span>
                    @endif
                </div>
            </div>
            
            {{-- Sertifikat Lahan --}}
            <div class="flex items-center justify-between p-3.5 bg-gray-50 rounded-[32px] hover:bg-gray-100/70 transition">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-teal-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <p class="font-medium text-gray-800 text-sm">Sertifikat Lahan <span class="text-xs text-gray-400">(Opsional)</span></p>
                </div>
                <div class="flex items-center gap-6">
                    @if($permohonan->dokumen_sertifikat_lahan)
                        @php $filePath = storage_path('app/public/' . $permohonan->dokumen_sertifikat_lahan); $exists = file_exists($filePath); @endphp
                        @if($exists)
                        <a href="{{ asset('storage/' . $permohonan->dokumen_sertifikat_lahan) }}" target="_blank" 
                           class="w-9 h-9 flex items-center justify-center rounded-full bg-white border border-gray-200 hover:bg-pln-primary hover:text-white hover:border-pln-primary transition group" title="Lihat Dokumen">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                        @else
                        <span class="text-xs text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full">⚠️ File tidak ditemukan</span>
                        @endif
                    @else
                        <span class="text-xs text-gray-400">-</span>
                    @endif
                    
                    @if($permohonan->status == 'pending')
                    <input type="checkbox" class="doc-reject-checkbox w-4 h-4 rounded border-gray-300 accent-red-500" data-doc="sertifikat_lahan" title="Tandai untuk ditolak">
                    @else
                    <span class="w-4"></span>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
  {{-- Export Data --}}
<div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
    <h3 class="font-semibold text-gray-800 mb-3 text-sm">Export Data</h3>
    <a href="{{ route('admin.export.permohonan', $permohonan->id) }}" 
       style="display: block; width: 100%; padding: 12px; background: #059669; color: white; text-align: center; border-radius: 12px; font-size: 14px; font-weight: 500; text-decoration: none;">
        Export Excel
    </a>
</div>
</div>
    {{-- Tanda Tangan --}}
    <div class="bg-white rounded-[48px] p-5 shadow-sm border border-gray-100">
        <h3 class="font-semibold text-gray-800 mb-3">Tanda Tangan</h3>
        <div class="grid grid-cols-2 gap-4">
            @foreach(['ba_lahan' => 'BA Lahan', 'ba_lingkungan' => 'BA Lingkungan'] as $key => $label)
            <div>
                <p class="text-sm text-gray-500 mb-2">{{ $label }}</p>
                @if($permohonan->{'ttd_' . $key})
                <div class="border rounded-[24px] p-2 bg-gray-50">
                    <img src="{{ $permohonan->{'ttd_' . $key} }}" alt="TTD {{ $label }}" class="max-h-24 mx-auto">
                </div>
                <div class="flex gap-2 mt-2">
                    <a href="{{ $permohonan->{'ttd_' . $key} }}" download="ttd_{{ $key }}_{{ $permohonan->id }}.png" 
                       class="text-xs text-pln-primary border border-pln-primary px-3 py-1 rounded-full">
                        📥 Download PNG
                    </a>
                    <button onclick="downloadTransparentSignature('{{ $permohonan->{'ttd_' . $key} }}', 'ttd_{{ $key }}_{{ $permohonan->id }}')" 
                            class="text-xs text-green-600 border border-green-600 px-3 py-1 rounded-full">
                        📥 Download (Transparan)
                    </button>
                </div>
                @else
                <p class="text-gray-400 text-sm">
                    @if($permohonan->{$key . '_type'} == 'upload') ✅ TTD Manual (ada di file)
                    @elseif($permohonan->{$key . '_type'} == 'form') ❌ TTD Elektronik tidak ditemukan
                    @else - @endif
                </p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    
    {{-- Tombol Aksi (hanya jika pending) --}}
    @if($permohonan->status == 'pending')
    <div class="flex gap-3">
        <button onclick="openApproveModal()" class="btn btn-success flex-1 rounded-full">
            ✅ Setujui
        </button>
        <button onclick="openRejectModal()" class="btn flex-1 rounded-full" style="background: #FEE2E2; color: #991B1B;">
            ❌ Tolak
        </button>
    </div>
    @endif
    
</div>

{{-- MODAL APPROVE --}}
<div id="approveModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[48px] w-full max-w-md p-6">
        <h3 class="text-xl font-bold mb-4">Setujui Permohonan</h3>
        <form action="{{ route('admin.verifikasi.approve', $permohonan->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Catatan (Opsional)</label>
                <textarea name="catatan_admin" rows="3" class="input-field rounded-[24px]" placeholder="Masukkan catatan (opsional)..."></textarea>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeApproveModal()" class="btn btn-outline flex-1 rounded-full">Batal</button>
                <button type="submit" class="btn btn-success flex-1 rounded-full">Setujui</button>
            </div>
        </form>
    </div>
</div>

{{-- ==================== MODAL REJECT (NEW DESIGN) ==================== --}}
<div id="rejectModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-[48px] w-full max-w-lg max-h-[90vh] overflow-y-auto">
        
        {{-- Header Modal --}}
        <div class="p-6 pb-2">
            <div class="flex items-center justify-between mb-1">
                <h3 class="text-xl font-bold text-gray-800">Tolak Permohonan</h3>
                <button onclick="closeRejectModal()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <p class="text-sm text-gray-500">Pilih dokumen yang ditolak</p>
            <p class="text-xs text-gray-400 mt-0.5">Berikan alasan penolakan untuk setiap dokumen yang dipilih.</p>
        </div>
        
        <form action="{{ route('admin.verifikasi.reject', $permohonan->id) }}" method="POST">
            @csrf
            
            {{-- List Dokumen --}}
            <div class="px-6 py-4 space-y-4">
                
                @foreach([
                    'ba_lahan' => ['BA Lahan', false],
                    'ba_lingkungan' => ['BA Lingkungan', false],
                    'return_agrimen' => ['Written Agreement', false],
                    'imb' => ['IMB', true],
                    'sertifikat_lahan' => ['Sertifikat Lahan', true],
                ] as $docKey => [$docLabel, $isOptional])
                <div class="pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                    {{-- Checkbox & Nama Dokumen --}}
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="dokumen_ditolak[{{ $docKey }}]" value="1" 
                               class="doc-reject-form-checkbox w-5 h-5 rounded border-gray-300 accent-red-500" data-doc="{{ $docKey }}">
                        <span class="font-medium text-gray-800">
                            {{ $docLabel }}
                            @if($isOptional)
                            <span class="text-gray-400 font-normal text-sm">(Opsional)</span>
                            @endif
                        </span>
                    </label>
                    
                    {{-- Alasan Textarea + Counter --}}
                    <div class="doc-reject-reason-container mt-3 hidden">
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Alasan Penolakan</label>
                        <textarea name="alasan[{{ $docKey }}]" rows="3" 
                                  class="doc-reject-reason w-full border border-gray-200 rounded-[24px] p-3 text-sm resize-none focus:border-red-400 focus:ring-1 focus:ring-red-400" 
                                  placeholder="Tulis alasan penolakan..."
                                  maxlength="255"
                                  oninput="updateCharCount(this, 'counter-{{ $docKey }}')"></textarea>
                        <p class="text-right text-xs text-gray-400 mt-1">
                            <span id="counter-{{ $docKey }}">0</span>/255
                        </p>
                    </div>
                </div>
                @endforeach
                
            </div>
            
            {{-- Tombol Tolak --}}
            <div class="p-6 pt-2">
                <button type="submit" 
                        class="w-full py-4 bg-red-600 hover:bg-red-700 text-white font-bold text-base rounded-full transition-all duration-200 shadow-lg shadow-red-200 hover:shadow-xl hover:shadow-red-300 active:scale-95">
                    Tolak Permohonan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openApproveModal() {
        document.getElementById('approveModal').classList.remove('hidden');
        document.getElementById('approveModal').classList.add('flex');
    }
    function closeApproveModal() {
        document.getElementById('approveModal').classList.add('hidden');
        document.getElementById('approveModal').classList.remove('flex');
    }
    function openRejectModal() {
        document.getElementById('rejectModal').classList.remove('hidden');
        document.getElementById('rejectModal').classList.add('flex');
        
        // Sync checkbox dari halaman dokumen ke modal reject
        document.querySelectorAll('.doc-reject-checkbox').forEach(cb => {
            const docKey = cb.getAttribute('data-doc');
            const modalCb = document.querySelector(`.doc-reject-form-checkbox[data-doc="${docKey}"]`);
            if (modalCb && cb.checked) {
                modalCb.checked = true;
                modalCb.dispatchEvent(new Event('change'));
            }
        });
    }
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('rejectModal').classList.remove('flex');
    }
    
    // Close modals on background click
    document.addEventListener('click', function(e) {
        if (e.target.id === 'approveModal') closeApproveModal();
        if (e.target.id === 'rejectModal') closeRejectModal();
    });
    
    // Toggle alasan textarea + counter
    document.querySelectorAll('.doc-reject-form-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const container = this.closest('.pb-4').querySelector('.doc-reject-reason-container');
            const textarea = this.closest('.pb-4').querySelector('.doc-reject-reason');
            if (this.checked) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
                if (textarea) textarea.value = '';
                const counter = this.closest('.pb-4').querySelector('[id^="counter-"]');
                if (counter) counter.textContent = '0';
            }
        });
    });
    
    // Character counter
    function updateCharCount(textarea, counterId) {
        const counter = document.getElementById(counterId);
        if (counter) {
            counter.textContent = textarea.value.length;
        }
    }
    
    function toggleBaLahan() {
        var el = document.getElementById('baLahanDetail');
        el.style.display = el.style.display === 'none' ? 'block' : 'none';
    }
    function toggleBaLingkungan() {
        var el = document.getElementById('baLingkunganDetail');
        el.style.display = el.style.display === 'none' ? 'block' : 'none';
    }
    
    function downloadTransparentSignature(dataUrl, filename) {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        const img = new Image();
        img.crossOrigin = 'anonymous';
        img.onload = function() {
            canvas.width = img.width;
            canvas.height = img.height;
            ctx.drawImage(img, 0, 0);
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const data = imageData.data;
            for (let i = 0; i < data.length; i += 4) {
                if (data[i] > 200 && data[i + 1] > 200 && data[i + 2] > 200) {
                    data[i + 3] = 0;
                }
            }
            ctx.putImageData(imageData, 0, 0);
            const link = document.createElement('a');
            link.download = filename + '_transparan.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
        };
        img.src = dataUrl;
    }
</script>

@endsection