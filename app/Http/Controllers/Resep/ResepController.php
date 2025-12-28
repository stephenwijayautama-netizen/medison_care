<?php

namespace App\Http\Controllers\Resep;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResepController extends Controller
{
    /**
     * Simpan resep + gambar
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_resep' => 'required|string|max:255',
            'deskripsi'  => 'required|string',
            'gambar'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imageName = null;

        if ($request->hasFile('gambar')) {
            $imageName = time() . '_' . $request->file('gambar')->getClientOriginalName();

            // simpan ke storage/app/public/resep-images
            $request->file('gambar')->storeAs(
                'public/resep-images',
                $imageName
            );
        }

        // sementara return dulu (nanti tinggal masukin ke DB)
        return response()->json([
            'nama_resep' => $request->nama_resep,
            'deskripsi'  => $request->deskripsi,
            'gambar'     => $imageName
                ? asset('storage/resep-images/' . $imageName)
                : null,
        ]);
    }
}
