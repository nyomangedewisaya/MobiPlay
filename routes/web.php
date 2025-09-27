<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AuthController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login_action', [AuthController::class, 'loginAction'])->name('login_action');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register_action', [AuthController::class, 'registerAction'])->name('register_action');

Route::middleware('auth')->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::prefix('managements')
            ->name('managements.')
            ->group(function () {
                Route::resource('/categories', CategoryController::class);
                Route::resource('/products', ProductController::class);
                Route::patch('/products/{product:slug}/status', [ProductController::class, 'updateStatus'])->name('products.updateStatus'); // update status product

                Route::get('/items/select-product', [ItemController::class, 'productList'])->name('items.productList'); // list product for items
                Route::get('/items/products/{product:slug}', [ItemController::class, 'index'])->name('items.index');
                Route::get('/items/{product:slug}/create', [ItemController::class, 'create'])->name('items.create');
                Route::post('/items/{product:slug}', [ItemController::class, 'store'])->name('items.store');
                Route::patch('/items/{item:slug}/status', [ItemController::class, 'updateStatus'])->name('items.updateStatus'); // update status items
                Route::patch('/items/{item:slug}/discount', [ItemController::class, 'updateDiscount'])->name('items.updateDiscount'); // update discount items
                Route::resource('items', ItemController::class)->except(['index', 'show', 'create', 'store']);
            });
    });
});
