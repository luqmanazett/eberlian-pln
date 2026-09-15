<?php

namespace App\Livewire;

use App\Models\Permohonan;
use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Notifikasi;
use Livewire\Attributes\Url;

class FormPermohonan extends Component
{
    use WithFileUploads;
    
    #[Url]
    public $currentStep = 1;
    public $totalSteps = 3;
    
    // Form Data - Step 1
    public $jenis_permohonan;
    public $idpel;
    public $no_ktp;
    public $nama_pelanggan;
    public $ulp;
    public $alamat_gardu;
    public $nama_gardu;
    public $no_telepon;
    
    // Form Data - Step 2
    public $dokumen_ba_lahan;
    public $dokumen_ba_lingkungan;
    public $dokumen_return_agrimen;
    public $dokumen_imb;
    public $dokumen_sertifikat_lahan;
    
    // Opsi BA Lahan
    public $ba_lahan_option = 'upload';
    public $gambar_situasi_lahan;
    public $ba_lahan_form = [
        'unit_pln' => '',
        'nama_pekerjaan' => '',
        'desa_kelurahan' => '',
        'kecamatan' => '',
        'kabupaten_kota' => '',
        'nama_pemilik' => '',
        'no_telepon_pemilik' => '',
        'alamat_pemilik' => '',
        'status_pemilik' => '',
        'pernyataan_1' => false,
        'pernyataan_2' => false,
        'pernyataan_3' => false,
        'pernyataan_4' => false,
    ];
    
    // Opsi BA Lingkungan
    public $ba_lingkungan_option = 'upload';
    public $jenis_gardu = '';
    public $luas_tanah_gardu = '';
    public $ba_lingkungan_form = [
        'nomor_ba' => '',
        'nama_pihak_kesatu' => '',
        'jabatan_pihak_kesatu' => '',
        'nama_pihak_kedua' => '',
        'luas_tanah' => '',
        'lokasi' => '',
        'nomor_sertifikat' => '',
        'batas_utara' => '',
        'batas_timur' => '',
        'batas_selatan' => '',
        'batas_barat' => '',
        'gambar_situasi_lahan_path' => null,
    ];
    
    // Tanda tangan elektronik (untuk opsi form)
    public $ttd_ba_lahan_elektronik;
    public $ttd_ba_lahan_elektronik_kedua;
    public $ttd_ba_lingkungan_elektronik;
    public $ttd_ba_lingkungan_elektronik_kedua;
    
    // UI State
    public $showIdpelField = false;
    public $needStep3 = false; // Hanya perlu Step 3 jika ada yang pakai form
    public function mount($jenis = 'pasang_baru')
    {
        $this->jenis_permohonan = $jenis;
        $this->showIdpelField = in_array($jenis, ['tambah_daya', 'peningkatan_keandalan']);
        $this->checkNeedStep3(); 
    }
    
    public function updatedUlp($value)
    {
        $this->ba_lahan_form['unit_pln'] = $value;
    }
    
  public function updatedBaLahanOption($value)
{
    if ($value == 'form') {
        $this->dokumen_ba_lahan = null;
    } else {
        $this->ba_lahan_form = [
            'unit_pln' => '',
            'nama_pekerjaan' => '',
            'desa_kelurahan' => '',
            'kecamatan' => '',
            'kabupaten_kota' => '',
            'nama_pemilik' => '',
            'no_telepon_pemilik' => '',
            'alamat_pemilik' => '',
            'status_pemilik' => '',
            'pernyataan_1' => false,
            'pernyataan_2' => false,
            'pernyataan_3' => false,
            'pernyataan_4' => false,
        ];
    }
    $this->checkNeedStep3();
}

public function updatedBaLingkunganOption($value)
{
    if ($value == 'form') {
        $this->dokumen_ba_lingkungan = null;
    } else {
        $this->ba_lingkungan_form = [
            'nomor_ba' => '',
            'nama_pihak_kesatu' => '',
            'jabatan_pihak_kesatu' => '',
            'nama_pihak_kedua' => '',
            'luas_tanah' => '',
            'lokasi' => '',
            'nomor_sertifikat' => '',
            'batas_utara' => '',
            'batas_timur' => '',
            'batas_selatan' => '',
            'batas_barat' => '',
            'gambar_situasi_lahan_path' => null,
        ];
        $this->gambar_situasi_lahan = null;
    }
    $this->checkNeedStep3();
}

public function updateLuasTanah()
{
    $sizes = [
        'tembok_7r2' => '5 x 5 m',
        'tembok_st17' => '5 x 7 m',
        'tembok_st16' => '5 x 9 m',
        'garpor' => '2 x 5 m',
        'portal' => '2 x 2 m',
        'cantol' => '2 x 1 m',
    ];

    if (array_key_exists($this->jenis_gardu, $sizes)) {
        $this->luas_tanah_gardu = $sizes[$this->jenis_gardu];
    } else {
        $this->luas_tanah_gardu = '';
    }
}
    
