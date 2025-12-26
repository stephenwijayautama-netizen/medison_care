<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use App\Models\News;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman home utama
     */
    public function index()
    {
        $user     = Auth::user();
        $brands  = Brands::all();
        $products = Product::all();

        // NEWS (ambil terbaru, biar enak di home)
        $news = News::latest()->get();
        // kalau mau dibatasi:
        // $news = News::latest()->take(6)->get();

        return view('home', compact(
            'user',
            'brands',
            'news',
            'products'
        ));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function susuPage()
    {
        $products = Product::all();
        return view('Susu', compact('products'));
    }
}
