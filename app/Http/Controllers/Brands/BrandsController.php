<?php

namespace App\Http\Controllers\Brands;

use App\Http\Controllers\Controller;
use App\Models\Brands;

class BrandsController extends Controller
{
    public function index()
    {
        $brands = Brand::all(); // Huruf besar, sesuai model
        return view('brands.index', compact('brands'));
    }
}
