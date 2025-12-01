<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // GET ALL PRODUCTS
    public function index()
    {
        $product = Product::all();

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    // GET PRODUCT BY ID
    public function getProduct($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'product not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    // CREATE PRODUCT
    public function create(Request $request)
    {
        $credentials = $request->validate([
            'category_id'   => 'required|integer',
            'created_by'    => 'required|integer',
            'product_name'  => 'required|string|max:255',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric',
            'stock'         => 'required|integer',
            'image'         => 'nullable|string',
        ]);

        $product = Product::create($credentials);

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    // UPDATE PRODUCT
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'product not found'], 404);
        }

        $credentials = $request->validate([
            'category_id'   => 'integer',
            'created_by'    => 'integer',
            'product_name'  => 'string|max:255',
            'description'   => 'nullable|string',
            'price'         => 'numeric',
            'stock'         => 'integer',
            'image'         => 'nullable|string',
        ]);

        $product->update($credentials);

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    // DELETE PRODUCT
    public function delete($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'product not found'], 404);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'product deleted'
        ]);
    }
}
