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
use App\Http\Controllers\UserProfileController;

Route::get('/', [homeController::class, 'showhome'])->name('homepage');
Route::get('/product', [homeController::class, 'showProducts'])->name('products');

Route::get('/', [homeController::class, 'index'])->name('homepage');

Route::middleware(['auth', AdminMiddleware::class])->group(function(){
    //admin profile
    Route::get('/adminprofile', [ProfileController::class, 'showProfileAdmin'])->name('adminprofile');
    Route::put('/adminprofile/{id}', [ProfileController::class, 'updateProfile'])->name('updateprofile');
    //users
    Route::get('/users', [UserController::class, 'showUsers'])->name('users');
    Route::get('/users/delete/{id}', [UserController::class, 'deleteUser'])->name('userdelete'); 
    //categories
    Route::get('/categoriesAdmin', [CategoryController::class, 'categoriesAdmin'])->name('categories');
    Route::post('/categoriesAdmin', [CategoryController::class, 'addCategory'])->name('categoriespost');
    Route::get('/categoriesAdmin/delete/{id}', [CategoryController::class, 'deleteCategory'])->name('categorydelete'); 
    Route::put('/categoriesAdmin/{id}', [CategoryController::class, 'updateCategory'])->name('categoryupdate'); 
    //products
    Route::get('/productsAdmin',[ProductController::class, 'productsAdmin'])->name('products');
    Route::post('/productsAdmin', [ProductController::class, 'addProduct'])->name('productspost');
    Route::get('/productsAdmin/delete/{id}', [ProductController::class, 'deleteProduct'])->name('productdelete'); 
    Route::put('/productsAdmin/{id}', [ProductController::class, 'updateProduct'])->name('productupdate');
    //orders
    Route::get('/ordersAdmin', [OrderController::class, 'showOrdersAdmin'])->name('orders');
    Route::get('/ordersAdmin/ship/{id}', [OrderController::class, 'shipOrder'])->name('ordership');
    Route::get('/ordersAdmin/cancel/{id}', [OrderController::class, 'cancelOrder'])->name('ordercancel');
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

//pour la modification du profile de l'utilisateur
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserProfileController::class, 'showUser'])->name('user.profile');
    Route::put('/profile', [UserProfileController::class, 'updateUser'])->name('user.update');
});

