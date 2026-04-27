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

class FormPermohonan extends Component
{
    use WithFileUploads;
    
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
    ];
    
    // Tanda tangan elektronik (untuk opsi form)
    public $ttd_ba_lahan_elektronik;
    public $ttd_ba_lingkungan_elektronik;
    
    // UI State
    public $showIdpelField = false;
    public $needStep3 = false; // Hanya perlu Step 3 jika ada yang pakai form
    public function mount($jenis = 'pasang_baru')
{
    $this->jenis_permohonan = $jenis;
    $this->showIdpelField = in_array($jenis, ['tambah_daya', 'peningkatan_keandalan']);
    $this->checkNeedStep3(); // 👈 Tambahkan ini
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
        ];
    }
    $this->checkNeedStep3();
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
    // KHUSUS UNTUK ISI FORM - BYPASS SEMUA
    if ($this->currentStep == 1) {
        $this->currentStep = 2;
    } elseif ($this->currentStep == 2) {
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
        
        if ($this->showIdpelField && $this->idpel) {
            $rules['idpel'] = 'nullable|string|max:50';
        }
        
        $this->validate($rules);
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
            $rules['ba_lingkungan_form.nomor_ba'] = 'required';
            $rules['ba_lingkungan_form.nama_pihak_kesatu'] = 'required';
            $rules['ba_lingkungan_form.nama_pihak_kedua'] = 'required';
            $rules['ba_lingkungan_form.luas_tanah'] = 'required';
            $rules['ba_lingkungan_form.lokasi'] = 'required';
        }
        
        // Validasi dokumen lainnya
        $rules['dokumen_return_agrimen'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:5120';
        $rules['dokumen_imb'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120';
        $rules['dokumen_sertifikat_lahan'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120';
        
        $this->validate($rules, $messages);
    }
    
    private function generateIdpel()
    {
        $prefix = 'PB';
        $date = date('Ymd');
        
        $countToday = Permohonan::where('jenis_permohonan', 'pasang_baru')
            ->whereDate('created_at', today())
            ->count();
        
        $sequence = str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);
        
        return $prefix . $date . $sequence;
    }
    
   public function submit()
{
    // DEBUG: Log TTD
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
            $baLingkunganData = json_encode($this->ba_lingkungan_form);
        }
        
        // Generate IDPEL
        $finalIdpel = $this->idpel;
        if ($this->jenis_permohonan == 'pasang_baru') {
            $finalIdpel = $this->generateIdpel();
        }
        
        // TTD - Placeholder
        $placeholder = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';
        $finalTtdBaLahan = $this->ttd_ba_lahan_elektronik ?: $placeholder;
        $finalTtdBaLingkungan = $this->ttd_ba_lingkungan_elektronik ?: $placeholder;
        
        $permohonan = Permohonan::create([
            'user_id' => Auth::id(),
            'jenis_permohonan' => $this->jenis_permohonan,
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
            'ttd_ba_lingkungan' => $finalTtdBaLingkungan,
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