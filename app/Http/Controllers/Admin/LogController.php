<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->orderBy('created_at', 'desc');
        
        // Filter tanggal
        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        // Filter role
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }
        
        // Filter action
        if ($request->has('action') && $request->action != '') {
            $query->where('action', 'like', '%' . $request->action . '%');
        }
        
        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }
        
        $logs = $query->paginate(20);
        
        // Statistik
        $stats = [
            'total' => ActivityLog::count(),
            'today' => ActivityLog::whereDate('created_at', today())->count(),
        ];
        
        return view('admin.log.index', compact('logs', 'stats'));
    }
    
    public function export(Request $request)
    {
        $query = ActivityLog::with('user')->orderBy('created_at', 'desc');
        
        if ($request->has('start_date') && $request->start_date != '') {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->has('end_date') && $request->end_date != '') {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        $logs = $query->get();
        
        // Generate CSV
        $filename = 'log_aktivitas_' . date('Y-m-d') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // Header CSV
        fputcsv($output, ['No', 'Tanggal', 'User', 'Role', 'Aksi', 'Deskripsi', 'IP Address']);
        
        foreach ($logs as $index => $log) {
            fputcsv($output, [
                $index + 1,
                $log->created_at->format('d/m/Y H:i:s'),
                $log->user->name ?? '-',
                ucfirst($log->role),
                $log->action,
                $log->description,
                $log->ip_address,
            ]);
        }
        
        fclose($output);
        exit;
    }
}