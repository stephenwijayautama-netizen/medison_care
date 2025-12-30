<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class PromoController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $categoryId = $request->query('category');
        $productsQuery = Product::query()
            ->where(function ($q) {
                $q->where('promo', true)
                  ->orWhere(function ($q2) {
                      $q2->whereNotNull('promo_price')
                         ->where('promo_price', '>', 0)
                         ->whereColumn('promo_price', '<', 'price');
                  });
            });

        if ($categoryId) {
            $productsQuery->whereHas('category', function ($q) use ($categoryId) {
                $q->where('id', $categoryId);
            });
        }

        $products = $productsQuery->latest()->get();

        return view('promo', compact('products', 'categories'));
    }
}