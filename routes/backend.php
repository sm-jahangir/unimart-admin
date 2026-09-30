<?php

use App\Http\Controllers\Backend\BarcodeController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\PurchaseController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SubscriberController;
use App\Http\Controllers\Backend\SupplierController;
use App\Http\Controllers\Backend\UnitController;
use App\Http\Controllers\Backend\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
| Registered in bootstrap/app.php with the 'app' URL prefix, 'app.' name
| prefix and the web+auth middleware group.
|
*/

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Catalog management
Route::resource('products', ProductController::class)->except('show');
Route::resource('brands', BrandController::class)->except('show');
Route::resource('categories', CategoryController::class)->except('show');
Route::resource('units', UnitController::class)->except('show');
Route::resource('barcodes', BarcodeController::class)->except('show');

// Sales
Route::put('/orders/{order}/status', [OrderController::class, 'statusChange'])->name('orders.status');
Route::resource('orders', OrderController::class)->only(['index', 'show']);
Route::resource('coupons', CouponController::class)->except('show');

// Inventory & procurement
Route::resource('suppliers', SupplierController::class)->except('show');
Route::resource('purchases', PurchaseController::class)->only(['index', 'show']);

// Storefront content
Route::resource('sliders', SliderController::class)->except('show');
Route::resource('subscribers', SubscriberController::class)->only(['index', 'destroy']);

// User management
Route::put('/users/{user}/status', [UserController::class, 'statusChange'])->name('users.status');
Route::resource('users', UserController::class);

// Role management
Route::resource('roles', RoleController::class)->except('show');

// Profile
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/profile/password', [ProfileController::class, 'changepass'])->name('profile.password');
Route::post('/profile/password', [ProfileController::class, 'changepassword'])->name('profile.password.update');
