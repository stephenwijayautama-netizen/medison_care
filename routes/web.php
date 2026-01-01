<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Back\ProductController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Profile\ChangeProfileController;
use App\Http\Controllers\SusuController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\PaymentResultController;
use App\Http\Controllers\Brands\BrandsController;
// Tambahan Import untuk News
use App\Http\Controllers\NewsController; 
use App\Http\Controllers\Resep\ResepController;
use App\Http\Controllers\Lokasi\LokasiController;


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
    Route::get('/payment-result/{id}', [PaymentResultController::class, 'show'])
    ->name('payment.result');

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
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // BRANDS
    Route::middleware('auth')->group(function () {
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
});
    // --- NEWS ---
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news/store', [NewsController::class, 'store'])->name('news.store');
    Route::get('/news/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::put('/news/{news}', [NewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{news}', [NewsController::class, 'destroy'])->name('news.destroy');
    // ----------

    // LOGOUT
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
  
    Route::post('/resep', [ResepController::class, 'store'])->name('resep.store');
});

// SUSU
Route::get('susu', [HomeController::class, 'susuPage']);

Route::middleware('auth')->group(function () {
    Route::post('/lokasi/store', [LokasiController::class, 'store'])
        ->name('lokasi.store');
});


// Tambahkan ->name('susu.index') di akhir
Route::get('/susu', [SusuController::class, 'index'])->name('susu.index');
Route::get('/promo', [PromoController::class, 'index'])->name('promo.index');
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
Route::view('views/konsultasi', 'konsultasi');
Route::view('views/percobaaan', 'percobaaan');