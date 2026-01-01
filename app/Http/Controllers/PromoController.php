<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class PromoController extends Controller
{
    public function index(Request $request)
    {
        // BASE QUERY
        $productsQuery = Product::query()

            // PROMO SAJA
            ->where(function ($q) {
                $q->where('promo', true)
                  ->orWhere(function ($q2) {
                      $q2->whereNotNull('promo_price')
                         ->where('promo_price', '>', 0)
                         ->whereColumn('promo_price', '<', 'price');
                  });
            });

        // SEARCH (JALAN JIKA ADA)
        if ($request->filled('search')) {
            $productsQuery->where(
                'product_name',
                'like',
                '%' . $request->search . '%'
            );
        }

        // CATEGORY (JALAN JIKA ADA)
        if ($request->filled('category')) {
            $productsQuery->whereHas('category', function ($q) use ($request) {
                $q->where('id', $request->category);
            });
        }

        // DATA
        $products   = $productsQuery->latest()->get();
        $categories = Category::all();

        return view('promo', compact('products', 'categories'));
    }

    public function searchProduct(Request $request)
    {
        $search = $request->get('q');

        if (!$search) {
            return response()->json([]);
        }

        return Product::where('product_name', 'like', "%{$search}%")
            ->whereNull('deleted_at')
            ->limit(5)
            ->get(['id', 'product_name', 'slug']);
    }
}
