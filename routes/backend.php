<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\RoleController;
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
