<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use App\Models\News;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $brands = Brands::all();
        // dd($brands->);
        return view('home', [
            'user'     => Auth::user(),
            'brands'   => $brands,
            'products'=> Product::latest()->get(),
            'news'    => News::latest()->take(6)->get(),
        ]);
    }

    public function profile()
    {
        return view('profile', [
            'user' => Auth::user()
        ]);
    }

    public function susuPage()
    {
        return view('Susu', [
            'products' => Product::latest()->get()
        ]);
    }
}
