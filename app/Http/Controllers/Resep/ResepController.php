<?php

namespace App\Http\Controllers\Resep;

use App\Http\Controllers\Controller;
use App\Models\Resep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResepController extends Controller
{
    public function index()
    {
        $reseps = Resep::all();
        return view('resep', compact('reseps'));
    }

    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'nama_resep' => 'required|string|max:255',
            'catatan_tambahan' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validasi file gambar
        ]);

        // 2. Proses upload gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Simpan ke folder 'public/reseps' sesuai konfigurasi Filament kamu
            $imagePath = $request->file('image')->store('reseps', 'public');
        }

        // 3. Simpan data ke Database
        Resep::create([
            'nama_resep' => $request->nama_resep,
            'catatan_tambahan' => $request->catatan_tambahan,
            'image_product' => $imagePath, // Pastikan nama kolom di DB adalah 'image_product'
        ]);

        // 4. Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Resep berhasil ditambahkan ke database!');
    }
}