<?php
// routes/web.php - SIMPLIFIED VERSION
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\InactivityController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    
    // Resource Routes
    Route::resource('users', UserController::class);
    Route::resource('activity-logs', ActivityLogController::class)->only(['index', 'show', 'destroy']);
    
    // NEW ROUTES WITHOUT ADMIN MIDDLEWARE
    Route::get('/inactivity-monitor', [InactivityController::class, 'index'])->name('inactivities.index');
    Route::get('/penalty-system', [InactivityController::class, 'penalties'])->name('penalties.index');
    Route::get('/system-config', [InactivityController::class, 'settings'])->name('settings.index');
    Route::post('/penalties/clear-old', [InactivityController::class, 'clearOldPenalties'])->name('penalties.clear-old');
    Route::post('/settings/update', [InactivityController::class, 'updateSettings'])->name('settings.update');
    
    // API Routes
    Route::prefix('api')->group(function () {
        Route::post('/inactivity-log', [InactivityController::class, 'logInactivity']);
        Route::post('/check-inactivity', [InactivityController::class, 'checkInactivity']);
    });
});

// Clear old logs route
Route::post('/activity-logs/clear-old', [ActivityLogController::class, 'clearOldLogs'])->name('activity-logs.clear-old');