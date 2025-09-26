<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ModuleController as UserModuleController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ModuleController as AdminModuleController;
use App\Http\Controllers\Admin\KitCodeController as AdminKitCodeController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});


// User Dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    
    // Module routes
    Route::get('/modules', [UserModuleController::class, 'index'])->name('modules.index');
    Route::get('/modules/{module}', [UserModuleController::class, 'show'])->name('modules.show');
    Route::get('/modules/{module}/activities/{activity}', [UserModuleController::class, 'showActivity'])->name('modules.activities.show');
    
    // Code redemption
    Route::get('/modules/{module}/redeem-code', [UserModuleController::class, 'showRedeemForm'])->name('modules.redeem-code.show');
    Route::post('/modules/{module}/redeem-code', [UserModuleController::class, 'redeemCode'])->name('modules.redeem-code');
    
    // Progress tracking
    Route::post('/activities/{activity}/checklist/{checklist}', [UserModuleController::class, 'toggleChecklist'])->name('activities.checklist.toggle');
    Route::post('/activities/{activity}/save-progress', [UserModuleController::class, 'saveProgress'])->name('activities.save-progress');
    
});

// Admin routes
    Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Modules management
    Route::resource('modules', AdminModuleController::class);
    Route::post('modules/{module}/activate', [AdminModuleController::class, 'activate'])->name('modules.activate');
    Route::post('modules/{module}/deactivate', [AdminModuleController::class, 'deactivate'])->name('modules.deactivate');
    
    // Activities (Sub-modules) management
    Route::resource('activities', \App\Http\Controllers\Admin\ActivityController::class);
    Route::post('activities/{activity}/activate', [\App\Http\Controllers\Admin\ActivityController::class, 'activate'])->name('activities.activate');
    Route::post('activities/{activity}/deactivate', [\App\Http\Controllers\Admin\ActivityController::class, 'deactivate'])->name('activities.deactivate');
    
    // Checklists management (nested under activities)
    Route::resource('activities.checklists', \App\Http\Controllers\Admin\ChecklistController::class)->except(['index', 'show']);
    
    // Users management
    Route::resource('users', AdminUserController::class);
    Route::post('users/{user}/toggle-role', [AdminUserController::class, 'toggleRole'])->name('users.toggle-role');
    
    // Kit codes management
    Route::resource('kit-codes', AdminKitCodeController::class);
    Route::post('kit-codes/generate', [AdminKitCodeController::class, 'generate'])->name('kit-codes.generate');
    Route::get('kit-codes/export', [AdminKitCodeController::class, 'export'])->name('kit-codes.export');
    
    // Reports
    Route::get('reports', [AdminDashboardController::class, 'reports'])->name('reports');
    Route::get('reports/usage', [AdminDashboardController::class, 'usageReport'])->name('reports.usage');
    Route::get('reports/progress', [AdminDashboardController::class, 'progressReport'])->name('reports.progress');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
