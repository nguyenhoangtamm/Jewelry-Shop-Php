<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\JewelryController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ProductDetailController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [AuthController::class, 'loginView'])->name('auth.loginView');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/register', [AuthController::class, 'registerView'])->name('auth.registerView');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/detail/{id}', [ProductDetailController::class, 'show'])->name('product.detail');


Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/jewelries', [JewelryController::class, 'index'])->name('admin.jewelries.index');
Route::post('/admin/jewelries', [JewelryController::class, 'store'])->name('admin.jewelries.store');
Route::get('/admin/jewelries/{id}/edit', [JewelryController::class, 'edit'])->name('admin.jewelries.edit');
Route::put('/admin/jewelries/{id}', [JewelryController::class, 'update'])->name('admin.jewelries.update');
Route::delete('/admin/jewelries/{id}', [JewelryController::class, 'destroy'])->name('admin.jewelries.destroy');

Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');

Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
Route::post('/admin/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
Route::put('/admin/categories/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
Route::delete('/admin/categories/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
Route::get('/admin/categories/{id}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');

Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
Route::get('/admin/orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
Route::put('/admin/orders/{id}', [OrderController::class, 'update'])->name('admin.orders.update');
Route::delete('/admin/orders/{id}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');
Route::post('/admin/orders', [OrderController::class, 'store'])->name('admin.orders.store');
