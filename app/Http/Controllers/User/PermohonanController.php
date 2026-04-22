<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\ActivityLog;
use App\Models\RiwayatPerbaikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PermohonanController extends Controller
{
    public function create(Request $request)
    {
        $jenis = $request->get('jenis', 'pasang_baru');
        
        if (!in_array($jenis, ['pasang_baru', 'tambah_daya', 'peningkatan_keandalan'])) {
            $jenis = 'pasang_baru';
        }
        
        return view('user.permohonan.livewire-create', compact('jenis'));
    }
    
    public function store(Request $request)
    {
        // Ini sudah di-handle oleh Livewire component
    }
    
    public function success($id)
    {
        $permohonan = Permohonan::where('user_id', Auth::id())->findOrFail($id);
        return view('user.permohonan.success', compact('permohonan'));
    }
    
    public function history(Request $request)
{
    $query = Permohonan::where('user_id', Auth::id());
    
    // Filter berdasarkan status
    if ($request->has('status') && $request->status != 'semua') {
        $query->where('status', $request->status);
    }
    
    // 👇 URUTAN BERDASARKAN WAKTU TERBARU (updated_at)
    $permohonans = $query->orderBy('updated_at', 'desc')->paginate(10);
    
    return view('user.permohonan.history', compact('permohonans'));
}
    
    public function show($id)
    {
        $permohonan = Permohonan::where('user_id', Auth::id())
            ->with(['detailPenolakan'])
            ->findOrFail($id);
            
        return view('user.permohonan.show', compact('permohonan'));
    }
    
   public function uploadUlang($id)
{
    $permohonan = Permohonan::where('user_id', Auth::id())
        ->with(['detailPenolakan'])
        ->findOrFail($id);
        
    if (!$permohonan->canUploadUlang()) {
        $message = $permohonan->jumlah_perbaikan >= 3 
            ? 'Anda sudah mencapai batas maksimal 3 kali upload ulang.'
            : 'Batas waktu 24 jam untuk upload ulang sudah habis.';
            
        return redirect()->route('user.permohonan.history')->with('error', $message);
    }
    
    $dokumenDitolak = $permohonan->getDokumenDitolak();
    
    // Kirim opsi BA Lahan & BA Lingkungan ke view
    $baLahanOption = $permohonan->ba_lahan_type ?? 'upload';
    $baLingkunganOption = $permohonan->ba_lingkungan_type ?? 'upload';
    
    // Kirim data form lama (jika ada)
    $baLahanData = $permohonan->ba_lahan_data ? json_decode($permohonan->ba_lahan_data, true) : null;
    $baLingkunganData = $permohonan->ba_lingkungan_data ? json_decode($permohonan->ba_lingkungan_data, true) : null;
    
    return view('user.permohonan.upload-ulang', compact(
        'permohonan', 
        'dokumenDitolak', 
        'baLahanOption', 
        'baLingkunganOption',
        'baLahanData',
        'baLingkunganData'
    ));
}
   public function submitUploadUlang(Request $request, $id)
{
    $permohonan = Permohonan::where('user_id', Auth::id())->findOrFail($id);
    
    if (!$permohonan->canUploadUlang()) {
        return redirect()->route('user.permohonan.history')->with('error', 'Tidak dapat upload ulang.');
    }
    
    $dokumenDitolak = $permohonan->getDokumenDitolak();
    
    // Simpan riwayat perbaikan
    $dokumenDitolakDetail = [];
    foreach ($dokumenDitolak as $dokumen) {
        $detail = $permohonan->detailPenolakan->where('dokumen_type', $dokumen)->first();
        $dokumenDitolakDetail[$dokumen] = $detail->alasan_penolakan ?? 'Dokumen tidak sesuai';
    }
    
    RiwayatPerbaikan::create([
        'permohonan_id' => $permohonan->id,
        'user_id' => Auth::id(),
        'versi_ke' => $permohonan->jumlah_perbaikan + 1,
        'dokumen_yang_diperbaiki' => $dokumenDitolak,
        'dokumen_yang_ditolak' => $dokumenDitolakDetail,
        'alasan_penolakan_sebelumnya' => $permohonan->catatan_reject_global ?? 'Dokumen perlu diperbaiki',
        'status_perbaikan' => 'submitted',
        'submitted_at' => now(),
    ]);
    
    // Siapkan array untuk update (hanya field yang berubah)
    $updateData = [
        'status' => 'pending',
        'jumlah_perbaikan' => $permohonan->jumlah_perbaikan + 1,
    ];
    
    // Handle BA Lahan
    if (in_array('ba_lahan', $dokumenDitolak)) {
        if ($permohonan->ba_lahan_type == 'upload') {
            // Opsi Upload
            if ($request->hasFile('dokumen_ba_lahan')) {
                $request->validate(['dokumen_ba_lahan' => 'file|mimes:pdf,jpg,jpeg,png|max:5120']);
                $path = $request->file('dokumen_ba_lahan')->store(
                    "permohonan/" . Auth::id() . "/perbaikan",
                    'public'
                );
                $updateData['dokumen_ba_lahan'] = $path;
            }
        } else {
            // Opsi Form
            if ($request->has('ba_lahan_form')) {
                $updateData['ba_lahan_data'] = json_encode($request->ba_lahan_form);
                $updateData['ttd_ba_lahan'] = $request->ttd_ba_lahan ?? null;
            }
        }
    }
    
    // Handle BA Lingkungan
    if (in_array('ba_lingkungan', $dokumenDitolak)) {
        if ($permohonan->ba_lingkungan_type == 'upload') {
            // Opsi Upload
            if ($request->hasFile('dokumen_ba_lingkungan')) {
                $request->validate(['dokumen_ba_lingkungan' => 'file|mimes:pdf,jpg,jpeg,png|max:5120']);
                $path = $request->file('dokumen_ba_lingkungan')->store(
                    "permohonan/" . Auth::id() . "/perbaikan",
                    'public'
                );
                $updateData['dokumen_ba_lingkungan'] = $path;
            }
        } else {
            // Opsi Form
            if ($request->has('ba_lingkungan_form')) {
                $updateData['ba_lingkungan_data'] = json_encode($request->ba_lingkungan_form);
                $updateData['ttd_ba_lingkungan'] = $request->ttd_ba_lingkungan ?? null;
            }
        }
    }
    
    // Handle dokumen lainnya (Upload)
    $dokumenUploadFields = ['return_agrimen', 'imb', 'sertifikat_lahan'];
    foreach ($dokumenUploadFields as $dokumen) {
        if (in_array($dokumen, $dokumenDitolak)) {
            if ($request->hasFile('dokumen_' . $dokumen)) {
                $request->validate(['dokumen_' . $dokumen => 'file|mimes:pdf,jpg,jpeg,png|max:5120']);
                $path = $request->file('dokumen_' . $dokumen)->store(
                    "permohonan/" . Auth::id() . "/perbaikan",
                    'public'
                );
                $updateData['dokumen_' . $dokumen] = $path;
            }
        }
    }
    
    // UPDATE hanya field yang berubah (field lain tetap aman)
    $permohonan->update($updateData);
    
    // Log Aktivitas
    ActivityLog::create([
        'user_id' => Auth::id(),
        'role' => 'user',
        'action' => 'upload_ulang',
        'description' => "User upload ulang dokumen untuk permohonan #{$id}",
        'ip_address' => request()->ip(),
        'user_agent' => request()->userAgent(),
    ]);
    
    return redirect()->route('user.permohonan.history')->with('success', 'Dokumen berhasil diperbaiki. Menunggu verifikasi.');
}
}