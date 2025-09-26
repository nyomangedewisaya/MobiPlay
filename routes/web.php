<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login_action', [AuthController::class, 'loginAction'])->name('login_action');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register_action', [AuthController::class, 'registerAction'])->name('register_action');

Route::middleware('auth')->group(function() {
    Route::middleware('role:admin')->group(function() {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::prefix('managements')->name('managements.')->group(function() {
            Route::resource('/categories', CategoryController::class);
        });
    });
});