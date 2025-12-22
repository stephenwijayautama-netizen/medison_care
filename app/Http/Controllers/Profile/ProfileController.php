<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; 

class ProfileController extends Controller
{
    public function index()
{
    return view('profile'); // sesuaikan nama blade kamu
}
    public function uploadImage(Request $request)
{
    $request->validate([
        'file_input' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user = Auth::user();

    if ($request->hasFile('file_input')) {

        // optional: hapus foto lama
        if ($user->image) {
            Storage::disk('public')->delete('profile_images/' . $user->image);
        }

        $filename = uniqid() . '.' . $request->file('file_input')->extension();

        $request->file('file_input')
            ->storeAs('profile_images', $filename, 'public');

        $user->image = $filename;
        $user->save();
    }

    return back()->with('success', 'Profile image updated!');
}
}
