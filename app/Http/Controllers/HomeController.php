<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->where('status', 'active')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('brand', 'like', "%{$search}%");
                });
            })
            ->when($request->category, function ($query, $category) {
                $query->whereHas('category', function ($q) use ($category) {
                    $q->where('slug', $category);
                });
            })
            ->when($request->brand, function ($query, $brand) {
                $query->where('brand', 'like', $brand);
            })
            ->latest()
            ->paginate(12);

        $categories = Category::all();
        $brands = Product::where('status', 'active')->select('brand')->distinct()->pluck('brand');

        return view('welcome', compact('products', 'categories', 'brands'));
    }
}