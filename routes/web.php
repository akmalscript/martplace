<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\SellerDashboardController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes (requires authentication and admin role)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Seller Management
    Route::get('/sellers', [SellerController::class, 'index'])->name('sellers.index');
    Route::get('/sellers/{id}', [SellerController::class, 'show'])->name('sellers.show');
    Route::post('/sellers/{id}/approve', [SellerController::class, 'approve'])->name('sellers.approve');
    Route::post('/sellers/{id}/reject', [SellerController::class, 'reject'])->name('sellers.reject');
    Route::post('/sellers/{id}/pending', [SellerController::class, 'setPending'])->name('sellers.pending');

    // Category Management (Kelola Kategori)
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    // Reports (Laporan)
    Route::get('/reports', [\App\Http\Controllers\AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/sellers', [\App\Http\Controllers\AdminReportController::class, 'sellersReport'])->name('reports.sellers');
    Route::get('/reports/sellers-by-province', [\App\Http\Controllers\AdminReportController::class, 'sellersByProvinceReport'])->name('reports.sellers-by-province');
    Route::get('/reports/products-by-rating', [\App\Http\Controllers\AdminReportController::class, 'productsByRatingReport'])->name('reports.products-by-rating');
});

// Seller Dashboard Routes (requires authentication and active seller status)
Route::middleware(['auth', 'seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/products', [SellerDashboardController::class, 'products'])->name('products');
    Route::get('/products/create', [SellerDashboardController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [SellerDashboardController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{id}/edit', [SellerDashboardController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{id}', [SellerDashboardController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{id}', [SellerDashboardController::class, 'deleteProduct'])->name('products.delete');
    Route::get('/reports', [SellerDashboardController::class, 'reports'])->name('reports');
    
    // Seller Reports PDF Download
    Route::get('/reports/stock-by-quantity', [SellerDashboardController::class, 'reportStockByQuantity'])->name('reports.stock-by-quantity');
    Route::get('/reports/stock-by-rating', [SellerDashboardController::class, 'reportStockByRating'])->name('reports.stock-by-rating');
    Route::get('/reports/low-stock', [SellerDashboardController::class, 'reportLowStock'])->name('reports.low-stock');
});

// Wilayah API Proxy Routes
Route::prefix('api/wilayah')->group(function () {
    Route::get('/provinces', [WilayahController::class, 'provinces']);
    Route::get('/regencies/{provinceCode}', [WilayahController::class, 'regencies']);
    Route::get('/districts/{regencyCode}', [WilayahController::class, 'districts']);
    Route::get('/villages/{districtCode}', [WilayahController::class, 'villages']);
});

// Product Routes
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/search', [ProductController::class, 'search'])->name('search');
    Route::get('/{id}', [ProductController::class, 'show'])->name('show');
});

// Review Routes
Route::prefix('reviews')->name('reviews.')->group(function () {
    Route::post('/{id}', [ReviewController::class, 'store'])->name('store');
});

// Seller Routes
Route::prefix('sellers')->name('sellers.')->group(function () {
    // Public routes
    Route::get('/', [SellerController::class, 'publicIndex'])->name('index');
    Route::get('/register', [SellerController::class, 'create'])->name('create');
    Route::post('/register', [SellerController::class, 'store'])->name('store');
    Route::get('/success', [SellerController::class, 'success'])->name('success');
    Route::get('/{id}', [SellerController::class, 'publicShow'])->name('show');
});

require __DIR__.'/auth.php';
