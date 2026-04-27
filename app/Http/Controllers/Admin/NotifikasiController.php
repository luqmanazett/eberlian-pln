<?php

namespace App\Http\Controllers\Admin;

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
        
        return view('admin.notifikasi.index', compact('notifikasis'));
    }
    
    public function markAsRead($id)
    {
        $notifikasi = Notifikasi::where('user_id', Auth::id())
            ->findOrFail($id);
            
        $notifikasi->update(['sudah_dibaca' => true]);
        
        if ($notifikasi->permohonan_id) {
            return redirect()->route('admin.verifikasi.show', $notifikasi->permohonan_id);
        }
        
        return redirect()->route('admin.notifikasi.index');
    }
    public function getUnreadCount()
{
    $count = Notifikasi::where('user_id', Auth::id())
        ->where('sudah_dibaca', false)
        ->count();
        
    return response()->json(['count' => $count]);
}
}