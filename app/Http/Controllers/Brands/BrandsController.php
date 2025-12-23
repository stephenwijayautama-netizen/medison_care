<?php

namespace App\Http\Controllers\Brands;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandsController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return view('brands', compact('brands'));
    }

    public function create()
    {
        return view('brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $filename = uniqid() . '.' . $request->file('image')->extension();

        $request->file('image')->storeAs('brands', $filename, 'public');

        Brand::create([
            'name' => $request->name,
            'image' => $filename,
        ]);

        return redirect()->route('brands.index')->with('success', 'Brand berhasil ditambahkan!');
    }

    public function edit(Brand $brand)
    {
        return view('brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            if ($brand->image) {
                Storage::disk('public')->delete('brands/' . $brand->image);
            }

            $filename = uniqid() . '.' . $request->file('image')->extension();
            $request->file('image')->storeAs('brands', $filename, 'public');
            $brand->image = $filename;
        }

        $brand->name = $request->name;
        $brand->save();

        return redirect()->route('brands.index')->with('success', 'Brand berhasil diupdate!');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->image) {
            Storage::disk('public')->delete('brands/' . $brand->image);
        }

        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Brand berhasil dihapus!');
    }
}
