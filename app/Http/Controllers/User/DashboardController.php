<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $stats = [
            'total_permohonan' => Permohonan::where('user_id', $user->id)->count(),
            'pending' => Permohonan::where('user_id', $user->id)->where('status', 'pending')->count(),
            'approved' => Permohonan::where('user_id', $user->id)->where('status', 'approved')->count(),
            'rejected' => Permohonan::where('user_id', $user->id)->where('status', 'rejected')->count(),
            'notif_unread' => Notifikasi::where('user_id', $user->id)->where('sudah_dibaca', false)->count(),
        ];
        
        return view('user.dashboard', compact('stats'));
    }
}