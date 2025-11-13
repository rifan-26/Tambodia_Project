<?php
// ===== 1. ROUTES: web.php =====
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\LayoutController_clean;
use App\Http\Controllers\ScheduledBackgroundController;
use App\Http\Controllers\ScheduleDescriptionController;
use App\Http\Controllers\SuperAdminController;

Route::get('/test', function () {
    return 'Middleware works!';
})->middleware('role:superadmin');

// ===== PUBLIC ROUTES =====
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Debug routes
require __DIR__.'/debug.php';
require __DIR__.'/test-schedule.php';
Route::get('/landing', [LandingController::class, 'index']);

// ===== PUBLIC API ROUTES (untuk landing page) =====
Route::get('/api/public/landing/current-schedule', [LandingController::class, 'getCurrentSchedule'])->name('api.public.landing.schedule');
Route::get('/api/public/landing/visual-schedules', [LandingController::class, 'getActiveVisualSchedules'])->name('api.public.landing.visual');
Route::get('/api/public/landing/audio-schedules', [LandingController::class, 'getActiveAudioSchedule'])->name('api.public.landing.audio');
Route::get('/api/public/staff', [LayoutController_clean::class, 'getStaff'])->name('api.public.staff');

// ===== AUTH ROUTES =====
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===== PROTECTED ROUTES =====
Route::middleware(['auth'])->group(function () {
    
    // ===== DASHBOARD ROUTES =====
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.pegawai');
    // Alias untuk backward compatibility
    Route::redirect('/home', '/dashboard')->name('dashboard');
    
    // ===== TEMPLATE MANAGEMENT ROUTES =====
    Route::prefix('admin/templates')->name('templates.')->group(function () {
        Route::get('/', [\App\Http\Controllers\TemplateController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\TemplateController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\TemplateController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [\App\Http\Controllers\TemplateController::class, 'edit'])->name('edit');
        Route::put('/{id}', [\App\Http\Controllers\TemplateController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\TemplateController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/activate', [\App\Http\Controllers\TemplateController::class, 'activate'])->name('activate');
        Route::post('/{id}/duplicate', [\App\Http\Controllers\TemplateController::class, 'duplicate'])->name('duplicate');
    });
    
    // Template API routes
    Route::post('/api/templates/upload-image', [\App\Http\Controllers\TemplateController::class, 'uploadImage'])->name('api.templates.upload-image');
    
    // Template Builder Component Route
    Route::get('/components/template-builder-content', function () {
        return view('components.template-builder-content');
    })->name('components.builder');
    Route::get('/input', [MediaController::class, 'index'])->name('media.input');
    Route::post('/media', [MediaController::class, 'store'])->name('media.store');
    Route::delete('/media/{id}', [MediaController::class, 'destroy'])->name('media.destroy');
    
    // Schedule routes - using single route 'schedule.index' for consistency
    Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');
    Route::post('/schedule', [ScheduleController::class, 'store'])->name('schedule.store');
    Route::put('/schedule/{id}', [ScheduleController::class, 'update'])->name('schedule.update');
    Route::get('/schedule/{id}', [ScheduleController::class, 'show'])->name('schedule.show');
    Route::delete('/schedule/{id}', [ScheduleController::class, 'destroy'])->name('schedule.destroy');
    // Master Layout
    Route::get('/layout', [LayoutController_clean::class, 'index'])->name('layout');
    Route::get('/layout/index', [LayoutController_clean::class, 'index'])->name('layout.index');
    
    // Old layout manager (backup)
    Route::get('/layout/old', [LayoutController_clean::class, 'index'])->name('layout.old');
    Route::post('/layout/update', [LayoutController_clean::class, 'updateLayoutSettings'])->name('layout.update');
    Route::post('/layout/background', [LayoutController_clean::class, 'updateBackground'])->name('layout.background');
    Route::post('/layout/description', [LayoutController_clean::class, 'updateDescription'])->name('layout.description');
    Route::get('/layout/settings', [LayoutController_clean::class, 'getLayoutSettings'])->name('layout.settings');
    
    // Staff Management Page
    Route::get('/staff', function () {
        return view('staff-manager');
    })->name('staff.index');
    
    // Staff API routes
    Route::get('/api/staff', [LayoutController_clean::class, 'getStaff'])->name('api.staff.get');
    Route::post('/api/staff', [LayoutController_clean::class, 'storeStaff'])->name('api.staff.store');
    Route::post('/api/staff/{id}', [LayoutController_clean::class, 'updateStaff'])->name('api.staff.update');
    Route::post('/api/staff/{id}/toggle-status', [LayoutController_clean::class, 'toggleStaffStatus'])->name('api.staff.toggle-status');
    Route::post('/api/staff/{id}/delete', [LayoutController_clean::class, 'deleteStaff'])->name('api.staff.delete');
    
    // Staff Names API routes
    Route::get('/api/staff-names', [LayoutController_clean::class, 'getStaffNames'])->name('api.staff-names.get');
    Route::post('/api/staff-names', [LayoutController_clean::class, 'storeStaffName'])->name('api.staff-names.store');
    Route::delete('/api/staff-names', [LayoutController_clean::class, 'deleteStaffName'])->name('api.staff-names.delete');
    
    // Template API routes
    Route::get('/api/layout/templates', [LayoutController_clean::class, 'getTemplates'])->name('api.layout.templates');
    Route::post('/api/layout/save-template', [LayoutController_clean::class, 'saveAsTemplate'])->name('api.layout.save-template');
    Route::get('/api/layout/load-template/{id}', [LayoutController_clean::class, 'loadTemplate'])->name('api.layout.load-template');
    Route::delete('/api/layout/delete-template/{id}', [LayoutController_clean::class, 'deleteTemplate'])->name('api.layout.delete-template');
    
    // Staff Names API routes
    Route::get('/api/staff-names', [LayoutController_clean::class, 'getStaffNames'])->name('api.staff-names.get');
    Route::post('/api/staff-names', [LayoutController_clean::class, 'storeStaffName'])->name('api.staff-names.store');
    Route::delete('/api/staff-names/{id}', [LayoutController_clean::class, 'deleteStaffName'])->name('api.staff-names.delete');
    
    // Schedule Description API routes
    Route::prefix('api')->group(function () {
        Route::get('/schedule-descriptions', [ScheduleDescriptionController::class, 'index']);
        Route::post('/schedule-descriptions', [ScheduleDescriptionController::class, 'store']);
        Route::put('/schedule-descriptions/{id}', [ScheduleDescriptionController::class, 'update']);
        Route::delete('/schedule-descriptions/{id}', [ScheduleDescriptionController::class, 'destroy']);
        Route::get('/schedule-descriptions/active', [ScheduleDescriptionController::class, 'getActiveDescription']);
    });
    
    // ===== SUPER ADMIN ROUTES =====
    Route::middleware(['role:superadmin'])->group(function () {
        Route::get('/superadmin', [DashboardController::class, 'superadmin'])
        ->name('dashboard.superadmin');
        Route::get('/superakun', [SuperAdminController::class, 'adminManagement'])->name('admin.management');
        Route::post('/admin/store', [SuperAdminController::class, 'storeAdmin'])->name('admin.store');
        Route::put('/admin/{id}', [SuperAdminController::class, 'updateAdmin'])->name('admin.update');
        Route::delete('/admin/{id}', [SuperAdminController::class, 'destroyAdmin'])->name('admin.destroy');
    });
});

// ===== API ROUTES (untuk AJAX calls) =====
Route::middleware('auth')->group(function () {
    // Layout status endpoint
    Route::get('/api/layout/current-status', [LayoutController::class, 'getCurrentLayoutStatus'])->name('layout.current.status');
    
    // Media AJAX endpoints
    Route::get('/api/media/search', [MediaController::class, 'search'])->name('api.media.search');
    Route::get('/api/media/filter', [MediaController::class, 'filter'])->name('api.media.filter');
    Route::get('/api/media/user', [MediaController::class, 'getUserMedia'])->name('api.media.user');
    Route::get('/api/media/stats', [MediaController::class, 'getStats'])->name('api.media.stats');
    
    // Schedule API endpoints
    Route::get('/api/schedule/active', [ScheduleController::class, 'getActiveSchedules'])->name('api.schedule.active');
    Route::get('/api/schedule/audio', [ScheduleController::class, 'getActiveAudioSchedules'])->name('api.schedule.audio');
    Route::get('/api/dashboard/audio-schedules', [DashboardController::class, 'getActiveAudioSchedulesApi'])->name('api.dashboard.audio');
    
    // Landing page API endpoints
    Route::get('/api/landing/current-schedule', [LandingController::class, 'getCurrentSchedule'])->name('api.landing.schedule');
    Route::get('/api/landing/visual-schedules', [LandingController::class, 'getActiveVisualSchedules'])->name('api.landing.visual');
    
    // Layout settings API endpoints
    Route::post('/api/layout/update-background', [ScheduleController::class, 'updateBackground'])->name('api.layout.update.background');
    Route::post('/api/layout/update-description', [ScheduleController::class, 'updateDescription'])->name('api.layout.update.description');
    
    // Scheduled backgrounds
    Route::get('/api/scheduled-backgrounds', [ScheduledBackgroundController::class, 'index'])->name('api.scheduled-backgrounds.index');
    Route::post('/api/scheduled-backgrounds', [ScheduledBackgroundController::class, 'store'])->name('api.scheduled-backgrounds.store');
    Route::delete('/api/scheduled-backgrounds/{id}', [ScheduledBackgroundController::class, 'destroy'])->name('api.scheduled-backgrounds.destroy');
    Route::get('/api/active-background', [ScheduledBackgroundController::class, 'getActiveBackground'])->name('api.active-background');
});

// ===== MEDIA STREAM ROUTE (avoid symlink issues) =====
Route::middleware(['auth'])->get('/media/{path}', [MediaController::class, 'servePublic'])
    ->where('path', '.*')
    ->name('media.serve');