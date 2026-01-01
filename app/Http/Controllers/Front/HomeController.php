<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use App\Models\News;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::when($request->filled('search'), function ($query) use ($request) {
                $query->where('product_name', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->get();

        return view('home', [
            'user'     => Auth::user(),
            'brands'   => Brands::all(),
            'products' => $products,
            'news'     => News::latest()->take(6)->get(),
        ]);
    }

    public function searchProduct(Request $request)
    {
        $search = $request->get('q');

        if (!$search) {
            return response()->json([]);
        }

        $products = Product::where('product_name', 'like', "%{$search}%")
            ->limit(5)
            ->get(['id', 'product_name', 'slug']);

        return response()->json($products);
    }

    public function profile()
    {
        return view('profile', [
            'user' => Auth::user()
        ]);
    }
}
