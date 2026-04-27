<div>
    {{-- Header dengan Back Button --}}
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('user.dashboard') }}" class="text-gray-600">
            <span class="text-2xl">←</span>
        </a>
        <h2 class="text-xl font-bold text-gray-800">Form Permohonan</h2>
    </div>
    
    {{-- Step Progress --}}
    <div class="card py-3">
        <div class="step-container">
            {{-- Step 1 --}}
            <div class="step-item">
                <div class="step-circle {{ $currentStep >= 1 ? ($currentStep > 1 ? 'completed' : 'active') : '' }}">
                    @if($currentStep > 1) ✓ @else 1 @endif
                </div>
                <span class="step-label {{ $currentStep >= 1 ? 'active' : '' }}">Data Pemohon</span>
            </div>
            <div class="step-line {{ $currentStep >= 2 ? 'completed' : '' }}"></div>
            
            {{-- Step 2 --}}
            <div class="step-item">
                <div class="step-circle {{ $currentStep >= 2 ? ($currentStep > 2 ? 'completed' : 'active') : '' }}">
                    @if($currentStep > 2) ✓ @else 2 @endif
                </div>
                <span class="step-label {{ $currentStep >= 2 ? 'active' : '' }}">Dokumen</span>
            </div>
            
            @if($needStep3)
            <div class="step-line {{ $currentStep >= 3 ? 'completed' : '' }}"></div>
            {{-- Step 3 --}}
            <div class="step-item">
                <div class="step-circle {{ $currentStep >= 3 ? 'active' : '' }}">3</div>
                <span class="step-label {{ $currentStep >= 3 ? 'active' : '' }}">Tanda Tangan</span>
            </div>
            @endif
        </div>
    </div>
    
    {{-- STEP 1: Data Diri --}}
    @if($currentStep == 1)
    <div class="space-y-4">
        {{-- IDPEL - Opsional untuk Tambah Daya & Peningkatan Keandalan --}}
        @if($showIdpelField)
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <label class="block font-medium mb-2">IDPEL <span class="text-gray-400 text-xs font-normal">(Opsional)</span></label>
            <input type="text" wire:model="idpel" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-pln-primary focus:ring-1 focus:ring-pln-primary" placeholder="Masukkan IDPEL (opsional)">
            @error('idpel') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        @endif
        
        {{-- Untuk Pasang Baru, IDPEL tidak ditampilkan (dibuat otomatis) --}}
        @if($jenis_permohonan == 'pasang_baru')
        <div class="bg-blue-50 rounded-xl p-4 text-sm text-blue-800">
            ℹ️ IDPEL akan dibuat otomatis oleh sistem.
        </div>
        @endif
        
        {{-- Nomor KTP --}}
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <label class="block font-medium mb-2">Nomor KTP <span class="text-red-500">*</span></label>
            <input type="text" wire:model="no_ktp" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-pln-primary focus:ring-1 focus:ring-pln-primary" placeholder="16 digit" maxlength="16">
            @error('no_ktp') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        
        {{-- Nama Pelanggan --}}
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <label class="block font-medium mb-2">Nama Pelanggan <span class="text-red-500">*</span></label>
            <input type="text" wire:model="nama_pelanggan" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-pln-primary focus:ring-1 focus:ring-pln-primary" placeholder="Nama lengkap">
            @error('nama_pelanggan') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        
        {{-- Nomor Telepon --}}
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <label class="block font-medium mb-2">Nomor Telepon <span class="text-red-500">*</span></label>
            <input type="tel" wire:model="no_telepon" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-pln-primary focus:ring-1 focus:ring-pln-primary" placeholder="081234567890">
            @error('no_telepon') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        
       {{-- ULP --}}
