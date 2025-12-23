<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use Illuminate\Http\Request;
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
        return view('home', compact('user', 'brands'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }
}
