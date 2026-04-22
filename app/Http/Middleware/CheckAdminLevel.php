<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int  $level
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $level)
    {
        if (!Auth::check()) {
            abort(403, 'Akses ditolak. Silakan login.');
        }
        
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang bisa mengakses halaman ini.');
        }
        
        if (Auth::user()->admin_level != $level) {
            abort(403, 'Anda tidak memiliki akses ke fitur ini. Hanya Admin Utama yang bisa mengakses.');
        }
        
        return $next($request);
    }
}