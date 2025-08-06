<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\JewelryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\User\CheckoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ProductDetailController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/register', [AuthController::class, 'registerView'])->name('auth.registerView');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// User routes (protected by auth middleware)
Route::middleware('auth')->group(function () {
    Route::get('/home', [\App\Http\Controllers\User\HomeController::class, 'index'])->name('home');
    Route::get('/detail/{id}', [ProductDetailController::class, 'show'])->name('product.detail');
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
});

// Admin routes (should add role middleware later)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Jewelry management
    Route::get('/jewelries', [JewelryController::class, 'index'])->name('jewelries.index');
    Route::post('/jewelries', [JewelryController::class, 'store'])->name('jewelries.store');
    Route::get('/jewelries/{id}/edit', [JewelryController::class, 'edit'])->name('jewelries.edit');
    Route::put('/jewelries/{id}', [JewelryController::class, 'update'])->name('jewelries.update');
    Route::delete('/jewelries/{id}', [JewelryController::class, 'destroy'])->name('jewelries.destroy');

    // User management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Category management
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Order management
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
});
