<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::with(['category', 'sizes'])->where('slug', $slug)->firstOrFail();
        return view('product-detail', compact('product'));
    }
}
