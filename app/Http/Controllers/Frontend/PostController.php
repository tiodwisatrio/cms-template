<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category'])
                     ->where('status', 'active')
                     ->latest();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        // Category filter
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        $posts = $query->paginate(9);
        
        // Get all categories that have active posts
        $categories = \App\Models\Category::whereHas('posts', function($query) {
            $query->where('status', 'active');
        })->get();
        
        return view('frontend.pages.blog.index', compact('posts', 'categories'));
    }

    public function show($slug)
    {
        $post = Post::with(['user', 'category'])
                   ->where('slug', $slug)
                   ->where('status', 'active')
                   ->firstOrFail();

        // Get related posts dari kategori yang sama
        $relatedPosts = Post::with(['user', 'category'])
                           ->where('category_id', $post->category_id)
                           ->where('id', '!=', $post->id)
                           ->where('status', 'active')
                           ->latest()
                           ->limit(3)
                           ->get();

        return view('frontend.pages.blog.show', compact('post', 'relatedPosts'));
    }
}