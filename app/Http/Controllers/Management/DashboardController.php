<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_approved' => Permohonan::approved()->count(),
            'total_bulan_ini' => Permohonan::approved()
                ->whereMonth('approved_at', now()->month)
                ->count(),
        ];
        
        return view('management.dashboard', compact('stats'));
    }
}