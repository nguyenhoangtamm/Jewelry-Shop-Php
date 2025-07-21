<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/jewelries', [App\Http\Controllers\JewelryController::class, 'index'])->name('admin.jewelries.index');
Route::post('/admin/jewelries', [App\Http\Controllers\JewelryController::class, 'store'])->name('admin.jewelries.store');
Route::get('/admin/jewelries/{id}/edit', [App\Http\Controllers\JewelryController::class, 'edit'])->name('admin.jewelries.edit');
Route::put('/admin/jewelries/{id}', [App\Http\Controllers\JewelryController::class, 'update'])->name('admin.jewelries.update');
Route::delete('/admin/jewelries/{id}', [App\Http\Controllers\JewelryController::class, 'destroy'])->name('admin.jewelries.destroy');
