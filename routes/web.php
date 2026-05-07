<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\VerifikasiController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\NotifikasiController as AdminNotifikasiController;
use App\Http\Controllers\Management\DashboardController as ManagementDashboardController;
use App\Http\Controllers\User\PermohonanController;
use App\Http\Controllers\User\NotifikasiController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    
    return match($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'management' => redirect()->route('management.dashboard'),
        default => redirect()->route('user.dashboard'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
});

// ============================================
// === USER ROUTES ===
// ============================================
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    Route::post('/notifikasi/mark-all-read', [NotifikasiController::class, 'markAllRead'])->name('notifikasi.markAllRead');
    
    Route::get('/permohonan/create', function () {
        $jenis = request()->get('jenis', 'pasang_baru');
        return view('user.permohonan.livewire-create', compact('jenis'));
    })->name('permohonan.create');
    
    Route::post('/permohonan', [PermohonanController::class, 'store'])->name('permohonan.store');
    Route::get('/permohonan/success/{id}', [PermohonanController::class, 'success'])->name('permohonan.success');
    Route::get('/permohonan/history', [PermohonanController::class, 'history'])->name('permohonan.history');
    Route::get('/permohonan/{id}', [PermohonanController::class, 'show'])->name('permohonan.show');
    Route::get('/permohonan/{id}/upload-ulang', [PermohonanController::class, 'uploadUlang'])->name('upload-ulang');
    Route::post('/permohonan/{id}/upload-ulang', [PermohonanController::class, 'submitUploadUlang'])->name('upload-ulang.submit');
    
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::get('/notifikasi/unread-count', [NotifikasiController::class, 'getUnreadCount'])->name('notifikasi.unread');
    Route::get('/notifikasi/{id}/read', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.read');
});

// ============================================
// === ADMIN ROUTES ===
// ============================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // ===== FITUR UNTUK SEMUA ADMIN (LEVEL 1 & 2) =====
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart-data', [AdminDashboardController::class, 'getChartData'])->name('dashboard.chart');
    
    Route::get('/verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi.index');
    Route::get('/verifikasi/{id}', [VerifikasiController::class, 'show'])->name('verifikasi.show');
    Route::post('/verifikasi/{id}/approve', [VerifikasiController::class, 'approve'])->name('verifikasi.approve');
    Route::post('/verifikasi/{id}/reject', [VerifikasiController::class, 'reject'])->name('verifikasi.reject');
    Route::get('/verifikasi/{id}/history-perbaikan', [VerifikasiController::class, 'showHistoryPerbaikan'])->name('verifikasi.history-perbaikan');
    
    // Export Permohonan Individual
    Route::get('/export/permohonan/{id}/excel', [VerifikasiController::class, 'exportExcel'])->name('export.permohonan.excel');
    Route::get('/export/permohonan/{id}/pdf', [VerifikasiController::class, 'exportPdf'])->name('export.permohonan.pdf');
    Route::get('/export/permohonan/{id}/ba-lahan', [VerifikasiController::class, 'exportBaLahanPdf'])->name('export.permohonan.ba-lahan');
    Route::get('/export/permohonan/{id}/ba-lingkungan', [VerifikasiController::class, 'exportBaLingkunganPdf'])->name('export.permohonan.ba-lingkungan');
   
    
    // Notifikasi Admin
    Route::get('/notifikasi', [AdminNotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::get('/notifikasi/unread-count', [AdminNotifikasiController::class, 'getUnreadCount'])->name('notifikasi.unread');
    Route::get('/notifikasi/{id}/read', [AdminNotifikasiController::class, 'markAsRead'])->name('notifikasi.read');
    
    // ===== FITUR HANYA ADMIN UTAMA (LEVEL 1) =====
    Route::middleware(['admin.level:1'])->group(function () {
        Route::get('/export-data', [AdminDashboardController::class, 'showExportForm'])->name('export.index');
        Route::get('/export', [AdminDashboardController::class, 'export'])->name('export');
        
        Route::resource('user', UserController::class)->except(['show']);
        Route::post('/user/{id}/reset-password', [UserController::class, 'resetPassword'])->name('user.reset-password');
    });
    
});

// ============================================
// === MANAGEMENT ROUTES ===
// ============================================
Route::middleware(['auth', 'role:management'])->prefix('management')->name('management.')->group(function () {
    Route::get('/dashboard', [ManagementDashboardController::class, 'index'])->name('dashboard');
    Route::post('/export/excel', function() {
        return back()->with('success', 'Fitur export Excel akan segera hadir!');
    })->name('export.excel');
    Route::post('/export/zip', function() {
        return back()->with('success', 'Fitur export ZIP akan segera hadir!');
    })->name('export.zip');
});

require __DIR__.'/auth.php';