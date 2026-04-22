<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Notifikasi;
use App\Models\DetailPenolakan;
use App\Models\RiwayatPerbaikan;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VerifikasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Permohonan::with('user');
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('jenis') && $request->jenis != '') {
            $query->where('jenis_permohonan', $request->jenis);
        }
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_pelanggan', 'like', "%{$search}%")
                  ->orWhere('no_ktp', 'like', "%{$search}%")
                  ->orWhere('idpel', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tanggal_upload', [$request->start_date, $request->end_date]);
        }
        
        $permohonans = $query->orderBy('created_at', 'desc')->paginate(10);
        
        $stats = [
            'total' => Permohonan::count(),
            'pending' => Permohonan::where('status', 'pending')->count(),
        ];
        
        return view('admin.verifikasi.index', compact('permohonans', 'stats'));
    }
    
    public function show($id)
    {
        $permohonan = Permohonan::with('user', 'detailPenolakan')->findOrFail($id);
        return view('admin.verifikasi.show', compact('permohonan'));
    }
    
    public function approve(Request $request, $id)
    {
        $permohonan = Permohonan::findOrFail($id);
        
        $permohonan->update([
            'status' => 'approved',
            'catatan_admin' => $request->catatan_admin,
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);
        
        Notifikasi::create([
            'user_id' => $permohonan->user_id,
            'permohonan_id' => $permohonan->id,
            'jenis_notifikasi' => 'approved',
            'pesan' => 'Permohonan Anda telah DISETUJUI.',
            'alasan' => $request->catatan_admin,
        ]);
        
        ActivityLog::create([
            'user_id' => Auth::id(),
            'role' => 'admin',
            'action' => 'approve_permohonan',
            'description' => "Admin menyetujui permohonan #{$id}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
        
        return redirect()->route('admin.verifikasi.index')->with('success', 'Permohonan disetujui.');
    }
    
    public function reject(Request $request, $id)
    {
        $permohonan = Permohonan::findOrFail($id);
        
        DB::transaction(function() use ($request, $permohonan) {
            
            // Cek apakah ada dokumen yang ditolak
            $hasDokumenDitolak = $request->has('dokumen_ditolak') && count($request->dokumen_ditolak) > 0;
            
            // Jika TIDAK ADA yang dicentang, atau Data Pemohon dicentang
            if (!$hasDokumenDitolak || $request->has('dokumen_ditolak.data_pemohon')) {
                // Permohonan ditolak permanen, user harus buat baru
                $permohonan->update([
                    'status' => 'rejected',
                    'catatan_reject_global' => $request->catatan_reject_global,
                    'rejected_at' => now(),
                    'tanggal_reject' => now(),
                    'jumlah_perbaikan' => 3,
                ]);
                
                // Notifikasi dengan alasan lengkap
                $alasan = $this->buildAlasanLengkap($request);
                
                Notifikasi::create([
                    'user_id' => $permohonan->user_id,
                    'permohonan_id' => $permohonan->id,
                    'jenis_notifikasi' => 'rejected',
                    'pesan' => 'Permohonan DITOLAK. Silakan ajukan permohonan baru.',
                    'alasan' => $alasan ?: 'Permohonan ditolak.',
                ]);
                
                return;
            }
            
            // Jika ada dokumen yang ditolak (selain data_pemohon)
            $dokumenDitolak = array_keys($request->dokumen_ditolak);
            $dokumenDitolak = array_filter($dokumenDitolak, function($d) { 
                return $d !== 'data_pemohon'; 
            });
            
            if (!empty($dokumenDitolak)) {
                
                // 👇 RESET SEMUA DETAIL PENOLAKAN LAMA
                DetailPenolakan::where('permohonan_id', $permohonan->id)->delete();
                
                // 👇 SIMPAN HANYA DOKUMEN YANG DICENTANG SEKARANG
                foreach ($dokumenDitolak as $dokumen) {
                    DetailPenolakan::create([
                        'permohonan_id' => $permohonan->id,
                        'dokumen_type' => $dokumen,
                        'ditolak' => true,
                        'alasan_penolakan' => $request->alasan[$dokumen] ?? null,
                    ]);
                }
                
                // Simpan riwayat perbaikan
                $dokumenDitolakDetail = [];
                foreach ($dokumenDitolak as $dokumen) {
                    $dokumenDitolakDetail[$dokumen] = $request->alasan[$dokumen] ?? 'Dokumen tidak sesuai';
                }
                
                RiwayatPerbaikan::create([
                    'permohonan_id' => $permohonan->id,
                    'user_id' => $permohonan->user_id,
                    'versi_ke' => $permohonan->jumlah_perbaikan + 1,
                    'dokumen_yang_diperbaiki' => $dokumenDitolak,
                    'dokumen_yang_ditolak' => $dokumenDitolakDetail,
                    'alasan_penolakan_sebelumnya' => $request->catatan_reject_global ?? 'Dokumen perlu diperbaiki',
                    'status_perbaikan' => 'rejected',
                    'submitted_at' => now(),
                    'reviewed_at' => now(),
                ]);
            }
            
            $permohonan->update([
                'status' => 'rejected',
                'catatan_reject_global' => $request->catatan_reject_global,
                'rejected_at' => now(),
                'tanggal_reject' => now(),
            ]);
            
            // Notifikasi dengan alasan lengkap
            $alasan = $this->buildAlasanLengkap($request);
            
            Notifikasi::create([
                'user_id' => $permohonan->user_id,
                'permohonan_id' => $permohonan->id,
                'jenis_notifikasi' => 'rejected',
                'pesan' => 'Permohonan DITOLAK. Silakan perbaiki dokumen.',
                'alasan' => $alasan ?: 'Dokumen perlu diperbaiki.',
            ]);
            
            // Log Aktivitas
            ActivityLog::create([
                'user_id' => Auth::id(),
                'role' => 'admin',
                'action' => 'reject_permohonan',
                'description' => "Admin menolak permohonan #{$permohonan->id}",
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        });
        
        return redirect()->route('admin.verifikasi.index')->with('success', 'Permohonan ditolak.');
    }
    
    /**
     * Build alasan lengkap dari catatan global + alasan per dokumen
     */
    private function buildAlasanLengkap(Request $request): string
    {
        $alasanParts = [];
        
        // Catatan global
        if ($request->catatan_reject_global) {
            $alasanParts[] = $request->catatan_reject_global;
        }
        
        // Alasan per dokumen
        if ($request->has('alasan') && is_array($request->alasan)) {
            $alasanDetail = [];
            $labels = [
                'data_pemohon' => 'Data Pemohon',
                'ba_lahan' => 'BA Lahan',
                'ba_lingkungan' => 'BA Lingkungan',
                'return_agrimen' => 'Written Agreement',
                'imb' => 'IMB',
                'sertifikat_lahan' => 'Sertifikat Lahan',
            ];
            
            foreach ($request->alasan as $dokumen => $alasanDokumen) {
                if (!empty($alasanDokumen)) {
                    $label = $labels[$dokumen] ?? $dokumen;
                    $alasanDetail[] = "• {$label}: {$alasanDokumen}";
                }
            }
            
            if (!empty($alasanDetail)) {
                if (!empty($alasanParts)) {
                    $alasanParts[] = '';
                }
                $alasanParts = array_merge($alasanParts, $alasanDetail);
            }
        }
        
        return implode("\n", $alasanParts);
    }
    
    public function showHistoryPerbaikan($id)
    {
        $permohonan = Permohonan::with(['riwayatPerbaikan.user', 'user'])->findOrFail($id);
        
        $riwayatPerbaikan = $permohonan->riwayatPerbaikan()
            ->orderBy('versi_ke', 'desc')
            ->get();
        
        return view('admin.verifikasi.history-perbaikan', compact('permohonan', 'riwayatPerbaikan'));
    }
}