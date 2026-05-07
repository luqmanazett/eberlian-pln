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
use Barryvdh\DomPDF\Facade\Pdf;

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
        
        $sortOrder = $request->sort == 'terlama' ? 'asc' : 'desc';
        $permohonans = $query->orderBy('created_at', $sortOrder)->paginate(10);
        
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
        
        // HANYA catat riwayat jika ada penolakan sebelumnya (jumlah_perbaikan > 0)
        if ($permohonan->jumlah_perbaikan > 0) {
            RiwayatPerbaikan::create([
                'permohonan_id' => $permohonan->id,
                'user_id' => Auth::id(),
                'versi_ke' => $permohonan->jumlah_perbaikan + 1,
                'dokumen_yang_diperbaiki' => ['semua_dokumen'],
                'dokumen_yang_ditolak' => null,
                'alasan_penolakan_sebelumnya' => $request->filled('catatan_admin') ? $request->catatan_admin : 'Permohonan disetujui.',
                'status_perbaikan' => 'approved',
                'submitted_at' => now(),
                'reviewed_at' => now(),
            ]);
        }
        
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
            
            $hasDokumenDitolak = $request->has('dokumen_ditolak') && count($request->dokumen_ditolak) > 0;
            
            $dokumenDitolak = $hasDokumenDitolak ? array_keys($request->dokumen_ditolak) : [];
            $dokumenUpload = array_filter($dokumenDitolak, function($d) { 
                return $d !== 'data_pemohon'; 
            });
            
            $isPenolakanPermanen = false;
            $isPerluPerbaikan = false;
            
            if (!$hasDokumenDitolak || $request->has('dokumen_ditolak.data_pemohon')) {
                $isPenolakanPermanen = true;
            } elseif (!empty($dokumenUpload)) {
                $isPerluPerbaikan = true;
            }
            
            // ===== PENOLAKAN PERMANEN =====
            if ($isPenolakanPermanen) {
                $permohonan->update([
                    'status' => 'rejected',
                    'catatan_reject_global' => $request->catatan_reject_global,
                    'rejected_at' => now(),
                    'tanggal_reject' => now(),
                    'jumlah_perbaikan' => 3,
                ]);
                
                $alasan = $this->buildAlasanLengkap($request);
                
                Notifikasi::create([
                    'user_id' => $permohonan->user_id,
                    'permohonan_id' => $permohonan->id,
                    'jenis_notifikasi' => 'rejected',
                    'pesan' => 'Permohonan DITOLAK. Silakan ajukan permohonan baru.',
                    'alasan' => $alasan ?: 'Permohonan ditolak.',
                ]);
                
                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'role' => 'admin',
                    'action' => 'reject_permohonan',
                    'description' => "Admin menolak permanen permohonan #{$permohonan->id}",
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);
                
                return;
            }
            
            // ===== PERLU PERBAIKAN =====
            if ($isPerluPerbaikan) {
                DetailPenolakan::where('permohonan_id', $permohonan->id)->delete();
                
                foreach ($dokumenUpload as $dokumen) {
                    DetailPenolakan::create([
                        'permohonan_id' => $permohonan->id,
                        'dokumen_type' => $dokumen,
                        'ditolak' => true,
                        'alasan_penolakan' => $request->alasan[$dokumen] ?? null,
                    ]);
                }
                
                $dokumenDitolakDetail = [];
                foreach ($dokumenUpload as $dokumen) {
                    $dokumenDitolakDetail[$dokumen] = $request->alasan[$dokumen] ?? 'Dokumen tidak sesuai';
                }
                
                RiwayatPerbaikan::create([
                    'permohonan_id' => $permohonan->id,
                    'user_id' => $permohonan->user_id,
                    'versi_ke' => $permohonan->jumlah_perbaikan + 1,
                    'dokumen_yang_diperbaiki' => $dokumenUpload,
                    'dokumen_yang_ditolak' => $dokumenDitolakDetail,
                    'alasan_penolakan_sebelumnya' => $request->catatan_reject_global ?? 'Dokumen perlu diperbaiki',
                    'status_perbaikan' => 'rejected',
                    'submitted_at' => now(),
                    'reviewed_at' => now(),
                ]);
                
                $permohonan->update([
                    'status' => 'rejected',
                    'catatan_reject_global' => $request->catatan_reject_global,
                    'rejected_at' => now(),
                    'tanggal_reject' => now(),
                ]);
                
                $alasan = $this->buildAlasanLengkap($request);
                
                Notifikasi::create([
                    'user_id' => $permohonan->user_id,
                    'permohonan_id' => $permohonan->id,
                    'jenis_notifikasi' => 'perlu_perbaikan',
                    'pesan' => 'Dokumen perlu diperbaiki. Silakan upload ulang.',
                    'alasan' => $alasan ?: 'Dokumen perlu diperbaiki.',
                ]);
                
                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'role' => 'admin',
                    'action' => 'reject_perbaikan',
                    'description' => "Admin meminta perbaikan dokumen untuk permohonan #{$permohonan->id}",
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);
            }
        });
        
        return redirect()->route('admin.verifikasi.index')->with('success', 'Permohonan diproses.');
    }
    
    private function buildAlasanLengkap(Request $request): string
    {
        $alasanParts = [];
        
        if ($request->catatan_reject_global) {
            $alasanParts[] = $request->catatan_reject_global;
        }
        
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
            ->orderBy('submitted_at', 'desc')
            ->get();
        
        return view('admin.verifikasi.history-perbaikan', compact('permohonan', 'riwayatPerbaikan'));
    }
    
    /**
     * Export permohonan ke CSV
     */
