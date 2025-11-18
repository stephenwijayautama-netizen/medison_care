<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Alur View All Product
    public function index()
    {
        $product = Product::all();

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    public function getProduct($id){

    }
    public function create(){
        $credetials = $request->validate([
            ''
        ]);
    }
    public funtion update($id){

    }

    public functoion delete($id){
        
    }
}