<div class="bg-white rounded-xl p-4 shadow-sm">
    <label class="block font-medium mb-2">ULP <span class="text-red-500">*</span></label>
    <select wire:model="ulp" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-pln-primary focus:ring-1 focus:ring-pln-primary">
        <option value="">Pilih ULP</option>
        <option value="ULP Bandung Selatan">ULP Bandung Selatan</option>
        <option value="ULP Bandung Barat">ULP Bandung Barat</option>
        <option value="ULP Bandung Utara">ULP Bandung Utara</option>
        <option value="ULP Bandung Timur">ULP Bandung Timur</option>
        <option value="ULP Cijawura">ULP Cijawura</option>
        <option value="ULP Ujungberung">ULP Ujungberung</option>
        <option value="ULP Kopo">ULP Kopo</option>
        <option value="ULP Prima Priangan">ULP Prima Priangan</option>
    </select>
    @error('ulp') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
</div>
        
        {{-- Alamat Gardu --}}
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <label class="block font-medium mb-2">Alamat Gardu <span class="text-red-500">*</span></label>
            <textarea wire:model="alamat_gardu" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-pln-primary focus:ring-1 focus:ring-pln-primary" placeholder="Alamat lengkap gardu"></textarea>
            @error('alamat_gardu') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        
        {{-- Nama Gardu --}}
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <label class="block font-medium mb-2">Nama Gardu <span class="text-red-500">*</span></label>
            <input type="text" wire:model="nama_gardu" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-pln-primary focus:ring-1 focus:ring-pln-primary" placeholder="Nama gardu">
            @error('nama_gardu') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
    </div>
    @endif
    
    {{-- STEP 2: Upload Dokumen --}}
    @if($currentStep == 2)
    <div class="space-y-3">
        {{-- BA Lahan --}}
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <label class="block font-medium mb-3">BA Lahan <span class="text-red-500">*</span></label>
            
            {{-- Pilih Opsi --}}
           <div class="mb-4">
    <label class="block text-xs font-medium mb-1">Pilih Metode</label>
    <select wire:model.live="ba_lahan_option" class="input-field text-sm">
        <option value="upload">📤 Upload File (TTD Manual)</option>
        <option value="form">📝 Isi Form (TTD Elektronik)</option>
    </select>
