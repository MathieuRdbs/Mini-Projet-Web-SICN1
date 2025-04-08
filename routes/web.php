<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\adminMiddleware;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\CartController;


Route::get('/', [homeController::class, 'index'])->name('homepage');

Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    //admin profile
    Route::get('/adminprofile', [AdminProfileController::class, 'showProfileAdmin'])->name('adminprofile');
    Route::put('/adminprofile/{id}', [AdminProfileController::class, 'updateProfile'])->name('updateprofile');
    //users
    Route::get('/users', [UserController::class, 'showUsers'])->name('users');
    Route::get('/users/delete/{id}', [UserController::class, 'deleteUser'])->name('userdelete');
    //categories
    Route::get('/categoriesAdmin', [CategoryController::class, 'categoriesAdmin'])->name('categories');
    Route::post('/categoriesAdmin', [CategoryController::class, 'addCategory'])->name('categoriespost');
    Route::get('/categoriesAdmin/delete/{id}', [CategoryController::class, 'deleteCategory'])->name('categorydelete');
    Route::put('/categoriesAdmin/{id}', [CategoryController::class, 'updateCategory'])->name('categoryupdate');
    //products
    Route::get('/productsAdmin', [ProductController::class, 'productsAdmin'])->name('productsAdmin');
    Route::post('/productsAdmin', [ProductController::class, 'addProduct'])->name('productspost');
    Route::get('/productsAdmin/delete/{id}', [ProductController::class, 'deleteProduct'])->name('productdelete');
    Route::put('/productsAdmin/{id}', [ProductController::class, 'updateProduct'])->name('productupdate');
    //orders
    Route::get('/ordersAdmin', [OrderController::class, 'showOrdersAdmin'])->name('orders');
    Route::get('/ordersAdmin/ship/{id}', [OrderController::class, 'shipOrder'])->name('ordership');
    Route::get('/ordersAdmin/cancel/{id}', [OrderController::class, 'cancelOrder'])->name('ordercancel');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('loginpost');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('registerpost');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/product/{id}', [ProductController::class, 'showProductDetails'])->name('product.showDetails');
    Route::get('/buy', [ProductController::class, 'Buy'])->name('buy');
    Route::get('/profile', [UserProfileController::class, 'showUser'])->name('user.profile');
    Route::put('/profile', [UserProfileController::class, 'updateUser'])->name('user.update');
    Route::get('/product', [homeController::class, 'showProducts'])->name('products');
    Route::get('/cart', [CartController::class, 'showCart'])->name('cart');
    Route::post('/cartcash', [CartController::class, 'cashpayement'])->name('cash');
    Route::get('/payment/card', [CartController::class, 'showCardPaymentPage'])->name('custom.payment.page');
    Route::post('/payment/process-card', [CartController::class, 'processCardPayment'])->name('process.card.payment');
    Route::get('/ordersUser', [OrderController::class, 'showOrderUser'])->name('orderUser');
    Route::get('/orders/cancel/{id}', [OrderController::class, 'cancelOrder'])->name('ordercanceluser');
});

