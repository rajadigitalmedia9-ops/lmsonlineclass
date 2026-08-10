<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\LiveClasses;
use App\Livewire\Admin\Students;
use App\Livewire\Admin\Courses;
use App\Livewire\Admin\Videos;

Route::get('/', function () {
    return view('welcome');
});

// Admin Routes (To be protected by auth middleware later)
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('admin.dashboard');
    Route::get('/live-classes', LiveClasses::class)->name('admin.live-classes');
    Route::get('/students', Students::class)->name('admin.students');
    Route::get('/courses', Courses::class)->name('admin.courses');
    Route::get('/videos', Videos::class)->name('admin.videos');
});

Route::get('/debug-log', function () {
    $logFile = storage_path('logs/laravel.log');
    if (file_exists($logFile)) {
        return response()->file($logFile);
    }
    return "No log file found.";
});
