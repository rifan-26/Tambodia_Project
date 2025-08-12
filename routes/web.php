<?php
// ===== 1. ROUTES: web.php =====
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\LandingController;

// ===== PUBLIC ROUTES =====
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/landing', [LandingController::class, 'index']);

// ===== AUTH ROUTES =====
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===== PROTECTED ROUTES =====
Route::middleware(['auth'])->group(function () {
    
    // ===== DASHBOARD ROUTES =====
    Route::get('/dashboard', [DashboardController::class, 'pegawai'])->name('dashboard.pegawai');
    
    // ===== MEDIA ROUTES (Pegawai) =====
    Route::get('/input', [MediaController::class, 'index'])->name('media.input');
    Route::post('/media/store', [MediaController::class, 'store'])->name('media.store');
    Route::post('/media/toggle-landing', [MediaController::class, 'toggleLanding'])->name('media.toggle-landing');
    Route::delete('/media/{id}', [MediaController::class, 'destroy'])->name('media.destroy');
    
    // ===== SCHEDULE ROUTES (Pegawai) =====
    Route::get('/jadwal', [ScheduleController::class, 'index'])->name('schedule.index');
    Route::post('/schedule/store', [ScheduleController::class, 'store'])->name('schedule.store');
    Route::put('/schedule/{id}', [ScheduleController::class, 'update'])->name('schedule.update');
    Route::delete('/schedule/{id}', [ScheduleController::class, 'destroy'])->name('schedule.destroy');
    
    // ===== SUPER ADMIN ROUTES =====
    Route::middleware(['role:superadmin'])->group(function () {
        Route::get('/superadmin', [DashboardController::class, 'superadmin'])->name('dashboard.superadmin');
        Route::get('/superakun', [SuperAdminController::class, 'adminManagement'])->name('admin.management');
        Route::post('/admin/store', [SuperAdminController::class, 'storeAdmin'])->name('admin.store');
        Route::put('/admin/{id}', [SuperAdminController::class, 'updateAdmin'])->name('admin.update');
        Route::delete('/admin/{id}', [SuperAdminController::class, 'destroyAdmin'])->name('admin.destroy');
    });
});

// ===== API ROUTES (untuk AJAX calls) =====
Route::middleware(['auth'])->prefix('api')->group(function () {
    Route::get('/media/search', [MediaController::class, 'search'])->name('api.media.search');
    Route::get('/media/filter', [MediaController::class, 'filter'])->name('api.media.filter');
});
