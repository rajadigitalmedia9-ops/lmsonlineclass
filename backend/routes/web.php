<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\LiveClasses;
use App\Livewire\Admin\Students;
use App\Livewire\Admin\Courses;
use App\Livewire\Admin\Videos;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/live-stream-test', function () {
    return view('live-stream-test');
});

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
    Route::get('/students', \App\Livewire\Admin\Students::class)->name('admin.students');
    Route::get('/courses', \App\Livewire\Admin\Courses::class)->name('admin.courses');
    Route::get('/subjects', \App\Livewire\Admin\Subjects::class)->name('admin.subjects');
    Route::get('/live-classes', \App\Livewire\Admin\LiveClasses::class)->name('admin.live-classes');
    Route::get('/videos', \App\Livewire\Admin\Videos::class)->name('admin.videos');
});

// Student Auth
Route::get('/login', App\Livewire\Student\Login::class)->name('login');
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// Student Portal Routes
Route::middleware('auth')->prefix('student')->group(function () {
    Route::get('/dashboard', App\Livewire\Student\Dashboard::class)->name('student.dashboard');
    Route::get('/my-courses', App\Livewire\Student\MyCourses::class)->name('student.courses');
    Route::get('/live-sessions', App\Livewire\Student\LiveSessions::class)->name('student.live');
    Route::get('/course/{id}', App\Livewire\Student\CoursePlayer::class)->name('student.course.player');
});

Route::get('/debug-log', function () {
    $logFile = storage_path('logs/laravel.log');
    if (file_exists($logFile)) {
        return response()->file($logFile);
    }
    return "No log file found.";
});
