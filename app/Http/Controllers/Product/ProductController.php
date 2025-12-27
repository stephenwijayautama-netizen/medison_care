<?php

namespace App\Http\Controllers; // ✅ Namespace standar (jangan pakai \Products kecuali file ada di dalam folder Products)

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller // ✅ Nama Class harus sama persis dengan Nama File
{
    public function index()
    {
        // Mengambil produk beserta relasi kategorinya (Eager Loading)
        $products = Product::with('category')->latest()->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'category_id'   => ['required', 'exists:categories,id'],
            'product_name'  => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string'],
            'price'         => ['required', 'numeric', 'min:0'],
            'stock'         => ['required', 'integer', 'min:0'],
            'promo_price'   => ['nullable', 'numeric', 'lt:price'],
            'image'         => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        // 2. Handle Upload Gambar
        $filename = null;
        if ($request->hasFile('image')) {
            $filename = uniqid() . '.' . $request->file('image')->extension();
            $request->file('image')->storeAs('products', $filename, 'public');
        }

        // 3. Simpan ke Database
        Product::create([
            'category_id'   => $request->category_id,
            'created_by'    => Auth::id(),
            'product_name'  => $request->product_name,
            'description'   => $request->description,
            'price'         => $request->price,
            'stock'         => $request->stock,
            'promo_price'   => $request->promo_price,
            'image'         => $filename,
            'promo'         => $request->has('promo'),
            'best_seller'   => $request->has('best_seller'),
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id'   => ['required', 'exists:categories,id'],
            'product_name'  => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string'],
            'price'         => ['required', 'numeric', 'min:0'],
            'stock'         => ['required', 'integer', 'min:0'],
            'promo_price'   => ['nullable', 'numeric', 'lt:price'],
            'image'         => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $data = [
            'category_id'   => $request->category_id,
            'product_name'  => $request->product_name,
            'description'   => $request->description,
            'price'         => $request->price,
            'stock'         => $request->stock,
            'promo_price'   => $request->promo_price,
            'promo'         => $request->has('promo'),
            'best_seller'   => $request->has('best_seller'),
        ];

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete('products/' . $product->image);
            }
            $filename = uniqid() . '.' . $request->file('image')->extension();
            $request->file('image')->storeAs('products', $filename, 'public');
            $data['image'] = $filename;
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete('products/' . $product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}