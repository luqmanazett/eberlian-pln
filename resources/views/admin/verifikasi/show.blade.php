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
    
    {{-- Info Pemohon --}}
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
        <h3 class="font-semibold text-gray-800 mb-3">Data Pemohon</h3>
        
        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500">Pemohon</span>
                <span class="font-medium">{{ $permohonan->nama_pelanggan }}</span>
            </div>
            <div class="flex justify-between">
    <span class="text-gray-500">Diajukan oleh</span>
    <span class="font-medium">{{ $permohonan->user->name ?? '-' }}</span>
</div>
            <div class="flex justify-between">
                <span class="text-gray-500">Jenis Permohonan</span>
                <span class="font-medium">
                    @if($permohonan->jenis_permohonan == 'pasang_baru') Pasang Baru
                    @elseif($permohonan->jenis_permohonan == 'tambah_daya') Tambah Daya
                    @else Peningkatan Keandalan @endif
                </span>
            </div>
            @if($permohonan->idpel)
            <div class="flex justify-between">
                <span class="text-gray-500">IDPEL</span>
                <span class="font-medium">{{ $permohonan->idpel }}</span>
            </div>
            @endif
            <div class="flex justify-between">
                <span class="text-gray-500">No KTP</span>
                <span class="font-medium">{{ $permohonan->no_ktp }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Tanggal Pengajuan</span>
                <span class="font-medium">{{ $permohonan->created_at->format('d M Y - H:i') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">ULP</span>
                <span class="font-medium">{{ $permohonan->ulp }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Alamat Gardu</span>
                <span class="font-medium">{{ $permohonan->alamat_gardu }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Nama Gardu</span>
                <span class="font-medium">{{ $permohonan->nama_gardu }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">No Telepon</span>
                <span class="font-medium">{{ $permohonan->no_telepon }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Status</span>
                <span>
                    @if($permohonan->status == 'pending')
                    <span class="badge badge-pending">Menunggu Verifikasi</span>
                    @elseif($permohonan->status == 'approved')
                    <span class="badge badge-approved">Disetujui</span>
                    @else
                    <span class="badge badge-rejected">Ditolak</span>
                    @endif
                </span>
            </div>
        </div>
    </div>
    
    {{-- Dokumen --}}
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
        <h3 class="font-semibold text-gray-800 mb-3">Dokumen</h3>
        <div class="space-y-3">
            
            {{-- BA Lahan --}}
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 font-medium">BA Lahan</span>
                    @if($permohonan->ba_lahan_type == 'upload' && $permohonan->dokumen_ba_lahan)
                    @php
                        $filePath = storage_path('app/public/' . $permohonan->dokumen_ba_lahan);
                        $exists = file_exists($filePath);
                    @endphp
                    @if($exists)
                    <a href="{{ asset('storage/' . $permohonan->dokumen_ba_lahan) }}" target="_blank" class="text-pln-primary text-sm">Lihat Dokumen</a>
                    @else
                    <span class="text-yellow-600 text-sm">File tidak ditemukan</span>
                    @endif
                    @elseif($permohonan->ba_lahan_type == 'form' && $permohonan->ba_lahan_data)
                    <button onclick="toggleBaLahan()" class="text-pln-primary text-sm">Lihat Form ▼</button>
                    @else
                    <span class="text-gray-400 text-sm">-</span>
                    @endif
                </div>
                @if($permohonan->ba_lahan_type == 'form' && $permohonan->ba_lahan_data)
                <div id="baLahanDetail" style="display: none;" class="mt-3 p-3 bg-gray-50 rounded-lg text-sm space-y-1">
                    @php $data = json_decode($permohonan->ba_lahan_data, true); @endphp
                    <p><strong>Unit PLN:</strong> {{ $data['unit_pln'] ?? '-' }}</p>
                    <p><strong>Nama Pekerjaan:</strong> {{ $data['nama_pekerjaan'] ?? '-' }}</p>
                    <p><strong>Desa/Kelurahan:</strong> {{ $data['desa_kelurahan'] ?? '-' }}</p>
                    <p><strong>Kecamatan:</strong> {{ $data['kecamatan'] ?? '-' }}</p>
                    <p><strong>Kabupaten/Kota:</strong> {{ $data['kabupaten_kota'] ?? '-' }}</p>
                    <p><strong>Nama Pemilik:</strong> {{ $data['nama_pemilik'] ?? '-' }}</p>
                    <p><strong>No Telepon Pemilik:</strong> {{ $data['no_telepon_pemilik'] ?? '-' }}</p>
                    <p><strong>Alamat Pemilik:</strong> {{ $data['alamat_pemilik'] ?? '-' }}</p>
                    <p><strong>Status:</strong> {{ $data['status_pemilik'] ?? '-' }}</p>
                    <p><strong>Pernyataan 1:</strong> {{ !empty($data['pernyataan_1']) ? '✅' : '❌' }} Berdampak terhadap 200 orang atau lebih</p>
                    <p><strong>Pernyataan 2:</strong> {{ !empty($data['pernyataan_2']) ? '✅' : '❌' }} Berdampak terhadap berkurangnya pendapatan >10%</p>
                    <p><strong>Pernyataan 3:</strong> {{ !empty($data['pernyataan_3']) ? '✅' : '❌' }} Berlokasi di lahan masyarakat adat</p>
                    <p><strong>Pernyataan 4:</strong> {{ !empty($data['pernyataan_4']) ? '✅' : '❌' }} Berdampak negatif terhadap masyarakat adat</p>
                </div>
                @endif
            </div>
            
            {{-- BA Lingkungan --}}
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 font-medium">BA Lingkungan</span>
                    @if($permohonan->ba_lingkungan_type == 'upload' && $permohonan->dokumen_ba_lingkungan)
                    @php
                        $filePath = storage_path('app/public/' . $permohonan->dokumen_ba_lingkungan);
                        $exists = file_exists($filePath);
                    @endphp
                    @if($exists)
                    <a href="{{ asset('storage/' . $permohonan->dokumen_ba_lingkungan) }}" target="_blank" class="text-pln-primary text-sm">Lihat Dokumen</a>
                    @else
                    <span class="text-yellow-600 text-sm">File tidak ditemukan</span>
                    @endif
                    @elseif($permohonan->ba_lingkungan_type == 'form' && $permohonan->ba_lingkungan_data)
                    <button onclick="toggleBaLingkungan()" class="text-pln-primary text-sm">Lihat Form ▼</button>
                    @else
                    <span class="text-gray-400 text-sm">-</span>
                    @endif
                </div>
                @if($permohonan->ba_lingkungan_type == 'form' && $permohonan->ba_lingkungan_data)
                <div id="baLingkunganDetail" style="display: none;" class="mt-3 p-3 bg-gray-50 rounded-lg text-sm space-y-1">
                    @php $data = json_decode($permohonan->ba_lingkungan_data, true); @endphp
                    <p><strong>Nomor BA:</strong> {{ $data['nomor_ba'] ?? '-' }}</p>
                    <p><strong>Pihak Kesatu:</strong> {{ $data['nama_pihak_kesatu'] ?? '-' }}</p>
                    <p><strong>Jabatan Pihak Kesatu:</strong> {{ $data['jabatan_pihak_kesatu'] ?? '-' }}</p>
                    <p><strong>Pihak Kedua (PLN):</strong> {{ $data['nama_pihak_kedua'] ?? '-' }}</p>
                    <p><strong>Luas Tanah:</strong> {{ $data['luas_tanah'] ?? '-' }}</p>
                    <p><strong>Lokasi:</strong> {{ $data['lokasi'] ?? '-' }}</p>
                    <p><strong>Nomor Sertifikat:</strong> {{ $data['nomor_sertifikat'] ?? '-' }}</p>
                    <p><strong>Batas Utara:</strong> {{ $data['batas_utara'] ?? '-' }}</p>
                    <p><strong>Batas Timur:</strong> {{ $data['batas_timur'] ?? '-' }}</p>
                    <p><strong>Batas Selatan:</strong> {{ $data['batas_selatan'] ?? '-' }}</p>
                    <p><strong>Batas Barat:</strong> {{ $data['batas_barat'] ?? '-' }}</p>
                </div>
                @endif
            </div>
            
            {{-- Written Agreement --}}
            <div class="flex items-center justify-between pt-2 border-t">
                <span class="text-sm text-gray-600 font-medium">Written Agreement</span>
                @if($permohonan->dokumen_return_agrimen)
                @php
                    $filePath = storage_path('app/public/' . $permohonan->dokumen_return_agrimen);
                    $exists = file_exists($filePath);
                @endphp
                @if($exists)
                <a href="{{ asset('storage/' . $permohonan->dokumen_return_agrimen) }}" target="_blank" class="text-pln-primary text-sm">Lihat Dokumen</a>
                @else
                <span class="text-yellow-600 text-sm">File tidak ditemukan</span>
                @endif
                @else
                <span class="text-gray-400 text-sm">-</span>
                @endif
            </div>
            
            {{-- IMB --}}
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">IMB (Opsional)</span>
                @if($permohonan->dokumen_imb)
                @php
                    $filePath = storage_path('app/public/' . $permohonan->dokumen_imb);
                    $exists = file_exists($filePath);
                @endphp
                @if($exists)
                <a href="{{ asset('storage/' . $permohonan->dokumen_imb) }}" target="_blank" class="text-pln-primary text-sm">Lihat Dokumen</a>
                @else
                <span class="text-yellow-600 text-sm">File tidak ditemukan</span>
                @endif
                @else
                <span class="text-gray-400 text-sm">-</span>
                @endif
            </div>
            
            {{-- Sertifikat Lahan --}}
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Sertifikat Lahan (Opsional)</span>
                @if($permohonan->dokumen_sertifikat_lahan)
                @php
                    $filePath = storage_path('app/public/' . $permohonan->dokumen_sertifikat_lahan);
                    $exists = file_exists($filePath);
                @endphp
                @if($exists)
                <a href="{{ asset('storage/' . $permohonan->dokumen_sertifikat_lahan) }}" target="_blank" class="text-pln-primary text-sm">Lihat Dokumen</a>
                @else
                <span class="text-yellow-600 text-sm">File tidak ditemukan</span>
                @endif
                @else
                <span class="text-gray-400 text-sm">-</span>
                @endif
            </div>
        </div>
    </div>
    
    {{-- Tanda Tangan --}}
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
        <h3 class="font-semibold text-gray-800 mb-3">Tanda Tangan</h3>
        <div class="grid grid-cols-2 gap-4">
            {{-- BA Lahan --}}
            <div>
                <p class="text-sm text-gray-500 mb-2">BA Lahan</p>
                @if($permohonan->ttd_ba_lahan)
                <div class="border rounded-lg p-2 bg-gray-50">
                    <img src="{{ $permohonan->ttd_ba_lahan }}" alt="TTD BA Lahan" class="max-h-24 mx-auto">
                </div>
                <div class="flex gap-2 mt-2">
                    <a href="{{ $permohonan->ttd_ba_lahan }}" download="ttd_ba_lahan_{{ $permohonan->id }}.png" 
                       class="text-xs text-pln-primary border border-pln-primary px-3 py-1 rounded">
                        📥 Download PNG
                    </a>
                    <button onclick="downloadTransparentSignature('{{ $permohonan->ttd_ba_lahan }}', 'ttd_ba_lahan_{{ $permohonan->id }}')" 
                            class="text-xs text-green-600 border border-green-600 px-3 py-1 rounded">
                        📥 Download (Transparan)
                    </button>
                </div>
                @else
                <p class="text-gray-400 text-sm">
                    @if($permohonan->ba_lahan_type == 'upload')
                    ✅ TTD Manual (ada di file)
                    @elseif($permohonan->ba_lahan_type == 'form')
                    ❌ TTD Elektronik tidak ditemukan
                    @else
                    -
                    @endif
                </p>
                @endif
            </div>
            
            {{-- BA Lingkungan --}}
            <div>
                <p class="text-sm text-gray-500 mb-2">BA Lingkungan</p>
                @if($permohonan->ttd_ba_lingkungan)
                <div class="border rounded-lg p-2 bg-gray-50">
                    <img src="{{ $permohonan->ttd_ba_lingkungan }}" alt="TTD BA Lingkungan" class="max-h-24 mx-auto">
                </div>
                <div class="flex gap-2 mt-2">
                    <a href="{{ $permohonan->ttd_ba_lingkungan }}" download="ttd_ba_lingkungan_{{ $permohonan->id }}.png" 
                       class="text-xs text-pln-primary border border-pln-primary px-3 py-1 rounded">
                        📥 Download PNG
                    </a>
                    <button onclick="downloadTransparentSignature('{{ $permohonan->ttd_ba_lingkungan }}', 'ttd_ba_lingkungan_{{ $permohonan->id }}')" 
                            class="text-xs text-green-600 border border-green-600 px-3 py-1 rounded">
                        📥 Download (Transparan)
                    </button>
                </div>
                @else
                <p class="text-gray-400 text-sm">
                    @if($permohonan->ba_lingkungan_type == 'upload')
                    ✅ TTD Manual (ada di file)
                    @elseif($permohonan->ba_lingkungan_type == 'form')
                    ❌ TTD Elektronik tidak ditemukan
                    @else
                    -
                    @endif
                </p>
                @endif
            </div>
        </div>
    </div>
    
    {{-- Tombol Aksi (hanya jika pending) --}}
    @if($permohonan->status == 'pending')
    <div class="flex gap-3">
        <button onclick="openApproveModal()" class="btn btn-success flex-1">
            ✅ Setujui
        </button>
        <button onclick="openRejectModal()" class="btn flex-1" style="background: #FEE2E2; color: #991B1B;">
            ❌ Tolak
        </button>
    </div>
    @endif
    
</div>

{{-- MODAL APPROVE --}}
<div id="approveModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-xl w-full max-w-md p-6">
        <h3 class="text-xl font-bold mb-4">Setujui Permohonan</h3>
        
        <form action="{{ route('admin.verifikasi.approve', $permohonan->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Catatan (Opsional)</label>
                <textarea name="catatan_admin" rows="3" class="input-field" placeholder="Masukkan catatan (opsional)..."></textarea>
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeApproveModal()" class="btn btn-outline flex-1">Batal</button>
                <button type="submit" class="btn btn-success flex-1">Setujui</button>
            </div>
        </form>
    </div>
</div>
{{-- MODAL REJECT --}}
<div id="rejectModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-xl w-full max-w-md p-6 max-h-[90vh] overflow-y-auto">
        <h3 class="text-xl font-bold mb-4">Tolak Permohonan</h3>
        <p class="text-sm text-gray-500 mb-4">Pilih komponen yang ditolak dan berikan alasan.</p>
        
        <form action="{{ route('admin.verifikasi.reject', $permohonan->id) }}" method="POST">
            @csrf
            
            {{-- 1. Data Pemohon --}}
            <div class="mb-4 border-b border-gray-100 pb-4">
                <label class="flex items-center gap-2 mb-2">
                    <input type="checkbox" name="dokumen_ditolak[data_pemohon]" value="1" class="w-4 h-4 accent-pln-primary">
                    <span class="font-medium">📋 Data Pemohon</span>
                    <span class="text-red-500 text-xs">*</span>
                </label>
                <p class="text-xs text-gray-500 mb-2">⚠️ Jika dicentang, user harus membuat permohonan baru.</p>
                <textarea name="alasan[data_pemohon]" rows="2" class="input-field text-sm" placeholder="Contoh: Nama tidak sesuai KTP, No KTP salah..."></textarea>
            </div>
            
            {{-- 2. BA Lahan --}}
            <div class="mb-4 border-b border-gray-100 pb-4">
                <label class="flex items-center gap-2 mb-2">
                    <input type="checkbox" name="dokumen_ditolak[ba_lahan]" value="1" class="w-4 h-4 accent-pln-primary">
                    <span class="font-medium">📄 BA Lahan</span>
                    <span class="text-red-500 text-xs">*</span>
                </label>
                <textarea name="alasan[ba_lahan]" rows="2" class="input-field text-sm" placeholder="Contoh: Data tidak lengkap, TTD tidak valid..."></textarea>
            </div>
            
            {{-- 3. BA Lingkungan --}}
            <div class="mb-4 border-b border-gray-100 pb-4">
                <label class="flex items-center gap-2 mb-2">
                    <input type="checkbox" name="dokumen_ditolak[ba_lingkungan]" value="1" class="w-4 h-4 accent-pln-primary">
                    <span class="font-medium">📄 BA Lingkungan</span>
                    <span class="text-red-500 text-xs">*</span>
                </label>
                <textarea name="alasan[ba_lingkungan]" rows="2" class="input-field text-sm" placeholder="Contoh: Batas tidak jelas, luas tanah tidak sesuai..."></textarea>
            </div>
            
            {{-- 4. Written Agreement --}}
            <div class="mb-4 border-b border-gray-100 pb-4">
                <label class="flex items-center gap-2 mb-2">
                    <input type="checkbox" name="dokumen_ditolak[return_agrimen]" value="1" class="w-4 h-4 accent-pln-primary">
                    <span class="font-medium">📋 Written Agreement</span>
                    <span class="text-red-500 text-xs">*</span>
                </label>
                <textarea name="alasan[return_agrimen]" rows="2" class="input-field text-sm" placeholder="Contoh: Dokumen tidak terbaca, tidak ditandatangani..."></textarea>
            </div>
            
            {{-- 5. IMB --}}
            <div class="mb-4 border-b border-gray-100 pb-4">
                <label class="flex items-center gap-2 mb-2">
                    <input type="checkbox" name="dokumen_ditolak[imb]" value="1" class="w-4 h-4 accent-pln-primary">
                    <span class="font-medium">🖼️ IMB (Opsional)</span>
                </label>
                <textarea name="alasan[imb]" rows="2" class="input-field text-sm" placeholder="Contoh: Dokumen kadaluarsa..."></textarea>
            </div>
            
            {{-- 6. Sertifikat Lahan --}}
            <div class="mb-4 border-b border-gray-100 pb-4">
                <label class="flex items-center gap-2 mb-2">
                    <input type="checkbox" name="dokumen_ditolak[sertifikat_lahan]" value="1" class="w-4 h-4 accent-pln-primary">
                    <span class="font-medium">📜 Sertifikat Lahan (Opsional)</span>
                </label>
                <textarea name="alasan[sertifikat_lahan]" rows="2" class="input-field text-sm" placeholder="Contoh: Sertifikat tidak valid..."></textarea>
            </div>
            
            {{-- Catatan Tambahan --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Catatan Tambahan (Opsional)</label>
                <textarea name="catatan_reject_global" rows="2" class="input-field" placeholder="Masukkan catatan tambahan..."></textarea>
                <p class="text-xs text-gray-500 mt-1">ℹ️ Jika tidak ada yang dicentang, user harus membuat permohonan baru.</p>
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeRejectModal()" class="btn btn-outline flex-1">Batal</button>
                <button type="submit" class="btn flex-1" style="background: #FEE2E2; color: #991B1B;">Tolak</button>
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
    }
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('rejectModal').classList.remove('flex');
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
                const r = data[i];
                const g = data[i + 1];
                const b = data[i + 2];
                
                if (r > 200 && g > 200 && b > 200) {
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