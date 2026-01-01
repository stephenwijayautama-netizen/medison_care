<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * TAMPILKAN HALAMAN PROFILE
     */
    public function index()
    {
        $user = Auth::user();

        // ambil alamat TERBARU yang tidak null
        $lokasi = Lokasi::where('user_id', $user->id)
            ->whereNotNull('alamat')
            ->latest()
            ->first();

        return view('profile', compact('user', 'lokasi'));
    }

    /**
     * UPLOAD FOTO PROFILE
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file_input' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('file_input')) {

            // hapus foto lama jika ada
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
