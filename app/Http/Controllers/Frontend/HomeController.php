<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $stats = [
            'posts' => Post::where('status', 'active')->count(),
            'products' => Product::where('status', 'active')->count(),
            'users' => User::count(),
        ];

        $latestPosts = Post::with(['category', 'user'])
            ->where('status', 'active')
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $featuredProducts = Product::with('category')
            ->where('status', 'active')
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('frontend.pages.home', compact('stats', 'latestPosts', 'featuredProducts', 'featuredProducts'));
    }
}
