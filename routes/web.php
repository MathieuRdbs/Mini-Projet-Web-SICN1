<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homeController;
use App\Http\Controllers\AdminController;

Route::get('/', [homeController::class, 'showhome'])->name('homepage');

Route::get('/admindash', [AdminController::class, 'showdashboard'])->name('dashboard');
Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
Route::post('/categories', [AdminController::class, 'addCategory'])->name('categoriespost');
Route::get('/categories/delete/{id}', [AdminController::class, 'deleteCategory'])->name('categorydelete');

Route::middleware('guest')->group(function(){
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('loginpost');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('registerpost');
});

Route::middleware('auth')->group(function(){
    Route::post('/logout',[AuthController::class, 'logout'])->name('logout');
});

