<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SellerDashboardController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isSeller()) {
        return redirect()->route('seller.dashboard');
    }
    
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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
    
    // Comment routes
    Route::post('/{id}/comments', [CommentController::class, 'store'])->name('comments.store');
});

// Seller Routes
Route::prefix('sellers')->name('sellers.')->group(function () {
    // Public routes
    Route::get('/', [SellerController::class, 'index'])->name('index');
    Route::get('/register', [SellerController::class, 'create'])->name('create');
    Route::post('/register', [SellerController::class, 'store'])->name('store');
    Route::get('/success', [SellerController::class, 'success'])->name('success');
    Route::get('/{id}', [SellerController::class, 'show'])->name('show');
});

// Admin Routes (SRS-MartPlace-02, 07, 09-11)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Seller management
    Route::get('/sellers', [AdminController::class, 'sellers'])->name('sellers');
    Route::get('/sellers/{id}', [AdminController::class, 'showSeller'])->name('sellers.show');
    Route::post('/sellers/{id}/approve', [SellerController::class, 'approve'])->name('sellers.approve');
    Route::post('/sellers/{id}/reject', [SellerController::class, 'reject'])->name('sellers.reject');
    
    // Product management
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::post('/products/{id}/toggle', [AdminController::class, 'toggleProduct'])->name('products.toggle');
    
    // Reports
    Route::get('/reports/seller-status', [ReportController::class, 'sellerStatus'])->name('reports.seller-status');
    Route::get('/reports/sellers-by-province', [ReportController::class, 'sellersByProvince'])->name('reports.sellers-by-province');
    Route::get('/reports/products-by-rating', [ReportController::class, 'productsByRating'])->name('reports.products-by-rating');
});

// Seller Routes (SRS-MartPlace-03, 08, 12-14)
Route::middleware(['auth', 'seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');
    
    // Product management
    Route::get('/products', [SellerDashboardController::class, 'products'])->name('products');
    Route::get('/products/create', [SellerDashboardController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [SellerDashboardController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{id}/edit', [SellerDashboardController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{id}', [SellerDashboardController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{id}', [SellerDashboardController::class, 'deleteProduct'])->name('products.delete');
    
    // Reports
    Route::get('/reports/stock-list', [ReportController::class, 'sellerStockList'])->name('reports.stock-list');
    Route::get('/reports/products-by-rating', [ReportController::class, 'sellerProductsByRating'])->name('reports.products-by-rating');
    Route::get('/reports/low-stock', [ReportController::class, 'sellerLowStock'])->name('reports.low-stock');
});

require __DIR__.'/auth.php';