<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\User\HomeController as UserHomeController;
use App\Http\Controllers\User\ProductDetailController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\SearchController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\JewelryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\User\FavoritesController;
use App\Http\Controllers\User\PointsController;
use App\Http\Controllers\User\NotificationsController;
use App\Http\Controllers\User\ReviewController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\User\ChatboxController;
// =============================
// Public routes (khách, chưa đăng nhập)
// =============================
Route::get('/', function () {
    return view('welcome');
});

// Auth & Register
Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/register', [AuthController::class, 'registerView'])->name('auth.registerView');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

// Forgot Password
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

// Giới thiệu, liên hệ
Route::get('/gioi-thieu', [HomeController::class, 'about'])->name('about');
Route::get('/lien-he', [ContactController::class, 'show'])->name('contact.show');
Route::post('/lien-he', [ContactController::class, 'submit'])->name('contact.submit');

// Jewelry route (danh mục sản phẩm)
Route::get('/jewelry/{id}', [JewelryController::class, 'showByCategory'])->name('jewelry.category');

// Detail product route (public)
Route::get('/detail/{id}', [ProductDetailController::class, 'show'])->name('jewelry.detail');
//Review
Route::post('/products/{jewelry}/reviews', [ReviewController::class, 'store'])
    ->name('products.reviews.store');
// Products listing page (public)
Route::get('/products', [ProductController::class, 'showAll'])->name('products.all');
// =============================
// User routes (cần đăng nhập)
// =============================
Route::middleware('auth')->group(function () {
    // Đăng xuất
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    // Trang chủ user
    Route::get('/home', [UserHomeController::class, 'index'])->name('home');

    // Chi tiết sản phẩm
    Route::get('/detail/{id}', [ProductDetailController::class, 'show'])->name('product.detail');

    // Thanh toán - chỉ customer
    Route::middleware('role:customer')->group(function () {
        Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
        Route::get('/checkout/cart', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    });

    // =============================
    // Admin routes - chỉ role admin được truy cập
    // =============================
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Quản lý sản phẩm (Jewelries)
        Route::get('/jewelries', [JewelryController::class, 'index'])->name('jewelries.index');
        Route::post('/jewelries', [JewelryController::class, 'store'])->name('jewelries.store');
        Route::get('/jewelries/{id}/edit', [JewelryController::class, 'edit'])->name('jewelries.edit');
        Route::put('/jewelries/{id}', [JewelryController::class, 'update'])->name('jewelries.update');
        Route::delete('/jewelries/{id}', [JewelryController::class, 'destroy'])->name('jewelries.destroy');

        // Quản lý người dùng
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::put('/users/{id}/lock', [UserController::class, 'lock'])->name('admin.users.lock');
        Route::put('/users/{id}/toggle-lock', [UserController::class, 'toggleLock'])->name('admin.users.toggleLock');


        // Quản lý danh mục
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Quản lý đơn hàng
        // Đặt các route tĩnh (pending, approve) trước route có tham số {id}
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/pending', [OrderController::class, 'pending'])->name('orders.pending');
        Route::get('/orders/{id}/approve', [OrderController::class, 'approveForm'])->name('orders.approveForm')->whereNumber('id');
        Route::post('/orders/{id}/approve', [OrderController::class, 'approve'])->name('orders.approve')->whereNumber('id');
        Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show')->whereNumber('id');
        Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update')->whereNumber('id');
        Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy')->whereNumber('id');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

        // Quản lý đánh giá
        Route::prefix('reviews')->name('reviews.')->group(function () {
            Route::get('/', [AdminReviewController::class, 'index'])->name('index');
            Route::get('/product/{jewelry_id}', [AdminReviewController::class, 'showByProduct'])->name('by-product')->whereNumber('jewelry_id');
            Route::get('/{id}', [AdminReviewController::class, 'show'])->name('show')->whereNumber('id');
            Route::delete('/{id}', [AdminReviewController::class, 'destroy'])->name('destroy')->whereNumber('id');
            Route::patch('/{id}/restore', [AdminReviewController::class, 'restore'])->name('restore')->whereNumber('id');
            Route::delete('/{id}/force', [AdminReviewController::class, 'forceDelete'])->name('force-delete')->whereNumber('id');
        });
    });

    // =============================
    // Profile routes - customer và admin đều xem/sửa hồ sơ
    // =============================
    Route::prefix('profile')->name('profile.')->middleware('role:customer,admin')->group(function () {
        Route::get('/{id}', [UserProfileController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [UserProfileController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserProfileController::class, 'update'])->name('update');
    });

    // =============================
    // Cart routes - customer (using session-based cart)
    // =============================
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::post('/update', [CartController::class, 'update'])->name('update');
        Route::post('/remove', [CartController::class, 'remove'])->name('remove');
        Route::post('/clear', [CartController::class, 'clear'])->name('clear');
        Route::get('/count', [CartController::class, 'getCartCount'])->name('count');
        Route::get('/data', [CartController::class, 'getCartData'])->name('data');
    });

    // =============================
    // User Orders routes - customer
    // =============================
    Route::prefix('orders')->name('user.orders.')->middleware('role:customer')->group(function () {
        Route::get('/', [UserOrderController::class, 'index'])->name('index');
        Route::get('/{id}', [UserOrderController::class, 'show'])->name('show');
    });

    // =============================
    // Favorites (Wishlist) - customer
    // =============================
    Route::prefix('favorites')->name('user.favorites.')->middleware('role:customer')->group(function () {
        Route::get('/', [FavoritesController::class, 'index'])->name('index');
        Route::post('/add', [FavoritesController::class, 'add'])->name('add');
        Route::delete('/remove/{id}', [FavoritesController::class, 'remove'])->name('remove');
    });

    // =============================
    // Points (Rewards) - customer
    // =============================
    Route::prefix('points')->name('user.points.')->middleware('role:customer')->group(function () {
        Route::get('/', [PointsController::class, 'index'])->name('index');
    });

    // =============================
    // Notifications - customer
    // =============================
    Route::prefix('notifications')->name('user.notifications.')->middleware('role:customer')->group(function () {
        Route::get('/', [NotificationsController::class, 'index'])->name('index');
    });

    // =============================
    // Chatbox AI - customer
    // =============================
    Route::prefix('chatbox')->name('user.chatbox.')->middleware('role:customer')->group(function () {
        Route::get('/', [ChatboxController::class, 'index'])->name('index');
        Route::post('/send', [ChatboxController::class, 'sendMessage'])->name('send');
    });

    // =============================
    // Sản phẩm, tin tức - cho phép customer và admin
    // =============================
    Route::get('/products/all', [ProductController::class, 'showAll'])->middleware('role:customer,admin')->name('products.all');
    Route::get('/tin-tuc', [NewsController::class, 'index'])->middleware('role:customer,admin')->name('news.index');

    Route::put('/orders/{order}/cancel', [OrderController::class, 'cancel'])
        ->name('user.orders.cancel');

    Route::post('/products/{id}/reviews', [ProductDetailController::class, 'storeReview'])
        ->name('products.reviews.store')
        ->middleware('auth');
});
