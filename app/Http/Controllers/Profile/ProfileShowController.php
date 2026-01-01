<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class ProfileShowController extends Controller
{
    public function show()
    {
        $user = Auth::user(); // ambil 1 baris dari tabel users (user login)
        return view('profile', compact('user'));
    }
}
