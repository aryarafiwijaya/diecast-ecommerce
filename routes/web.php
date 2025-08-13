<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Middleware\AdminOnly;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

Route::get('/test-log', function () {
    Log::error('✅ TEST LOG: Laravel bisa nulis ke log?');
    return 'Log test written!';
});

Route::get('/debug-log', function () {
    $logPath = storage_path('logs/laravel.log');

    if (!File::exists($logPath)) {
        return 'Log file not found.';
    }

    $logContent = File::get($logPath);

    // Batasi biar gak terlalu besar
    return nl2br(substr($logContent, -5000));
});

// Redirect Root ke Dashboard langsung (baik login atau belum)
Route::redirect('/', '/dashboard');

// Shop User
Route::get('/shop', [UserProductController::class, 'index'])->name('shop.index');
Route::get('/shop/{product}', [UserProductController::class, 'show'])->name('shop.show');

// Dashboard User dengan pengecekan admin
Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->is_admin) {
        return redirect()->route('admin.dashboard');
    }

    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Fitur User 
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::delete('/cart-clear', [CartController::class, 'clear'])->name('cart.clear');

// Halaman Review & Checkout (login wajib)
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout/review', [CartController::class, 'review'])->name('cart.review');
    Route::post('/checkout/review', [CartController::class, 'reviewPost'])->name('cart.review'); 
    Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::view('/profile', 'profile')->name('profile');

    // Midtrans Snap Token
    Route::post('/midtrans/token', [CartController::class, 'getMidtransToken'])->name('midtrans.token');
});


// Webhook Midtrans (tanpa auth!)
Route::post('/midtrans/webhook', [MidtransWebhookController::class, 'handle']);

// Admin Area
Route::middleware(['auth', AdminOnly::class])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('/products', ProductController::class);
        Route::resource('/orders', AdminOrderController::class)->only(['index', 'show', 'destroy']);
    });

require __DIR__.'/auth.php';
