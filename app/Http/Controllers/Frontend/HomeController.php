<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\Models\About;
use App\Models\Post;
use App\Models\Product;
use App\Models\Service;
use App\Models\Team;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $stats = [
            'posts' => Post::where('status', 'active')->count(),
            'products' => Product::where('status', 'active')->count(),
            'users' => User::count(),
            'abouts'=>About::where('status', 'active')->get(),
            'services'=>Service::where('status', 1)->get(),
            'ourclients'=>\App\Models\OurClient::where('status', 1)->get(),
            'testimonials'=>Testimonial::where('status', 1)->get(),
        ];


        $abouts = About::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->get();

        // Buatkan untuk menampilkan team beserta divisinya
       $teams = Team::with('category')
            ->where('status', 1)
            ->orderBy('created_at', 'asc')
            ->get();

        $services = Service::where('status', 1)->orderBy('order')->get();

        $ourClients = \App\Models\OurClient::where('status', 1)
            ->orderBy('order', 'asc')
            ->get();

        $testimonials = Testimonial::where('status', 1)
            ->orderBy('order', 'asc')
            ->get();

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

        return view('frontend.pages.home', compact('stats', 'latestPosts', 'featuredProducts', 'featuredProducts', 'abouts', 'services', 'ourClients', 'testimonials', 'teams'));
    }
}
