<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class SusuController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil List Kategori untuk Menu Atas (Horizontal Scroll)
        // Kita ambil semua kategori, atau bisa difilter hanya kategori susu saja
        $categories = Category::all(); 
        
        // 2. Mulai Query Produk
        $query = Product::query();

        // 3. Logika Filter Kategori (Sesuai parameter ?category=... di URL)
        if ($request->has('category') && $request->category != '') {
            $categorySlug = $request->category;
            
            // Filter produk berdasarkan relasi category
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // 4. Urutkan Data (Opsional)
        // Kita urutkan berdasarkan terbaru, atau bisa berdasarkan nama
        // Catatan: Pemisahan Promo/Best Seller dilakukan di BLADE, jadi di sini cukup ambil data mentahnya.
        $products = $query->latest()->get();

        // 5. Kirim data ke View
        return view('susu', [
            'products' => $products,
            'categories' => $categories, // Ini menggantikan dummy data di Blade
            'currentCategory' => $request->category // Untuk menandai menu aktif
        ]);
    }
}