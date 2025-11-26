<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller; // Pastikan Anda meng-extend Controller dasar
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
        return view('home', compact('user'));
    }

    public function profile(){
        $user = Auth::user();
        return view('profile');
    }
}