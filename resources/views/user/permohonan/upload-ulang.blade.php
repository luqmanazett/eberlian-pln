@extends('components.pln-layout')

@section('title', 'Upload Ulang Dokumen - E-Berlian')
@section('header-title', 'Upload Ulang')

@section('content')
<div class="space-y-4 ">
    
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('user.permohonan.show', $permohonan->id) }}" class="text-gray-600">
            <span class="text-2xl">←</span>
        </a>
        <h2 class="text-xl font-bold text-gray-800">Upload Ulang</h2>
    </div>
    
    <div class="bg-yellow-50 rounded-xl p-4 border border-yellow-200 mb-4">
        <p class="text-yellow-800 text-sm">
            ⚠️ Perbaiki hanya dokumen yang ditolak.
        </p>
    </div>
    
    <form action="{{ route('user.upload-ulang.submit', $permohonan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        
        {{-- BA Lahan --}}
        @if(in_array('ba_lahan', $dokumenDitolak))
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <label class="block font-medium mb-3">BA Lahan <span class="text-red-500">*</span></label>
            
            @if($baLahanOption == 'upload')
                {{-- Opsi Upload --}}
                <input type="file" name="dokumen_ba_lahan" class="input-field" accept=".pdf,.jpg,.jpeg,.png" required>
                <p class="text-xs text-gray-500 mt-1">Max 5MB (PDF, JPG, PNG)</p>
            @else
                {{-- Opsi Form - Tampilkan form dengan data lama --}}
                <div class="space-y-3 border rounded-lg p-4 bg-gray-50">
                    <div>
                        <label class="text-xs font-medium">Unit PLN</label>
                        <input type="text" name="ba_lahan_form[unit_pln]" value="{{ $baLahanData['unit_pln'] ?? '' }}" class="input-field text-sm" required>
                    </div>
                    <div>
                        <label class="text-xs font-medium">Nama Pekerjaan</label>
                        <input type="text" name="ba_lahan_form[nama_pekerjaan]" value="{{ $baLahanData['nama_pekerjaan'] ?? '' }}" class="input-field text-sm" required>
                    </div>
                    <div>
                        <label class="text-xs font-medium">Desa/Kelurahan</label>
                        <input type="text" name="ba_lahan_form[desa_kelurahan]" value="{{ $baLahanData['desa_kelurahan'] ?? '' }}" class="input-field text-sm" required>
                    </div>
                    <div>
                        <label class="text-xs font-medium">Kecamatan</label>
                        <input type="text" name="ba_lahan_form[kecamatan]" value="{{ $baLahanData['kecamatan'] ?? '' }}" class="input-field text-sm" required>
                    </div>
                    <div>
                        <label class="text-xs font-medium">Kabupaten/Kota</label>
                        <input type="text" name="ba_lahan_form[kabupaten_kota]" value="{{ $baLahanData['kabupaten_kota'] ?? '' }}" class="input-field text-sm" required>
                    </div>
                    <div>
                        <label class="text-xs font-medium">Nama Pemilik Lahan</label>
                        <input type="text" name="ba_lahan_form[nama_pemilik]" value="{{ $baLahanData['nama_pemilik'] ?? '' }}" class="input-field text-sm" required>
                    </div>
                    <div>
                        <label class="text-xs font-medium">No Telepon Pemilik</label>
                        <input type="tel" name="ba_lahan_form[no_telepon_pemilik]" value="{{ $baLahanData['no_telepon_pemilik'] ?? '' }}" class="input-field text-sm" required>
                    </div>
                    <div>
                        <label class="text-xs font-medium">Alamat Pemilik</label>
                        <textarea name="ba_lahan_form[alamat_pemilik]" rows="2" class="input-field text-sm" required>{{ $baLahanData['alamat_pemilik'] ?? '' }}</textarea>
                    </div>
                    <div>
                        <label class="text-xs font-medium">Status</label>
                        <select name="ba_lahan_form[status_pemilik]" class="input-field text-sm" required>
                            <option value="">Pilih</option>
                            <option value="pemilik_lahan" {{ ($baLahanData['status_pemilik'] ?? '') == 'pemilik_lahan' ? 'selected' : '' }}>Pemilik Lahan</option>
                            <option value="masyarakat_terdampak" {{ ($baLahanData['status_pemilik'] ?? '') == 'masyarakat_terdampak' ? 'selected' : '' }}>Masyarakat Terdampak</option>
                            <option value="perwakilan" {{ ($baLahanData['status_pemilik'] ?? '') == 'perwakilan' ? 'selected' : '' }}>Perwakilan Pemilik Lahan</option>
                            <option value="pemerintah_desa" {{ ($baLahanData['status_pemilik'] ?? '') == 'pemerintah_desa' ? 'selected' : '' }}>Pemerintah Desa</option>
                        </select>
                    </div>
                    
                    {{-- Pernyataan --}}
                    <div class="space-y-2">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="ba_lahan_form[pernyataan_1]" value="1" {{ !empty($baLahanData['pernyataan_1']) ? 'checked' : '' }}>
                            <span class="text-xs">Berdampak terhadap 200 orang atau lebih</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="ba_lahan_form[pernyataan_2]" value="1" {{ !empty($baLahanData['pernyataan_2']) ? 'checked' : '' }}>
                            <span class="text-xs">Berdampak terhadap berkurangnya pendapatan >10%</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="ba_lahan_form[pernyataan_3]" value="1" {{ !empty($baLahanData['pernyataan_3']) ? 'checked' : '' }}>
                            <span class="text-xs">Berlokasi di lahan masyarakat adat</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="ba_lahan_form[pernyataan_4]" value="1" {{ !empty($baLahanData['pernyataan_4']) ? 'checked' : '' }}>
                            <span class="text-xs">Berdampak negatif terhadap masyarakat adat</span>
                        </label>
                    </div>
                    
                    {{-- TTD Elektronik --}}
                    <div class="mt-4 pt-4 border-t">
                        <label class="text-xs font-medium mb-2 block">Tanda Tangan Ulang <span class="text-red-500">*</span></label>
                        <iframe src="/canvas-signature.html?id=ba_lahan_elektronik_ulang" style="width: 100%; height: 180px; border: none; border-radius: 8px; background: white;"></iframe>
                        <input type="hidden" name="ttd_ba_lahan" id="ttd_ba_lahan_elektronik_ulang_input">
                    </div>
                </div>
            @endif
        </div>
        @endif
        
        {{-- BA Lingkungan --}}
        @if(in_array('ba_lingkungan', $dokumenDitolak))
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <label class="block font-medium mb-3">BA Lingkungan <span class="text-red-500">*</span></label>
            
            @if($baLingkunganOption == 'upload')
                <input type="file" name="dokumen_ba_lingkungan" class="input-field" accept=".pdf,.jpg,.jpeg,.png" required>
                <p class="text-xs text-gray-500 mt-1">Max 5MB (PDF, JPG, PNG)</p>
            @else
                {{-- Opsi Form --}}
                <div class="space-y-3 border rounded-lg p-4 bg-gray-50">
                    <div>
                        <label class="text-xs font-medium">Nomor BA</label>
                        <input type="text" name="ba_lingkungan_form[nomor_ba]" value="{{ $baLingkunganData['nomor_ba'] ?? '' }}" class="input-field text-sm" required>
                    </div>
                    <div>
                        <label class="text-xs font-medium">Nama Pihak Kesatu</label>
                        <input type="text" name="ba_lingkungan_form[nama_pihak_kesatu]" value="{{ $baLingkunganData['nama_pihak_kesatu'] ?? '' }}" class="input-field text-sm" required>
                    </div>
                    <div>
                        <label class="text-xs font-medium">Jabatan Pihak Kesatu</label>
                        <input type="text" name="ba_lingkungan_form[jabatan_pihak_kesatu]" value="{{ $baLingkunganData['jabatan_pihak_kesatu'] ?? '' }}" class="input-field text-sm">
                    </div>
                    <div>
                        <label class="text-xs font-medium">Nama Pihak Kedua (PLN)</label>
                        <input type="text" name="ba_lingkungan_form[nama_pihak_kedua]" value="{{ $baLingkunganData['nama_pihak_kedua'] ?? '' }}" class="input-field text-sm" required>
                    </div>
                    <div>
                        <label class="text-xs font-medium">Luas Tanah</label>
                        <input type="text" name="ba_lingkungan_form[luas_tanah]" value="{{ $baLingkunganData['luas_tanah'] ?? '' }}" class="input-field text-sm" required>
                    </div>
                    <div>
                        <label class="text-xs font-medium">Lokasi</label>
                        <input type="text" name="ba_lingkungan_form[lokasi]" value="{{ $baLingkunganData['lokasi'] ?? '' }}" class="input-field text-sm" required>
                    </div>
                    <div>
                        <label class="text-xs font-medium">Nomor Sertifikat (Opsional)</label>
                        <input type="text" name="ba_lingkungan_form[nomor_sertifikat]" value="{{ $baLingkunganData['nomor_sertifikat'] ?? '' }}" class="input-field text-sm">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="text-xs font-medium">Batas Utara</label>
                            <input type="text" name="ba_lingkungan_form[batas_utara]" value="{{ $baLingkunganData['batas_utara'] ?? '' }}" class="input-field text-sm">
                        </div>
                        <div>
                            <label class="text-xs font-medium">Batas Timur</label>
                            <input type="text" name="ba_lingkungan_form[batas_timur]" value="{{ $baLingkunganData['batas_timur'] ?? '' }}" class="input-field text-sm">
                        </div>
                        <div>
                            <label class="text-xs font-medium">Batas Selatan</label>
                            <input type="text" name="ba_lingkungan_form[batas_selatan]" value="{{ $baLingkunganData['batas_selatan'] ?? '' }}" class="input-field text-sm">
                        </div>
                        <div>
                            <label class="text-xs font-medium">Batas Barat</label>
                            <input type="text" name="ba_lingkungan_form[batas_barat]" value="{{ $baLingkunganData['batas_barat'] ?? '' }}" class="input-field text-sm">
                        </div>
                    </div>
                    
                    {{-- TTD Elektronik --}}
                    <div class="mt-4 pt-4 border-t">
                        <label class="text-xs font-medium mb-2 block">Tanda Tangan Ulang <span class="text-red-500">*</span></label>
                        <iframe src="/canvas-signature.html?id=ba_lingkungan_elektronik_ulang" style="width: 100%; height: 180px; border: none; border-radius: 8px; background: white;"></iframe>
                        <input type="hidden" name="ttd_ba_lingkungan" id="ttd_ba_lingkungan_elektronik_ulang_input">
                    </div>
                </div>
            @endif
        </div>
        @endif
        
        {{-- Written Agreement --}}
        @if(in_array('return_agrimen', $dokumenDitolak))
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <label class="block font-medium mb-3">Written Agreement <span class="text-red-500">*</span></label>
            <input type="file" name="dokumen_return_agrimen" class="input-field" accept=".pdf,.jpg,.jpeg,.png" required>
        </div>
        @endif
        
        {{-- IMB --}}
        @if(in_array('imb', $dokumenDitolak))
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <label class="block font-medium mb-3">IMB <span class="text-red-500">*</span></label>
            <input type="file" name="dokumen_imb" class="input-field" accept=".pdf,.jpg,.jpeg,.png" required>
        </div>
        @endif
        
        {{-- Sertifikat Lahan --}}
        @if(in_array('sertifikat_lahan', $dokumenDitolak))
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            <label class="block font-medium mb-3">Sertifikat Lahan <span class="text-red-500">*</span></label>
            <input type="file" name="dokumen_sertifikat_lahan" class="input-field" accept=".pdf,.jpg,.jpeg,.png" required>
        </div>
        @endif
        
        <button type="submit" class="btn btn-primary">Upload & Kirim Ulang</button>
    </form>
    
</div>

<script>
window.addEventListener('message', function(event) {
    if (event.data.type === 'signature-saved' || event.data.type === 'signature-auto-save') {
        console.log('📨 Upload ulang received:', event.data.inputId);
        
        var input = document.getElementById(event.data.inputId);
        if (input) {
            input.value = event.data.dataUrl;
            input.dispatchEvent(new Event('input', { bubbles: true }));
            console.log('✅ Upload ulang input updated:', event.data.inputId);
        } else {
            console.error('❌ Upload ulang input not found:', event.data.inputId);
        }
    }
});
</script>
@endsection
