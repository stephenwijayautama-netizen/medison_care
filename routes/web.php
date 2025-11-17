<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('views/home', function () {
    return view('home');
});
Route::get('views/login', function () {
    return view('Login');
});
Route::get('views/register', function () {
    return view('register');
});
Route::get('views/forgot', function () {
    return view('forgot');
});
Route::get('views/profile', function () {
    return view('profile');
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