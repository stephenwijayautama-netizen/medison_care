<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangeProfileController extends Controller
{
      public function index(){
        return view('Change');
    }
    public function ChangePassword(Request $request){
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required' ,'min:8' ,'confirmed'],
        ]);
        // dd($request->all());
    $user = Auth::user();

        // cek password lama benar atau tidak
     if (!Hash::check($request->current_password, $user->password)) {
    return back()->withErrors(['current_password' => 'Password lama salah.']);
        };
    $user->password = Hash::make($request->password);
    $user->save();

    return back()->with('success','password berhasil diubah !');
    }
}
