<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\ProductDetailController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', [App\Http\Controllers\Home\HomeController::class, 'index'])->name('home');
Route::get('/detail/{id}', [ProductDetailController::class, 'show'])->name('product.detail');


Route::get('/admin/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/jewelries', [App\Http\Controllers\JewelryController::class, 'index'])->name('admin.jewelries.index');
Route::post('/admin/jewelries', [App\Http\Controllers\JewelryController::class, 'store'])->name('admin.jewelries.store');
Route::get('/admin/jewelries/{id}/edit', [App\Http\Controllers\JewelryController::class, 'edit'])->name('admin.jewelries.edit');
Route::put('/admin/jewelries/{id}', [App\Http\Controllers\JewelryController::class, 'update'])->name('admin.jewelries.update');
Route::delete('/admin/jewelries/{id}', [App\Http\Controllers\JewelryController::class, 'destroy'])->name('admin.jewelries.destroy');

Route::get('/admin/users', [App\Http\Controllers\UserController::class, 'index'])->name('admin.users.index');
Route::put('/admin/users/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('admin.users.update');
Route::delete('/admin/users/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('admin.users.destroy');
Route::get('/admin/users/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('admin.users.edit');
Route::post('/admin/users', [App\Http\Controllers\UserController::class, 'store'])->name('admin.users.store');

Route::get('/admin/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('admin.categories.index');
Route::post('/admin/categories', [App\Http\Controllers\CategoryController::class, 'store'])->name('admin.categories.store');
Route::put('/admin/categories/{id}', [App\Http\Controllers\CategoryController::class, 'update'])->name('admin.categories.update');
Route::delete('/admin/categories/{id}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('admin.categories.destroy');
Route::get('/admin/categories/{id}/edit', [App\Http\Controllers\CategoryController::class, 'edit'])->name('admin.categories.edit');

Route::get('/admin/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('admin.orders.index');
Route::get('/admin/orders/{id}', [App\Http\Controllers\OrderController::class, 'show'])->name('admin.orders.show');
Route::put('/admin/orders/{id}', [App\Http\Controllers\OrderController::class, 'update'])->name('admin.orders.update');
Route::delete('/admin/orders/{id}', [App\Http\Controllers\OrderController::class, 'destroy'])->name('admin.orders.destroy');
Route::post('/admin/orders', [App\Http\Controllers\OrderController::class, 'store'])->name('admin.orders.store');
