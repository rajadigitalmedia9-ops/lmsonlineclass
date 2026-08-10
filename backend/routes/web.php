<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard;

Route::get('/', function () {
    return view('welcome');
});

// Admin Routes (To be protected by auth middleware later)
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('admin.dashboard');
});
