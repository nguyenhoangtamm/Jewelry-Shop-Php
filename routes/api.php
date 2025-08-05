<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// Định nghĩa route API đơn giản
Route::get('/hello', function () {
    return response()->json(['message' => 'Xin chào từ API!']);
});
Route::middleware('web')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('api.auth.login');
    Route::post('/register', [AuthController::class, 'register'])->name('api.auth.register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.auth.logout');
});