</div>
            
            {{-- Opsi Upload --}}
            @if($ba_lahan_option == 'upload')
            <input type="file" wire:model="dokumen_ba_lahan" class="input-field text-sm" accept=".pdf,.jpg,.jpeg,.png">
            <p class="text-xs text-gray-500 mt-1">Max 5MB (PDF, JPG, PNG)</p>
            @error('dokumen_ba_lahan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            @if($dokumen_ba_lahan)
                <p class="text-green-600 text-xs mt-2">✓ {{ $dokumen_ba_lahan->getClientOriginalName() }}</p>
            @endif
            @endif
            
            {{-- Opsi Form --}}
            @if($ba_lahan_option == 'form')
            <div class="space-y-3 border rounded-lg p-4 bg-gray-50">
                <div>
                    <label class="text-xs font-medium">Unit PLN</label>
                    <input type="text" wire:model="ba_lahan_form.unit_pln" class="input-field text-sm" placeholder="Contoh: ULP Jakarta Selatan">
                </div>
                <div>
                    <label class="text-xs font-medium">Nama Pekerjaan</label>
                    <input type="text" wire:model="ba_lahan_form.nama_pekerjaan" class="input-field text-sm" placeholder="Nama pekerjaan">
                </div>
                <div>
                    <label class="text-xs font-medium">Desa/Kelurahan</label>
                    <input type="text" wire:model="ba_lahan_form.desa_kelurahan" class="input-field text-sm">
                </div>
                <div>
                    <label class="text-xs font-medium">Kecamatan</label>
                    <input type="text" wire:model="ba_lahan_form.kecamatan" class="input-field text-sm">
                </div>
                <div>
                    <label class="text-xs font-medium">Kabupaten/Kota</label>
                    <input type="text" wire:model="ba_lahan_form.kabupaten_kota" class="input-field text-sm">
                </div>
                <div>
                    <label class="text-xs font-medium">Nama Pemilik Lahan</label>
                    <input type="text" wire:model="ba_lahan_form.nama_pemilik" class="input-field text-sm">
                </div>
                <div>
                    <label class="text-xs font-medium">No Telepon Pemilik</label>
                    <input type="tel" wire:model="ba_lahan_form.no_telepon_pemilik" class="input-field text-sm">
                </div>
                <div>
                    <label class="text-xs font-medium">Alamat Pemilik</label>
                    <textarea wire:model="ba_lahan_form.alamat_pemilik" rows="2" class="input-field text-sm"></textarea>
                </div>
                <div>
                    <label class="text-xs font-medium">Status</label>
                    <select wire:model="ba_lahan_form.status_pemilik" class="input-field text-sm">
                        <option value="">Pilih</option>
                        <option value="pemilik_lahan">Pemilik Lahan</option>
                        <option value="masyarakat_terdampak">Masyarakat Terdampak</option>
                        <option value="perwakilan">Perwakilan Pemilik Lahan</option>
                        <option value="pemerintah_desa">Pemerintah Desa/Kelurahan</option>
                    </select>
                </div>
                
                {{-- Pernyataan --}}
                <div class="space-y-2">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" wire:model="ba_lahan_form.pernyataan_1" class="accent-pln-primary">
                        <span class="text-xs">Berdampak terhadap 200 orang atau lebih</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" wire:model="ba_lahan_form.pernyataan_2" class="accent-pln-primary">
                        <span class="text-xs">Berdampak terhadap berkurangnya pendapatan lebih dari 10%</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" wire:model="ba_lahan_form.pernyataan_3" class="accent-pln-primary">
                        <span class="text-xs">Berlokasi di lahan/wilayah masyarakat adat</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" wire:model="ba_lahan_form.pernyataan_4" class="accent-pln-primary">
                        <span class="text-xs">Berdampak negatif terhadap masyarakat adat</span>
                    </label>
                </div>
                
                <div class="text-xs text-gray-500 italic">
                    ℹ️ Tanda tangan elektronik akan diminta di Step 3.
                </div>
            </div>
            @endif
        </div>
        
        {{-- BA Lingkungan --}}
        <div class="bg-white rounded-xl p-4 shadow-sm mt-4">
            <label class="block font-medium mb-3">BA Lingkungan <span class="text-red-500">*</span></label>
            
            {{-- Pilih Opsi --}}
         <div class="mb-4">
    <label class="block text-xs font-medium mb-1">Pilih Metode</label>
    <select wire:model.live="ba_lingkungan_option" class="input-field text-sm">
        <option value="upload">📤 Upload File (TTD Manual)</option>
        <option value="form">📝 Isi Form (TTD Elektronik)</option>
    </select>
</div>
            
            {{-- Opsi Upload --}}
            @if($ba_lingkungan_option == 'upload')
            <input type="file" wire:model="dokumen_ba_lingkungan" class="input-field text-sm" accept=".pdf,.jpg,.jpeg,.png">
            <p class="text-xs text-gray-500 mt-1">Max 5MB (PDF, JPG, PNG)</p>
            @error('dokumen_ba_lingkungan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            @if($dokumen_ba_lingkungan)
                <p class="text-green-600 text-xs mt-2">✓ {{ $dokumen_ba_lingkungan->getClientOriginalName() }}</p>
            @endif
            @endif
            
            {{-- Opsi Form --}}
            @if($ba_lingkungan_option == 'form')
            <div class="space-y-3 border rounded-lg p-4 bg-gray-50">
                <div>
                    <label class="text-xs font-medium">Nomor BA</label>
                    <input type="text" wire:model="ba_lingkungan_form.nomor_ba" class="input-field text-sm" placeholder="Contoh: 001/BA/2024">
                </div>
                <div>
                    <label class="text-xs font-medium">Nama Pihak Kesatu (Pemilik Lahan)</label>
                    <input type="text" wire:model="ba_lingkungan_form.nama_pihak_kesatu" class="input-field text-sm">
                </div>
                <div>
                    <label class="text-xs font-medium">Jabatan Pihak Kesatu</label>
                    <input type="text" wire:model="ba_lingkungan_form.jabatan_pihak_kesatu" class="input-field text-sm" placeholder="Contoh: Direktur">
                </div>
                <div>
                    <label class="text-xs font-medium">Nama Pihak Kedua (PLN)</label>
                    <input type="text" wire:model="ba_lingkungan_form.nama_pihak_kedua" class="input-field text-sm">
                </div>
                <div>
                    <label class="text-xs font-medium">Luas Tanah</label>
                    <input type="text" wire:model="ba_lingkungan_form.luas_tanah" class="input-field text-sm" placeholder="Contoh: 5 x 9 m">
                </div>
                <div>
                    <label class="text-xs font-medium">Lokasi</label>
                    <input type="text" wire:model="ba_lingkungan_form.lokasi" class="input-field text-sm">
                </div>
                <div>
                    <label class="text-xs font-medium">Nomor Sertifikat (Opsional)</label>
                    <input type="text" wire:model="ba_lingkungan_form.nomor_sertifikat" class="input-field text-sm">
                </div>
                
                {{-- Batas-batas --}}
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="text-xs font-medium">Batas Utara</label>
                        <input type="text" wire:model="ba_lingkungan_form.batas_utara" class="input-field text-sm">
                    </div>
                    <div>
                        <label class="text-xs font-medium">Batas Timur</label>
                        <input type="text" wire:model="ba_lingkungan_form.batas_timur" class="input-field text-sm">
                    </div>
                    <div>
                        <label class="text-xs font-medium">Batas Selatan</label>
                        <input type="text" wire:model="ba_lingkungan_form.batas_selatan" class="input-field text-sm">
                    </div>
                    <div>
                        <label class="text-xs font-medium">Batas Barat</label>
                        <input type="text" wire:model="ba_lingkungan_form.batas_barat" class="input-field text-sm">
                    </div>
                </div>
                
                <div class="text-xs text-gray-500 italic">
                    ℹ️ Tanda tangan elektronik akan diminta di Step 3.
                </div>
            </div>
            @endif
        </div>
        
        {{-- Written Agreement --}}
        <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-l-orange-400">
            <div class="flex items-center justify-between mb-3">
                <label class="font-medium text-gray-800">Written Agreement <span class="text-red-500">*</span></label>
                <span class="text-xs text-orange-600 flex items-center gap-1">⚠️ Wajib diisi oleh Pemilik Lahan</span>
            </div>
            <input type="file" wire:model="dokumen_return_agrimen" class="input-field text-sm" accept=".pdf,.jpg,.jpeg,.png">
            @error('dokumen_return_agrimen') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            @if($dokumen_return_agrimen)
                <p class="text-green-600 text-xs mt-2">✓ {{ $dokumen_return_agrimen->getClientOriginalName() }}</p>
            @endif
        </div>
        
        {{-- IMB (Opsional) --}}
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <div class="flex items-center gap-3 mb-3">
                <span class="text-2xl">🖼️</span>
                <div class="flex-1">
                    <label class="font-medium text-gray-800">IMB <span class="text-gray-400 text-xs font-normal">(Opsional)</span></label>
                </div>
            </div>
            <input type="file" wire:model="dokumen_imb" class="input-field text-sm" accept=".pdf,.jpg,.jpeg,.png">
            @if($dokumen_imb)
                <div class="file-preview">
                    <span class="text-sm text-gray-700">{{ $dokumen_imb->getClientOriginalName() }}</span>
                    <span class="text-green-600">✓</span>
                </div>
            @endif
        </div>
        
        {{-- Sertifikat Lahan (Opsional) --}}
        <div class="bg-white rounded-xl p-4 shadow-sm">
            <div class="flex items-center gap-3 mb-3">
                <span class="text-2xl">📜</span>
                <div class="flex-1">
                    <label class="font-medium text-gray-800">Sertifikat Lahan <span class="text-gray-400 text-xs font-normal">(Opsional)</span></label>
                </div>
            </div>
            <input type="file" wire:model="dokumen_sertifikat_lahan" class="input-field text-sm" accept=".pdf,.jpg,.jpeg,.png">
            @if($dokumen_sertifikat_lahan)
                <div class="file-preview">
                    <span class="text-sm text-gray-700">{{ $dokumen_sertifikat_lahan->getClientOriginalName() }}</span>
                    <span class="text-green-600">✓</span>
                </div>
            @endif
        </div>
    </div>
    @endif
    
    {{-- STEP 3: Tanda Tangan Elektronik (Hanya untuk Form) --}}
    @if($currentStep == 3)
    <div class="space-y-4">
        <div class="bg-blue-50 rounded-xl p-4 text-sm text-blue-800">
            ℹ️ Tanda tangan elektronik diperlukan untuk dokumen yang diisi melalui form.
        </div>
        
        @if($ba_lahan_option == 'form')
        <div class="card">
            <label class="font-medium text-gray-800 mb-3 block">Tanda Tangan BA Lahan (Elektronik) <span class="text-red-500">*</span></label>
            <iframe src="/canvas-signature.html?id=ba_lahan_elektronik" 
                    style="width: 100%; height: 220px; border: none; border-radius: 12px; background: white;">
            </iframe>
            <input type="hidden" id="ttd_ba_lahan_elektronik_input" wire:model="ttd_ba_lahan_elektronik">
            @error('ttd_ba_lahan_elektronik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        @else
        <div class="card bg-green-50">
            <p class="text-green-800">✅ BA Lahan diupload, tanda tangan manual sudah ada di file.</p>
        </div>
        @endif
        
        @if($ba_lingkungan_option == 'form')
        <div class="card">
            <label class="font-medium text-gray-800 mb-3 block">Tanda Tangan BA Lingkungan (Elektronik) <span class="text-red-500">*</span></label>
            <iframe src="/canvas-signature.html?id=ba_lingkungan_elektronik" 
                    style="width: 100%; height: 220px; border: none; border-radius: 12px; background: white;">
            </iframe>
            <input type="hidden" id="ttd_ba_lingkungan_elektronik_input" wire:model="ttd_ba_lingkungan_elektronik">
            @error('ttd_ba_lingkungan_elektronik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        @else
        <div class="card bg-green-50">
            <p class="text-green-800">✅ BA Lingkungan diupload, tanda tangan manual sudah ada di file.</p>
        </div>
        @endif
    </div>
    @endif
    
    {{-- Navigation Buttons --}}
    <div class="mt-6 pt-4 border-t border-gray-200">
        @if($currentStep == 1)
        <button type="button" wire:click="nextStep" class="btn btn-primary">
            Selanjutnya
        </button>
        @endif
        
@if($currentStep == 2)
<div class="flex gap-3">
    <button type="button" wire:click="previousStep" class="btn btn-outline flex-1">
        ← Kembali
    </button>
    
    @if($needStep3)
    <div style="background: yellow; padding: 10px; margin: 10px 0;">
    🔍 DEBUG INFO:<br>
    currentStep: {{ $currentStep }}<br>
    needStep3: {{ $needStep3 ? 'TRUE' : 'FALSE' }}<br>
    ba_lahan_option: {{ $ba_lahan_option }}<br>
    ba_lingkungan_option: {{ $ba_lingkungan_option }}<br>
</div>
    <button type="button" wire:click.prevent="nextStep" class="btn btn-primary flex-1">
        Selanjutnya
    </button>
    @else
    <button type="button" wire:click.prevent="submit" class="btn btn-success flex-1">
        ✅ Submit Permohonan
    </button>
    @endif
</div>
@endif

@if($currentStep == 3)
<div class="flex gap-3">
    <button type="button" wire:click="previousStep" class="btn btn-outline flex-1">
        ← Kembali
    </button>
    <button type="button" wire:click.prevent="submit" class="btn btn-success flex-1">
        ✅ Kirim Permohonan
    </button>
</div>
@endif
    </div>
    
    {{-- Spacer --}}
    <div class="h-20"></div>
    
    {{-- Script --}}
 <script>
window.addEventListener('message', function(event) {
    if (event.data.type === 'signature-saved' || event.data.type === 'signature-auto-save') {
        console.log('📨 Message received:', event.data);
        
        var input = document.getElementById(event.data.inputId);
        if (input) {
            input.value = event.data.dataUrl;
            input.dispatchEvent(new Event('input', { bubbles: true }));
            input.dispatchEvent(new Event('change', { bubbles: true }));
            
            console.log('✅ Input updated. New length:', input.value.length);
        } else {
            console.error('❌ Input not found:', event.data.inputId);
        }
    }
});
</script>
</div>