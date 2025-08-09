
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
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
use App\Http\Controllers\NewsController;

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

// Giới thiệu, liên hệ
Route::get('/gioi-thieu', [HomeController::class, 'about'])->name('about');
Route::get('/lien-he', [ContactController::class, 'show'])->name('contact.show');
Route::post('/lien-he', [ContactController::class, 'submit'])->name('contact.submit');

// Jewelry route (danh mục sản phẩm)
Route::get('/jewelry/{id}', [JewelryController::class, 'showByCategory'])->name('jewelry.category');

// Detail product route (public)
Route::get('/detail/{id}', [ProductDetailController::class, 'show'])->name('jewelry.detail');

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

    // Thanh toán
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');

    // =============================
    // Admin routes (nên thêm middleware kiểm tra role admin)
    // =============================
    Route::prefix('admin')->name('admin.')->group(function () {
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
    });

    // =============================
    // Profile routes
    // =============================
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/{id}', [UserProfileController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [UserProfileController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserProfileController::class, 'update'])->name('update');
    });

    // =============================
    // Cart routes
    // =============================
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'show'])->name('show');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::post('/update', [CartController::class, 'update'])->name('update');
        Route::post('/remove', [CartController::class, 'remove'])->name('remove');
        Route::post('/clear', [CartController::class, 'clear'])->name('clear');
        Route::get('/count', [CartController::class, 'getCartCount'])->name('count');
    });

    // =============================
    // Sản phẩm, tin tức
    // =============================
    Route::get('/products/all', [ProductController::class, 'showAll'])->name('products.all');
    Route::get('/tin-tuc', [NewsController::class, 'index'])->name('news.index');
});
