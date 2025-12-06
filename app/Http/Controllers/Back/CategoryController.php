<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // GET ALL CATEGORY
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    // GET CATEGORY BY ID
    public function getCategory($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'category not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $category
        ]);
    }

    // CREATE CATEGORY
    public function create(Request $request)
    {
        $credentials = $request->validate([
            'category_name'  => 'required|string|max:255',
            'description'    => 'nullable|string',
        ]);

        $category = Category::create($credentials);

        return response()->json([
            'success' => true,
            'data' => $category
        ]);
    }

    // UPDATE CATEGORY
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'category not found'], 404);
        }

        $credentials = $request->validate([
            'category_name'  => 'string|max:255',
            'description'    => 'nullable|string',
        ]);

        $category->update($credentials);

        return response()->json([
            'success' => true,
            'data' => $category
        ]);
    }

    // DELETE CATEGORY
    public function delete($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'category not found'], 404);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'category deleted'
        ]);
    }
}