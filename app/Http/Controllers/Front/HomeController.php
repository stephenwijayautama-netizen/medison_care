<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use App\Models\News;
use Illuminate\Http\Request;
use App\Models\Product; // ⬅️ TAMBAH INI
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman dashboard/home utama setelah login.
     */
    public function index()
    {
        $user = Auth::user();
        $brands = Brands::all(); // ← Tambah ini
        $news = News::all();
        $products = Product::all(); // ⬅️ TAMBAH INI

        return view('home', compact('user', 'brands', "news", "products"));
    }
    
    public function profile()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }
}
