<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class SusuController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $query = Product::query();

        if ($request->has('category') && $request->category != '') {
            $categoryId = $request->category;
            $query->whereHas('category', function ($q) use ($categoryId) {
                $q->where('id', $categoryId);
            });
        }

        $products = $query->latest()->get();

        // 5. Kirim data ke View
        return view('susu', [
            'products' => $products,
            'categories' => $categories, // Ini menggantikan dummy data di Blade
            'currentCategory' => $request->category // Untuk menandai menu aktif
        ]);
    }
}