    private function checkNeedStep3()
{
    $this->needStep3 = ($this->ba_lahan_option == 'form' || $this->ba_lingkungan_option == 'form');
    $this->totalSteps = $this->needStep3 ? 3 : 2;
    
    // Debug
    Log::info('checkNeedStep3: ' . ($this->needStep3 ? 'true' : 'false'));
}
   public function nextStep()
   {
       if ($this->currentStep == 1) {
           $this->validateStep1();
           $this->currentStep = 2;
       } elseif ($this->currentStep == 2) {
           $this->validateStep2();
           // Jika perlu Step 3, langsung pindah
           if ($this->needStep3) {
               $this->currentStep = 3;
           } else {
               // Jika tidak perlu, submit
               $this->submit();
           }
       }
   }
    
    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }
    
    private function validateStep1()
    {
        $rules = [
            'no_ktp' => 'required|digits:16',
            'nama_pelanggan' => 'required|string|max:255',
            'no_telepon' => 'required|digits_between:10,15',
            'ulp' => 'required|string',
            'alamat_gardu' => 'required|string',
            'nama_gardu' => 'required|string',
        ];
        
        if ($this->jenis_permohonan == 'tambah_daya') {
            $rules['idpel'] = 'required|string|max:50'; // IDPEL Wajib
        } elseif ($this->jenis_permohonan == 'peningkatan_keandalan') {
            $rules['idpel'] = 'nullable|string|max:50'; // Peningkatan Keandalan
        }
        
        try {
            $this->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('validation-failed');
            throw $e;
        }
    }
    
    private function validateStep2()
    {
        $rules = [];
        $messages = [
            'dokumen_*.max' => 'Ukuran file maksimal 5MB.',
            'dokumen_*.mimes' => 'Format file harus PDF, JPG, atau PNG.',
            'dokumen_return_agrimen.required' => 'Written Agreement wajib diupload.',
        ];
        
        // Validasi BA Lahan
        if ($this->ba_lahan_option == 'upload') {
            $rules['dokumen_ba_lahan'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:5120';
        } else {
            $rules['ba_lahan_form.unit_pln'] = 'required';
            $rules['ba_lahan_form.nama_pekerjaan'] = 'required';
            $rules['ba_lahan_form.desa_kelurahan'] = 'required';
            $rules['ba_lahan_form.kecamatan'] = 'required';
            $rules['ba_lahan_form.kabupaten_kota'] = 'required';
            $rules['ba_lahan_form.nama_pemilik'] = 'required';
            $rules['ba_lahan_form.no_telepon_pemilik'] = 'required';
            $rules['ba_lahan_form.alamat_pemilik'] = 'required';
            $rules['ba_lahan_form.status_pemilik'] = 'required';
        }
        
        // Validasi BA Lingkungan
        if ($this->ba_lingkungan_option == 'upload') {
            $rules['dokumen_ba_lingkungan'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:5120';
        } else {
            $this->ba_lingkungan_form['luas_tanah'] = $this->luas_tanah_gardu;
            $this->ba_lingkungan_form['jenis_gardu'] = $this->jenis_gardu;
            
            $rules['ba_lingkungan_form.nomor_ba'] = 'required';
            $rules['ba_lingkungan_form.nama_pihak_kesatu'] = 'required';
            $rules['ba_lingkungan_form.jabatan_pihak_kesatu'] = 'required';
            $rules['ba_lingkungan_form.nama_pihak_kedua'] = 'required';
            $rules['ba_lingkungan_form.luas_tanah'] = 'required';
            $rules['ba_lingkungan_form.lokasi'] = 'required';
            $rules['ba_lingkungan_form.nomor_sertifikat'] = 'required';
            $rules['ba_lingkungan_form.batas_utara'] = 'required';
            $rules['ba_lingkungan_form.batas_timur'] = 'required';
            $rules['ba_lingkungan_form.batas_selatan'] = 'required';
            $rules['ba_lingkungan_form.batas_barat'] = 'required';
            $rules['gambar_situasi_lahan'] = 'required|image|max:5120';
        }
        
        // Validasi dokumen lainnya
        $rules['dokumen_return_agrimen'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:5120';
        $rules['dokumen_imb'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120';
        $rules['dokumen_sertifikat_lahan'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120';
        
        try {
            $this->validate($rules, $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('validation-failed');
            throw $e;
        }
    }
    
    
    
    private function generateIdRegister()
    {
        $prefix = '';
        if ($this->jenis_permohonan == 'pasang_baru') {
            $prefix = 'PB';
        } elseif ($this->jenis_permohonan == 'tambah_daya') {
            $prefix = 'TD';
        } else {
            $prefix = 'PK';
        }
        
        $date = date('Ymd');
        
        $countToday = Permohonan::where('jenis_permohonan', $this->jenis_permohonan)
            ->whereDate('created_at', today())
            ->count();
        
        $sequence = str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);
        
        return $prefix . $date . $sequence;
    }

   public function submit()
{
    // DEBUG: Log TTD
    // Validate Step 3 signatures
    $rules = [];
    $messages = [];
    
    if ($this->ba_lahan_option == 'form') {
        $rules['ttd_ba_lahan_elektronik'] = 'required|string|min:100';
        $rules['ttd_ba_lahan_elektronik_kedua'] = 'required|string|min:100';
        $messages['ttd_ba_lahan_elektronik.required'] = 'Tanda tangan Pihak Kesatu BA Lingkungan wajib diisi.';
        $messages['ttd_ba_lahan_elektronik_kedua.required'] = 'Tanda tangan Pihak Kedua BA Lingkungan wajib diisi.';
        $messages['ttd_ba_lahan_elektronik.min'] = 'Tanda tangan Pihak Kesatu BA Lingkungan wajib disimpan.';
        $messages['ttd_ba_lahan_elektronik_kedua.min'] = 'Tanda tangan Pihak Kedua BA Lingkungan wajib disimpan.';
    }
    
    if ($this->ba_lingkungan_option == 'form') {
        $rules['ttd_ba_lingkungan_elektronik'] = 'required|string|min:100';
        $rules['ttd_ba_lingkungan_elektronik_kedua'] = 'required|string|min:100';
        $messages['ttd_ba_lingkungan_elektronik.required'] = 'Tanda tangan Pihak Kesatu BA Lahan wajib diisi.';
        $messages['ttd_ba_lingkungan_elektronik_kedua.required'] = 'Tanda tangan Pihak Kedua BA Lahan wajib diisi.';
        $messages['ttd_ba_lingkungan_elektronik.min'] = 'Tanda tangan Pihak Kesatu BA Lahan wajib disimpan.';
        $messages['ttd_ba_lingkungan_elektronik_kedua.min'] = 'Tanda tangan Pihak Kedua BA Lahan wajib disimpan.';
    }
    
    if (!empty($rules)) {
        try {
            $this->validate($rules, $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('validation-failed');
            throw $e;
        }
    }

    Log::info('=== SUBMIT DEBUG ===');
    Log::info('ba_lahan_option: ' . $this->ba_lahan_option);
    Log::info('ba_lingkungan_option: ' . $this->ba_lingkungan_option);
    Log::info('ttd_ba_lahan_elektronik length: ' . strlen($this->ttd_ba_lahan_elektronik ?? '0'));
    Log::info('ttd_ba_lingkungan_elektronik length: ' . strlen($this->ttd_ba_lingkungan_elektronik ?? '0'));
    
    try {
        DB::beginTransaction();
        
        $paths = [];
        $dokumenFields = ['return_agrimen', 'imb', 'sertifikat_lahan'];
        
        foreach ($dokumenFields as $field) {
            $propertyName = "dokumen_{$field}";
            if ($this->$propertyName) {
                $paths[$field] = $this->$propertyName->store(
                    "permohonan/" . Auth::id() . "/original",
                    'public'
                );
            }
        }
        
        // Handle BA Lahan
        $baLahanPath = null;
        $baLahanData = null;
        if ($this->ba_lahan_option == 'upload' && $this->dokumen_ba_lahan) {
            $baLahanPath = $this->dokumen_ba_lahan->store(
                "permohonan/" . Auth::id() . "/original",
                'public'
            );
        } elseif ($this->ba_lahan_option == 'form') {
            $baLahanData = json_encode($this->ba_lahan_form);
        }
        
        // Handle BA Lingkungan
        $baLingkunganPath = null;
        $baLingkunganData = null;
        if ($this->ba_lingkungan_option == 'upload' && $this->dokumen_ba_lingkungan) {
            $baLingkunganPath = $this->dokumen_ba_lingkungan->store(
                "permohonan/" . Auth::id() . "/original",
                'public'
            );
        } elseif ($this->ba_lingkungan_option == 'form') {
            if ($this->gambar_situasi_lahan) {
                $this->ba_lingkungan_form['gambar_situasi_lahan_path'] = $this->gambar_situasi_lahan->store(
                    "permohonan/" . Auth::id() . "/gambar_situasi",
                    'public'
                );
            }
            $baLingkunganData = json_encode($this->ba_lingkungan_form);
        }
        
        // Final IDPEL
        $finalIdpel = $this->jenis_permohonan == 'pasang_baru' ? null : $this->idpel;
        
        // Generate ID Register
        $finalIdRegister = $this->generateIdRegister();
        
        // TTD - Placeholder
        $placeholder = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';
        $finalTtdBaLahan = $this->ttd_ba_lahan_elektronik ?: $placeholder;
        $finalTtdBaLahanKedua = $this->ttd_ba_lahan_elektronik_kedua ?: $placeholder;
        $finalTtdBaLingkungan = $this->ttd_ba_lingkungan_elektronik ?: $placeholder;
        $finalTtdBaLingkunganKedua = $this->ttd_ba_lingkungan_elektronik_kedua ?: $placeholder;
        
        $permohonan = Permohonan::create([
            'user_id' => Auth::id(),
            'jenis_permohonan' => $this->jenis_permohonan,
            'id_register' => $finalIdRegister,
            'idpel' => $finalIdpel,
            'no_ktp' => $this->no_ktp,
            'nama_pelanggan' => $this->nama_pelanggan,
            'ulp' => $this->ulp,
            'alamat_gardu' => $this->alamat_gardu,
            'nama_gardu' => $this->nama_gardu,
            'no_telepon' => $this->no_telepon,
            'ba_lahan_type' => $this->ba_lahan_option,
            'ba_lahan_data' => $baLahanData,
            'dokumen_ba_lahan' => $baLahanPath,
            'ba_lingkungan_type' => $this->ba_lingkungan_option,
            'ba_lingkungan_data' => $baLingkunganData,
            'dokumen_ba_lingkungan' => $baLingkunganPath,
            'dokumen_return_agrimen' => $paths['return_agrimen'] ?? null,
            'dokumen_imb' => $paths['imb'] ?? null,
            'dokumen_sertifikat_lahan' => $paths['sertifikat_lahan'] ?? null,
            'ttd_ba_lahan' => $finalTtdBaLahan,
            'ttd_ba_lahan_kedua' => $finalTtdBaLahanKedua,
            'ttd_ba_lingkungan' => $finalTtdBaLingkungan,
            'ttd_ba_lingkungan_kedua' => $finalTtdBaLingkunganKedua,
            'status' => 'pending',
            'tanggal_upload' => now(),
        ]);
        
        ActivityLog::create([
            'user_id' => Auth::id(),
            'role' => 'user',
            'action' => 'submit_permohonan',
            'description' => "User mengajukan permohonan {$this->jenis_permohonan}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
        
        // Notifikasi ke Admin (Permohonan Baru)
$admins = \App\Models\User::where('role', 'admin')->get();
foreach ($admins as $admin) {
    \App\Models\Notifikasi::create([
        'user_id' => $admin->id,
        'permohonan_id' => $permohonan->id,
        'jenis_notifikasi' => 'info',
        'pesan' => "📋 Permohonan Baru",
        'alasan' => "{$this->nama_pelanggan} mengajukan permohonan " . ucwords(str_replace('_', ' ', $this->jenis_permohonan)),
    ]);
}
        DB::commit();
        $this->reset();
        
        return redirect()->route('user.permohonan.success', $permohonan->id)
            ->with('success', 'Permohonan berhasil diajukan!');
            
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Submit gagal: ' . $e->getMessage());
        session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        return null;
    }
}
    
    public function render()
    {
        return view('livewire.form-permohonan');
    }
}