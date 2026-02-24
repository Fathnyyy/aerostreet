<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::with(['category', 'sizes'])->where('slug', $slug)->firstOrFail();

        // Load approved reviews dengan foto dan user
        $reviews = Review::where('product_id', $product->id)
                    ->where('status', 'approved')
                    ->with('user')
                    ->latest()
                    ->paginate(5);

        // Rating summary
        $ratingCounts = Review::where('product_id', $product->id)
                    ->where('status', 'approved')
                    ->selectRaw('rating, count(*) as count')
                    ->groupBy('rating')
                    ->pluck('count', 'rating')
                    ->toArray();

        $totalReviews = array_sum($ratingCounts);
        $avgRating = $totalReviews > 0
            ? round(collect($ratingCounts)->map(fn($c, $r) => $r * $c)->sum() / $totalReviews, 1)
            : 0;

        return view('product-detail', compact('product', 'reviews', 'ratingCounts', 'avgRating', 'totalReviews'));
    }
}