public function exportExcel($id)
{
    $permohonan = Permohonan::with('user')->findOrFail($id);
    
    $filename = 'permohonan_PMH-' . str_pad($permohonan->id, 6, '0', STR_PAD_LEFT) . '.xlsx';
    
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Detail Permohonan');
    
    // Header style
    $headerStyle = [
        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '46C2B3']],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
    ];
    
    $sectionStyle = [
        'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '46C2B3']],
    ];
    
    // Set headers
    $headers = ['No', 'Field', 'Value'];
    foreach ($headers as $col => $header) {
        $cell = $sheet->setCellValueByColumnAndRow($col + 1, 1, $header);
        $sheet->getStyleByColumnAndRow($col + 1, 1)->applyFromArray($headerStyle);
    }
    
    $row = 2;
    $no = 1;
    
    // === SECTION: DATA PEMOHON ===
    $sheet->mergeCells("A{$row}:C{$row}");
    $sheet->setCellValue("A{$row}", 'DATA PEMOHON');
    $sheet->getStyle("A{$row}")->applyFromArray($sectionStyle);
    $row++;
    
    $dataPemohon = [
        'No Permohonan' => 'PMH-' . str_pad($permohonan->id, 6, '0', STR_PAD_LEFT),
        'Nama Pelanggan' => $permohonan->nama_pelanggan,
        'Jenis Permohonan' => ucwords(str_replace('_', ' ', $permohonan->jenis_permohonan)),
        'No KTP' => $permohonan->no_ktp,
        'IDPEL' => $permohonan->idpel ?? '-',
        'No Telepon' => $permohonan->no_telepon,
        'ULP' => $permohonan->ulp,
        'Alamat Gardu' => $permohonan->alamat_gardu,
        'Nama Gardu' => $permohonan->nama_gardu,
        'Status' => ucfirst($permohonan->status),
        'Tanggal Pengajuan' => $permohonan->created_at->format('d/m/Y H:i'),
        'Diajukan Oleh' => $permohonan->user->name ?? '-',
    ];
    
    foreach ($dataPemohon as $field => $value) {
        $sheet->setCellValue("A{$row}", $no++);
        $sheet->setCellValue("B{$row}", $field);
        $sheet->setCellValue("C{$row}", $value);
        $row++;
    }
    
    // === SECTION: FORM BA LAHAN (Jika ada) ===
    if ($permohonan->ba_lahan_type == 'form' && $permohonan->ba_lahan_data) {
        $row++; // Spasi
        $sheet->mergeCells("A{$row}:C{$row}");
        $sheet->setCellValue("A{$row}", 'DATA FORM BA LAHAN');
        $sheet->getStyle("A{$row}")->applyFromArray($sectionStyle);
        $row++;
        
        $dataForm = json_decode($permohonan->ba_lahan_data, true);
        $labels = [
            'unit_pln' => 'Unit PLN',
            'nama_pekerjaan' => 'Nama Pekerjaan',
            'desa_kelurahan' => 'Desa/Kelurahan',
            'kecamatan' => 'Kecamatan',
            'kabupaten_kota' => 'Kabupaten/Kota',
            'nama_pemilik' => 'Nama Pemilik',
            'no_telepon_pemilik' => 'No Telepon Pemilik',
            'alamat_pemilik' => 'Alamat Pemilik',
            'status_pemilik' => 'Status Pemilik',
            'pernyataan_1' => 'Berdampak terhadap 200 orang atau lebih',
            'pernyataan_2' => 'Berdampak terhadap berkurangnya pendapatan >10%',
            'pernyataan_3' => 'Berlokasi di lahan masyarakat adat',
            'pernyataan_4' => 'Berdampak negatif terhadap masyarakat adat',
        ];
        
        foreach ($labels as $key => $label) {
            $value = $dataForm[$key] ?? '-';
            if (in_array($key, ['pernyataan_1', 'pernyataan_2', 'pernyataan_3', 'pernyataan_4'])) {
                $value = $value ? 'Ya' : 'Tidak';
            }
            $sheet->setCellValue("A{$row}", $no++);
            $sheet->setCellValue("B{$row}", $label);
            $sheet->setCellValue("C{$row}", $value);
            $row++;
        }
    }
    
    // === SECTION: FORM BA LINGKUNGAN (Jika ada) ===
    if ($permohonan->ba_lingkungan_type == 'form' && $permohonan->ba_lingkungan_data) {
        $row++; // Spasi
        $sheet->mergeCells("A{$row}:C{$row}");
        $sheet->setCellValue("A{$row}", 'DATA FORM BA LINGKUNGAN');
        $sheet->getStyle("A{$row}")->applyFromArray($sectionStyle);
        $row++;
        
        $dataForm = json_decode($permohonan->ba_lingkungan_data, true);
        $labels = [
            'nomor_ba' => 'Nomor BA',
            'nama_pihak_kesatu' => 'Pihak Kesatu',
            'jabatan_pihak_kesatu' => 'Jabatan Pihak Kesatu',
            'nama_pihak_kedua' => 'Pihak Kedua (PLN)',
            'luas_tanah' => 'Luas Tanah',
            'lokasi' => 'Lokasi',
            'nomor_sertifikat' => 'Nomor Sertifikat',
            'batas_utara' => 'Batas Utara',
            'batas_timur' => 'Batas Timur',
            'batas_selatan' => 'Batas Selatan',
            'batas_barat' => 'Batas Barat',
        ];
        
        foreach ($labels as $key => $label) {
            $value = $dataForm[$key] ?? '-';
            $sheet->setCellValue("A{$row}", $no++);
            $sheet->setCellValue("B{$row}", $label);
            $sheet->setCellValue("C{$row}", $value);
            $row++;
        }
    }
    
    // Auto size columns
    $sheet->getColumnDimension('A')->setWidth(5);
    $sheet->getColumnDimension('B')->setWidth(35);
    $sheet->getColumnDimension('C')->setWidth(50);
    
    // Border untuk semua cell
    $lastRow = $row - 1;
    $sheet->getStyle("A1:C{$lastRow}")->applyFromArray([
        'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
    ]);
    
    // Download
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    
    $writer->save('php://output');
    exit;
}   
    /**
     * Export permohonan ke PDF
     */
    public function exportPdf($id)
    {
        $permohonan = Permohonan::with('user')->findOrFail($id);
        
        $filename = 'permohonan_' . ($permohonan->id_register ?? 'PMH-' . $permohonan->id) . '.pdf';
        
        $pdf = Pdf::loadView('admin.export.pdf', [
            'permohonans' => [$permohonan],
            'startDate' => null,
            'endDate' => null,
            'status' => null,
            'jenis' => null
        ])->setPaper('a4', 'portrait');
        
        return $pdf->download($filename);
    }
    
    /**
     * Export Berita Acara Lahan (Penilaian Dampak) (PDF)
     */
    public function exportBaLahanPdf($id)
    {
        $permohonan = Permohonan::with('user')->findOrFail($id);
        $filename = 'BA_Penilaian_Dampak_' . ($permohonan->id_register ?? 'PMH-' . $permohonan->id) . '.pdf';
        
        $pdf = Pdf::loadView('admin.export.ba_lahan_pdf', [
            'permohonan' => $permohonan
        ])->setPaper('a4', 'portrait');
        
        return $pdf->stream($filename);
    }

    /**
     * Export Berita Acara Lingkungan (Serah Terima) (PDF)
     */
    public function exportBaLingkunganPdf($id)
    {
        $permohonan = Permohonan::with('user')->findOrFail($id);
        $filename = 'BA_Serah_Terima_' . ($permohonan->id_register ?? 'PMH-' . $permohonan->id) . '.pdf';
        
        $pdf = Pdf::loadView('admin.export.ba_formal_pdf', [
            'permohonan' => $permohonan
        ])->setPaper('a4', 'portrait');
        
        return $pdf->stream($filename);
    }
}