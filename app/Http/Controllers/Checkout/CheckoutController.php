<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class CheckoutController extends Controller
{
    /**
     * Menampilkan Halaman Susu (Mengacu pada SusuController Anda)
     */
    public function susu(Request $request)
    {
        // 1. Ambil semua kategori untuk menu filter
        $categories = Category::all();

        // 2. Gunakan logic yang sama dengan SusuController Anda
        $productsQuery = Product::query();

        // Filter Search (Sama dengan SusuController)
        if ($request->filled('search')) {
            $productsQuery->where('product_name', 'like', '%' . $request->search . '%');
        }

        // Filter Category (Sama dengan SusuController)
        if ($request->filled('category')) {
            $productsQuery->whereHas('category', function ($q) use ($request) {
                $q->where('id', $request->category);
            });
        }

        // 3. Tambahan: Filter untuk produk Susu saja (Reguler/Bukan Promo)
        // Agar tidak duplikat dengan halaman Promo
        $products = $productsQuery->latest()
            ->get()
            ->reject(fn($item) => 
                $item->promo || ($item->promo_price > 0 && $item->promo_price < $item->price)
            );

        return view('susu', [
            'products'   => $products,
            'categories' => $categories,
        ]);
    }

    /**
     * Menampilkan Halaman Promo
     */
    public function promo(Request $request)
    {
        $categories = Category::all();
        
        // Hanya ambil produk yang memiliki harga promo aktif
        $products = Product::where(function($query) {
                $query->where('promo', true)
                      ->orWhereColumn('promo_price', '<', 'price');
            })
            ->where('promo_price', '>', 0)
            ->when($request->category, fn($q, $id) => $q->where('category_id', $id))
            ->latest()
            ->get();

        return view('promo', compact('categories', 'products'));
    }

    /**
     * Simpan Pilihan (Store)
     */
    public function store(Request $request)
    {
        $cartData = json_decode($request->cart, true);

        if (!$cartData || count($cartData) === 0) {
            return redirect()->back()->with('error', 'Pilih produk terlebih dahulu.');
        }

        session(['checkout_data' => $cartData]);
        return redirect()->route('konfirmasi_pembayaran');
    }

    /**
     * Konfirmasi Pembayaran
     */
    public function konfirmasi()
    {
        $cart = session('checkout_data', []);
        if (empty($cart)) return redirect()->route('susu');

        $products = Product::whereIn('id', array_keys($cart))->get();
        return view('konfirmasi_pembayaran', compact('products', 'cart'));
    }
}