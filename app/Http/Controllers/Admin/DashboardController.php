<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\RiwayatPerbaikan;

use App\Exports\PermohonanExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
   public function index()
{
    // Statistik utama
    $stats = [
        'total' => Permohonan::count(),
        'pending' => Permohonan::where('status', 'pending')->count(),
        'approved' => Permohonan::where('status', 'approved')->count(),
        'rejected' => Permohonan::where('status', 'rejected')->count(),
        'perlu_perbaikan' => RiwayatPerbaikan::where('status_perbaikan', 'submitted')->count(),
    ];
    
    // Data 7 hari terakhir
    $chartData = Permohonan::select(
            DB::raw('DATE(tanggal_upload) as date'),
            DB::raw('COUNT(*) as total')
        )
        ->where('tanggal_upload', '>=', now()->subDays(7))
        ->groupBy('date')
        ->orderBy('date')
        ->get();
        
    // Data per jenis permohonan
    $jenisData = Permohonan::select('jenis_permohonan', DB::raw('COUNT(*) as total'))
        ->groupBy('jenis_permohonan')
        ->get();
    
    // Permohonan terbaru (5)
    $recentPermohonans = Permohonan::with('user')
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();
    
    return view('admin.dashboard', compact('stats', 'chartData', 'jenisData', 'recentPermohonans'));
}
    public function showExportForm()
    {
        return view('admin.export.index');
    }
    public function export(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $status = $request->status;
        $jenis = $request->jenis;
        
        $format = $request->format ?? 'excel';
        
        if ($format == 'pdf') {
            $query = Permohonan::query()->orderBy('tanggal_upload', 'desc');
            
            if ($startDate && $endDate) {
                $query->whereBetween('tanggal_upload', [$startDate, $endDate]);
            }
            if ($status) {
                $query->where('status', $status);
            }
            if ($jenis) {
                $query->where('jenis_permohonan', $jenis);
            }
            
            $permohonans = $query->get();
            $filename = 'rekap_permohonan_' . date('Y-m-d') . '.pdf';
            
            $pdf = Pdf::loadView('admin.export.pdf', compact('permohonans', 'startDate', 'endDate', 'status', 'jenis'))
                      ->setPaper('a4', 'landscape');
                      
            return $pdf->download($filename);
        }
        
        $filename = 'rekap_permohonan_' . date('Y-m-d') . '.xlsx';
        return Excel::download(new PermohonanExport($startDate, $endDate, $status, $jenis), $filename);
    }
}