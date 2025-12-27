<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category; // ✅ Jangan lupa import Model Category

class PromoController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $products = Product::query()
            ->where('promo', true)
            ->orWhere(function ($query) {
                $query->whereNotNull('promo_price')
                      ->where('promo_price', '>', 0)
                      ->whereColumn('promo_price', '<', 'price');
            })
            ->latest()
            ->get();

        return view('promo', compact('products', 'categories'));
    }
}