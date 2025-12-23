<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Back\ProductController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Profile\ChangeProfileController;
use App\Http\Controllers\Brands\BrandsController;

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
    Route::get('/change-password', [ChangeProfileController::class, 'index'])
        ->name('change-password.form');

    // CHANGE PASSWORD SUBMIT
    Route::post('/change-password', [ChangeProfileController::class, 'changePassword'])
        ->name('change-password.submit');

    // PRODUCT
    Route::get('/product', [ProductController::class, 'index'])->name('products');

    // LOGOUT
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/brands', [BrandsController::class, 'index'])->name('brands.index');
    Route::get('/brands/create', [BrandsController::class, 'create'])->name('brands.create');
    Route::post('/brands', [BrandsController::class, 'store'])->name('brands.store');
    Route::get('/brands/{brand}/edit', [BrandsController::class, 'edit'])->name('brands.edit');
    Route::put('/brands/{brand}', [BrandsController::class, 'update'])->name('brands.update');
    Route::delete('/brands/{brand}', [BrandsController::class, 'destroy'])->name('brands.destroy');
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
