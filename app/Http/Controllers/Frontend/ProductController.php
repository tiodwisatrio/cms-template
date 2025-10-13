<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['user', 'category'])
                        ->where('status', 'active')
                        ->latest();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Category filter
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Price filter
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price', '<=', $request->max_price);
        }

        // Sort options
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name':
                    $query->orderBy('name', 'asc');
                    break;
                default:
                    $query->latest();
            }
        }

        $products = $query->paginate(12);
        
        // Get all categories that have active products
        $categories = Category::whereHas('products', function($query) {
            $query->where('status', 'active');
        })->get();
        
        return view('frontend.pages.products.index', compact('products', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::with(['user', 'category'])
                          ->where('slug', $slug)
                          ->where('status', 'active')
                          ->firstOrFail();

        // Get related products dari kategori yang sama
        $relatedProducts = Product::with(['user', 'category'])
                                  ->where('category_id', $product->category_id)
                                  ->where('id', '!=', $product->id)
                                  ->where('status', 'active')
                                  ->latest()
                                  ->limit(4)
                                  ->get();

        return view('frontend.pages.products.show', compact('product', 'relatedProducts'));
    }
}