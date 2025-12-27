<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => ['required','string' , 'max:20'],
            'description' => ['required', 'string','max:455'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $filename = uniqid() . '.' . $request->file('image')->extension();
        $request->file('image')->storeAs('products', $filename, 'public');

        Product::create([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'image' => $filename,
        ]);

        return redirect()->route('products.index')->with('success', 'Product berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => ['required','string' , 'max:20'],
            'description' => ['required', 'string','max:20'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete('products/' . $product->image);
            }

            $filename = uniqid() . '.' . $request->file('image')->extension();
            $request->file('image')->storeAs('products', $filename, 'public');
            $product->image = $filename;
        }

        $product->name = $request->name;
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product berhasil diupdate!');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete('products/' . $product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product berhasil dihapus!');
    }
}
