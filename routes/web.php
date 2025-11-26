<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Back\ProductController;

// Login
Route::get('/login', [AuthController::class, 'indexlogin'])->name('login');
Route::post('/doLogin', [AuthController::class, 'dologin'])->name('doLogin');

// Register
Route::get('/register', [AuthController::class, 'indexregister'])->name('register');
Route::post('/doRegister', [AuthController::class, 'doregister'])->name('doRegister');



Route::middleware('auth')->group(function (){
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
});

// Alur Back Office
// Alur CRUD Product
Route::get('/product', [ProductController::class, 'index'])->name('products');


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('views/forgot', function () {
    return view('forgot');
});

Route::get('views/metodepayment', function () {
    return view('metodepayment');
});
Route::get('views/order', function () {
    return view('order');
});
Route::get('views/change_password', function () {
    return view('change_password');
});