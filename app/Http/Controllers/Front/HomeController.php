<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use App\Models\News;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('product_name', 'like', '%' . $request->search . '%');
        }

        $product = $query->whereNull('deleted_at')->get();

        $brands = Brands::all();
        // dd($brands->);
        return view('home', [
            'user'     => Auth::user(),
            'brands'   => $brands,
            'products'=> $product,
            'news'    => News::latest()->take(6)->get(),
        ]);
    }

    public function searchProduct(Request $request)
    {
        $search = $request->get('q');

        if (!$search) {
            return response()->json([]);
        }

        $products = Product::where('product_name', 'like', "%{$search}%")
            ->whereNull('deleted_at')
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
