<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Back\ProductController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Profile\ChangeController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'indexlogin'])->name('login');
Route::post('/doLogin', [AuthController::class, 'dologin'])->name('doLogin');

Route::get('/register', [AuthController::class, 'indexregister'])->name('register');
Route::post('/doRegister', [AuthController::class, 'doregister'])->name('doRegister');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED AREA
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // HOME
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // PROFILE PAGE
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    // UPLOAD FOTO PROFILE
    Route::post('/profile/upload', [ProfileController::class, 'uploadImage'])
        ->name('profile.upload');

    // CHANGE PASSWORD FORM
    Route::get('/change-password', [ChangeController::class, 'index'])
        ->name('change-password.form');

    // CHANGE PASSWORD SUBMIT
    Route::post('/change-password', [ChangeController::class, 'changePassword'])
        ->name('change-password.submit');

    // PRODUCT
    Route::get('/product', [ProductController::class, 'index'])->name('products');

    // LOGOUT
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| STATIC VIEWS (OPSIONAL)
|--------------------------------------------------------------------------
*/
Route::view('views/forgot', 'forgot');
Route::view('views/metodepayment', 'metodepayment');
Route::view('views/order', 'order');
Route::view('views/change_password', 'change_password');
