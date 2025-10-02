<?php

use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductInputFieldController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login_action', [AuthController::class, 'loginAction'])->name('login_action');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register_action', [AuthController::class, 'registerAction'])->name('register_action');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/api/search-products', [HomeController::class, 'searchHelper'])->name('api.search-products');
Route::get('/order/{product:slug}', [CheckoutController::class, 'show'])->name('transaction.show');
Route::get('/checkout/{order:order_code}', [CheckoutController::class, 'success'])->name('transaction.success');
Route::post('/order/{product:slug}', [CheckoutController::class, 'checkout'])->name('transaction.checkout');

Route::middleware('auth')->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::prefix('managements')
            ->name('managements.')
            ->group(function () {
                Route::resources([
                    '/categories' => CategoryController::class,
                    '/products' => ProductController::class,
                ]);
                Route::patch('/products/{product:slug}/status', [ProductController::class, 'updateStatus'])->name('products.updateStatus'); // update status product

                Route::get('/items/select-product', [ItemController::class, 'productList'])->name('items.productList'); // list product for items
                Route::get('/items/products/{product:slug}', [ItemController::class, 'index'])->name('items.index');
                Route::get('/items/products/{product:slug}/create', [ItemController::class, 'create'])->name('items.create');
                Route::post('/items/products/{product:slug}', [ItemController::class, 'store'])->name('items.store');
                Route::patch('/items/products/{item:slug}/status', [ItemController::class, 'updateStatus'])->name('items.updateStatus'); // update status items
                Route::patch('/items/products/{item:slug}/discount', [ItemController::class, 'updateDiscount'])->name('items.updateDiscount'); // update discount items
                Route::resource('items', ItemController::class)->except(['index', 'show', 'create', 'store']);

                Route::get('/input-fields/select-product', [ProductInputFieldController::class, 'productList'])->name('input-fields.productList'); // list product for input fields
                Route::get('/input-fields/products/{product:slug}', [ProductInputFieldController::class, 'index'])->name('input-fields.index');
                Route::get('/input-fields/products/{product:slug}/create', [ProductInputFieldController::class, 'create'])->name('input-fields.create');
                Route::post('/input-fields/products/{product:slug}', [ProductInputFieldController::class, 'store'])->name('input-fields.store');
                Route::get('/input-fields/{productInputField:field_name}/edit', [ProductInputFieldController::class, 'edit'])->name('input-fields.edit');
                Route::put('/input-fields/{productInputField:field_name}', [ProductInputFieldController::class, 'update'])->name('input-fields.update');
                Route::delete('/input-fields/{productInputField:field_name}', [ProductInputFieldController::class, 'destroy'])->name('input-fields.destroy');
            });
        Route::resource('/articles', ArticleController::class);
        Route::patch('/articles/{article:slug}/status', [ArticleController::class, 'updateStatus'])->name('articles.updateStatus'); // update status articles
        
        Route::resource('/advertisements', AdvertisementController::class);
        Route::patch('/advertisements/{advertisement:slug}/status', [AdvertisementController::class, 'updateStatus'])->name('advertisements.updateStatus'); // update status advertisements

        Route::resource('/orders', OrderController::class)->only('index');
        Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus'); // update status orders
    });

    Route::prefix('profile')
        ->name('profile.')
        ->group(function () {
            Route::get('/', [ProfileController::class, 'editProfile'])->name('edit');
            Route::patch('/', [ProfileController::class, 'updateProfile'])->name('update');
            Route::get('/password', [ProfileController::class, 'editPassword'])->name('password.edit');
            Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
        });

    Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('about-us');
    Route::get('/history', [HomeController::class, 'history'])->name('history');
});
