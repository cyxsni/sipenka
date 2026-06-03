<?php

use App\Http\Controllers\AdminSuratController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserSuratController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\SuratKeluar;
use App\Models\User;

// Landing page
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    
    // Data statistik dari database
    $suratDiterbitkan = SuratKeluar::where('status', 'approved')->count();
    $bidangAktif = User::where('role', 'user')->distinct('bidang')->count('bidang');
    $totalPengajuan = SuratKeluar::count();
    
    return view('welcome', compact('suratDiterbitkan', 'bidangAktif', 'totalPengajuan'));
})->name('home');

// Dashboard redirect berdasarkan role
Route::get('/dashboard', function () {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes (bawaan Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==================== USER ROUTES ====================
Route::middleware(['auth', 'verified', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserSuratController::class, 'index'])->name('dashboard');
    Route::get('/pengajuan/create', [UserSuratController::class, 'create'])->name('pengajuan.create');
    Route::post('/pengajuan', [UserSuratController::class, 'store'])->name('pengajuan.store');
    Route::get('/pengajuan/{id}', [UserSuratController::class, 'show'])->name('pengajuan.show');
    
    // Download dan Print Surat
    Route::get('/surat/{id}/download', [UserSuratController::class, 'download'])->name('surat.download');
    Route::get('/surat/{id}/print', [UserSuratController::class, 'print'])->name('surat.print');
});

// ==================== ADMIN ROUTES ====================
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminSuratController::class, 'index'])->name('dashboard');
    Route::get('/surat/{id}', [AdminSuratController::class, 'show'])->name('surat.show');
    Route::post('/surat/{id}/approve', [AdminSuratController::class, 'approve'])->name('surat.approve');
    Route::post('/surat/{id}/reject', [AdminSuratController::class, 'reject'])->name('surat.reject');
    Route::delete('/surat/{id}', [AdminSuratController::class, 'destroy'])->name('surat.destroy');
    // Route untuk polling realtime
    Route::get('/check-new', [AdminSuratController::class, 'checkNew'])->name('check-new');
});

// Fallback logout GET (menghindari error 405)
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/')->with('success', 'Anda telah berhasil logout. 👋');
})->name('logout.get');

// Auth routes (login, register, dll) - dari Breeze
require __DIR__.'/auth.php';