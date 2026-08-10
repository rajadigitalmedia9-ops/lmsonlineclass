<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\LiveClasses;

Route::get('/', function () {
    return view('welcome');
});

// Admin Routes (To be protected by auth middleware later)
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('admin.dashboard');
    Route::get('/live-classes', LiveClasses::class)->name('admin.live-classes');
});
