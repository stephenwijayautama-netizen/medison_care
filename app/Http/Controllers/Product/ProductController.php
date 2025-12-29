<?php

namespace App\Http\Controllers\Brands;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandsController extends Controller
{
    /**
     * Menampilkan daftar semua brand
     */
    public function index()
    {
        $brands = Brand::all();
        return view('brands.index', compact('brands'));
    }

    /**
     * Menampilkan form untuk membuat brand baru
     */
    public function create()
    {
        return view('brands.create');
    }

    /**
     * Menyimpan brand baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:50'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Generate nama file unik
        $filename = uniqid() . '.' . $request->file('image')->extension();

        // Simpan ke storage/app/public/brands
        $request->file('image')->storeAs('brands', $filename, 'public');

        Brand::create([
            'name'  => $request->name,
            'image' => $filename,
        ]);

        return redirect()->route('brands.index')
            ->with('success', 'Brand berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit brand
     */
    public function edit(Brand $brand)
    {
        return view('brands.edit', compact('brand'));
    }

    /**
     * Mengupdate data brand
     */
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:50'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Update image jika ada
        if ($request->hasFile('image')) {
            if ($brand->image) {
                Storage::disk('public')->delete('brands/' . $brand->image);
            }

            $filename = uniqid() . '.' . $request->file('image')->extension();
            $request->file('image')->storeAs('brands', $filename, 'public');
            $brand->image = $filename;
        }

        // Update data lain
        $brand->name = $request->name;
        $brand->save();

        return redirect()->route('brands.index')
            ->with('success', 'Brand berhasil diupdate!');
    }

    /**
     * Menghapus brand
     */
    public function destroy(Brand $brand)
    {
        if ($brand->image) {
            Storage::disk('public')->delete('brands/' . $brand->image);
        }

        $brand->delete();

        return redirect()->route('brands.index')
            ->with('success', 'Brand berhasil dihapus!');
    }
}
