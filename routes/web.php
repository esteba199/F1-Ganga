<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminDashboardController;
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

// Julio - Cars CRUD
Route::resource('cars', CarController::class);

Route::middleware('auth')->group(function () {
    // Jairo - Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Esteban - Checkout & Orders
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    // Misael - Reviews (User)
    Route::post('/cars/{car}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// Misael - Admin Routes (Protected)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

require __DIR__.'/auth.php';
