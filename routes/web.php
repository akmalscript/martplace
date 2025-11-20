<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Seller Routes
Route::prefix('sellers')->name('sellers.')->group(function () {
    // Public routes
    Route::get('/register', [SellerController::class, 'create'])->name('create');
    Route::post('/register', [SellerController::class, 'store'])->name('store');
    Route::get('/success', [SellerController::class, 'success'])->name('success');
    
    // Protected routes (requires authentication)
    Route::middleware('auth')->group(function () {
        Route::get('/', [SellerController::class, 'index'])->name('index');
        Route::get('/{id}', [SellerController::class, 'show'])->name('show');
        Route::post('/{id}/approve', [SellerController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [SellerController::class, 'reject'])->name('reject');
    });
});

require __DIR__.'/auth.php';
