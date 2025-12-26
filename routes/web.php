<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Back\ProductController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Profile\ChangeProfileController;
use App\Http\Controllers\Brands\BrandsController;
use App\Http\Controllers\Product\BController;

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
Route::middleware('auth')->group(function () {
    Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductsController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductsController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductsController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductsController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductsController::class, 'destroy'])->name('products.destroy');
});


    // LOGOUT
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/brands', [BrandsController::class, 'index'])->name('brands.index');
    Route::get('/brands/create', [BrandsController::class, 'create'])->name('brands.create');
    Route::post('/brands', [BrandsController::class, 'store'])->name('brands.store');
    Route::get('/brands/{brand}/edit', [BrandsController::class, 'edit'])->name('brands.edit');
    Route::put('/brands/{brand}', [BrandsController::class, 'update'])->name('brands.update');
    Route::delete('/brands/{brand}', [BrandsController::class, 'destroy'])->name('brands.destroy');
});
//susu
// Ubah dari index menjadi susuPage
Route::get('views/Susu', [HomeController::class, 'susuPage']);
/*
|--------------------------------------------------------------------------
| STATIC VIEWS (OPSIONAL)
|--------------------------------------------------------------------------
*/
Route::view('views/forgot', 'forgot');
Route::view('views/metodepayment', 'metodepayment');
Route::view('views/order', 'order');
Route::view('views/change_password', 'change_password');
Route::view('views/unggah_file', 'unggah_file');

