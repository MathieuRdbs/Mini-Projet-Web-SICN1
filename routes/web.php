<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homeController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\adminMiddleware;
use App\Http\Controllers\CategoryController;

Route::get('/', [homeController::class, 'showhome'])->name('homepage');

Route::middleware(['auth', AdminMiddleware::class])->group(function(){
    Route::get('/admindash', [AdminController::class, 'showdashboard'])->name('users');
    Route::get('/categories', [CategoryController::class, 'categories'])->name('categories');
    Route::post('/categories', [CategoryController::class, 'addCategory'])->name('categoriespost');
    Route::get('/categories/delete/{id}', [CategoryController::class, 'deleteCategory'])->name('categorydelete'); 
    Route::put('/categories/{id}', [CategoryController::class, 'updateCategory'])->name('categoryupdate'); 
});

Route::middleware('guest')->group(function(){
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('loginpost');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('registerpost');
});

Route::middleware('auth')->group(function(){
    Route::post('/logout',[AuthController::class, 'logout'])->name('logout');
});

