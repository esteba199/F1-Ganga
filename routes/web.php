<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

// Homepage redirect to cars catalog
Route::get('/', function () {
    return redirect()->route('cars.index');
});

// User Dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Julio - Cars CRUD (Public)
Route::get('/cars/search', [CarController::class, 'search'])->name('cars.search');
Route::resource('cars', CarController::class)->only(['index', 'show']);

Route::middleware('auth')->group(function () {
    // Jairo - Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Esteban - Checkout & Orders
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
    Route::post('/orders/{order}/refund', [OrderController::class, 'refund'])->name('orders.refund');

    // Misael - Reviews (User)
    Route::post('/cars/{car}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    
    // Misael - Shopping Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
});

// Admin Routes (Protected) - Con acceso restringido a administradores
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // CRUD Cars (Admin)
    Route::get('cars', [\App\Http\Controllers\Admin\CarController::class, 'index'])->name('cars.index');
    Route::resource('cars', \App\Http\Controllers\Admin\CarController::class)->except(['index', 'show']);
    Route::post('cars/{car}/restore', [\App\Http\Controllers\Admin\CarController::class, 'restore'])->name('cars.restore');
    Route::delete('cars/{car}/force-delete', [\App\Http\Controllers\Admin\CarController::class, 'forceDelete'])->name('cars.forceDelete');

    // CRUD Brands
    Route::get('brands', [\App\Http\Controllers\Admin\BrandController::class, 'index'])->name('brands.index');
    Route::get('brands/create', [\App\Http\Controllers\Admin\BrandController::class, 'create'])->name('brands.create');
    Route::post('brands', [\App\Http\Controllers\Admin\BrandController::class, 'store'])->name('brands.store');
    Route::get('brands/{brand}/edit', [\App\Http\Controllers\Admin\BrandController::class, 'edit'])->name('brands.edit');
    Route::put('brands/{brand}', [\App\Http\Controllers\Admin\BrandController::class, 'update'])->name('brands.update');
    Route::delete('brands/{brand}', [\App\Http\Controllers\Admin\BrandController::class, 'destroy'])->name('brands.destroy');

    // CRUD Teams
    Route::get('teams', [\App\Http\Controllers\Admin\TeamController::class, 'index'])->name('teams.index');
    Route::get('teams/create', [\App\Http\Controllers\Admin\TeamController::class, 'create'])->name('teams.create');
    Route::post('teams', [\App\Http\Controllers\Admin\TeamController::class, 'store'])->name('teams.store');
    Route::get('teams/{team}/edit', [\App\Http\Controllers\Admin\TeamController::class, 'edit'])->name('teams.edit');
    Route::put('teams/{team}', [\App\Http\Controllers\Admin\TeamController::class, 'update'])->name('teams.update');
    Route::delete('teams/{team}', [\App\Http\Controllers\Admin\TeamController::class, 'destroy'])->name('teams.destroy');

    // CRUD Reviews (Admin)
    Route::get('reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::get('reviews/create', [\App\Http\Controllers\Admin\ReviewController::class, 'create'])->name('reviews.create');
    Route::post('reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'store'])->name('reviews.store');
    Route::get('reviews/{review}/edit', [\App\Http\Controllers\Admin\ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('reviews/{review}', [\App\Http\Controllers\Admin\ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('reviews/{review}', [\App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');

    // CRUD Orders (Admin)
    Route::get('orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::get('orders/{order}/edit', [\App\Http\Controllers\Admin\OrderController::class, 'edit'])->name('orders.edit');
    Route::put('orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'update'])->name('orders.update');
});

require __DIR__.'/auth.php';
