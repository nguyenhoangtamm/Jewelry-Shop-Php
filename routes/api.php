<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// Định nghĩa route API đơn giản
Route::get('/hello', function () {
    return response()->json(['message' => 'Xin chào từ API!']);
});

// Review API routes
Route::get('/reviews/{jewelry_id}', [ReviewController::class, 'getReviews']);
Route::middleware('web')->group(function () {
    Route::post('/reviews', [ReviewController::class, 'store']);
});

Route::middleware('web')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('api.auth.login');
    Route::post('/register', [AuthController::class, 'register'])->name('api.auth.register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.auth.logout');
});
