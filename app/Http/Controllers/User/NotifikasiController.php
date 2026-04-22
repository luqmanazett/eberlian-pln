<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasis = Notifikasi::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        // Tandai semua sebagai sudah dibaca
        Notifikasi::where('user_id', Auth::id())
            ->where('sudah_dibaca', false)
            ->update(['sudah_dibaca' => true]);
        
        return view('user.notifikasi.index', compact('notifikasis'));
    }
    
    public function markAsRead($id)
    {
        $notifikasi = Notifikasi::where('user_id', Auth::id())
            ->findOrFail($id);
            
        $notifikasi->update(['sudah_dibaca' => true]);
        
        if ($notifikasi->permohonan_id) {
            return redirect()->route('user.permohonan.show', $notifikasi->permohonan_id);
        }
        
        return redirect()->route('user.notifikasi.index');
    }
    
    public function getUnreadCount()
    {
        $count = Notifikasi::where('user_id', Auth::id())
            ->where('sudah_dibaca', false)
            ->count();
            
        return response()->json(['count' => $count]);
    }
    public function markAllRead()
{
    Notifikasi::where('user_id', Auth::id())
        ->where('sudah_dibaca', false)
        ->update(['sudah_dibaca' => true]);
    
    return redirect()->route('user.notifikasi.index')
        ->with('success', 'Semua notifikasi telah ditandai dibaca');
}
}