<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\adminMiddleware;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;

Route::get('/', [homeController::class, 'showhome'])->name('homepage');

Route::middleware(['auth', AdminMiddleware::class])->group(function(){
    //admin profile
    Route::get('/adminprofile', [ProfileController::class, 'showProfileAdmin'])->name('adminprofile');
    Route::put('/adminprofile/{id}', [ProfileController::class, 'updateProfileAdmin'])->name('updateprofile');
    //users
    Route::get('/users', [UserController::class, 'showUsers'])->name('users');
    Route::get('/users/delete/{id}', [UserController::class, 'deleteUser'])->name('userdelete'); 
    //categories
    Route::get('/categories', [CategoryController::class, 'categoriesAdmin'])->name('categories');
    Route::post('/categories', [CategoryController::class, 'addCategory'])->name('categoriespost');
    Route::get('/categories/delete/{id}', [CategoryController::class, 'deleteCategory'])->name('categorydelete'); 
    Route::put('/categories/{id}', [CategoryController::class, 'updateCategory'])->name('categoryupdate'); 
    //products
    Route::get('/products',[ProductController::class, 'productsAdmin'])->name('products');
    Route::post('/products', [ProductController::class, 'addProduct'])->name('productspost');
    Route::get('/products/delete/{id}', [ProductController::class, 'deleteProduct'])->name('productdelete'); 
    Route::put('/products/{id}', [ProductController::class, 'updateProduct'])->name('productupdate');
    //orders
    Route::get('/orders', [OrderController::class, 'showOrdersAdmin'])->name('orders');
    Route::get('/orders/ship/{id}', [OrderController::class, 'shipOrder'])->name('ordership');
    Route::get('/orders/cancel/{id}', [OrderController::class, 'cancelOrder'])->name('ordercancel');
});

Route::middleware('guest')->group(function(){
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('loginpost');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('registerpost');
});

Route::middleware('auth')->group(function(){
    Route::post('/logout',[AuthController::class, 'logout'])->name('logout');
    Route::get('/logout',[AuthController::class, 'logout'])->name('logout');
});

