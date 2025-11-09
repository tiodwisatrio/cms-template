@extends('frontend.layouts.app')

@section('title', 'Home - ' . config('app.name'))

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-green-600 to-blue-600 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Welcome To CMS Gue</h1>
            <p class="text-xl opacity-90">Discover amazing products and services</p>
        </div>
    </div>
</div>

<!-- About Section -->
<section id="about" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">About Us</h2>
            <p class="text-gray-600">Learn more about our mission and values</p>
        </div>

        @if($abouts && $abouts->count() > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden md:flex md:items-stretch">
            {{-- Gambar di kiri --}}
            @if($abouts->first()->image)
            <div class="md:w-1/2 h-80 md:h-auto flex-shrink-0">
                <img src="{{ asset('storage/' . $abouts->first()->image) }}" 
                     alt="{{ $abouts->first()->title }}" 
                     class="w-full h-full object-cover rounded-t-lg md:rounded-l-lg md:rounded-tr-none">
            </div>
            @endif

            {{-- Konten di kanan --}}
            <div class="md:w-1/2 p-6 flex flex-col justify-center">
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">{{ $abouts->first()->title }}</h3>
                <p class="text-gray-700 leading-relaxed">{{ $abouts->first()->content }}</p>
            </div>
        </div>
        @else
        <div class="text-center py-12">
            <i data-lucide="info" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
            <p class="text-gray-600">About section is not available at the moment.</p>
        </div>
        @endif
    </div>
</section>

<!-- Services Section -->
<section id="services" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Services</h2>
            <p class="text-gray-600">Explore the services we offer to our customers</p>
        </div>

        @if($services && $services->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($services as $service)
            <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-lg transition-shadow">
                <!-- Ambil image service -->
                @if($service->image)
                    <div class="h-40 bg-gray-200 mb-4 flex items-center justify-center">
                        <img src="{{ asset('storage/' . $service->image) }}" 
                             alt="{{ $service->name }}" 
                             class="w-full h-full object-cover rounded-lg">
                    </div>
                @endif
                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $service->name }}</h3>
                <p class="text-gray-600">{{ Str::limit($service->description, 120) }}</p>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <i data-lucide="settings" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
            <p class="text-gray-600">No services available at the moment.</p>
        </div>
        @endif
    </div>
</section>



<!-- Latest Posts Section -->
<section id="blog" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Latest Articles</h2>
            <p class="text-gray-600">Stay updated with our latest blog posts</p>
        </div>
        
        @if($latestPosts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($latestPosts as $post)
            <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" 
                             alt="{{ $post->title }}" 
                             class="w-full h-full object-cover">
                    @else
                        <i data-lucide="image" class="w-12 h-12 text-gray-400"></i>
                    @endif
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-2">
                        @if($post->category)
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                {{ $post->category->name }}
                            </span>
                        @endif
                        <span class="text-gray-500 text-sm ml-auto">
                            {{ $post->created_at->format('M d, Y') }}
                        </span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $post->title }}</h3>
                    <p class="text-gray-600 mb-4">{{ Str::limit($post->description, 100) }}</p>
                    <a href="{{ route('frontend.blog.show', $post) }}" class="text-blue-600 font-medium hover:text-blue-700">
                        Read More →
                    </a>
                </div>
            </article>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <i data-lucide="file-text" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
            <p class="text-gray-600">No articles published yet.</p>
        </div>
        @endif
    </div>
</section>

<!-- Featured Products Section -->
<section id="products" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Featured Products</h2>
            <p class="text-gray-600">Discover our most popular products</p>
        </div>
        
        @if($featuredProducts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            @foreach($featuredProducts as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="h-48 bg-gray-200 flex items-center justify-center">
                    @if($product->featured_image)
                        <img src="{{ asset('storage/' . $product->featured_image) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover">
                    @else
                        <i data-lucide="package" class="w-12 h-12 text-gray-400"></i>
                    @endif
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-2">
                        @if($product->category)
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">
                                {{ $product->category->name }}
                            </span>
                        @endif
                        <i data-lucide="star" class="w-4 h-4 text-yellow-500 ml-auto"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($product->description, 80) }}</p>
                    <div class="flex items-center justify-between">
                        <div>
                            @if($product->sale_price)
                                <span class="text-lg font-bold text-green-600">{{ $product->formatted_sale_price }}</span>
                                <span class="text-sm text-gray-500 line-through ml-1">{{ $product->formatted_price }}</span>
                            @else
                                <span class="text-lg font-bold text-gray-900">{{ $product->formatted_price }}</span>
                            @endif
                        </div>
                        <a href="{{ route('frontend.products.show', $product) }}" class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                            View
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <i data-lucide="package" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
            <p class="text-gray-600">No featured products available.</p>
        </div>
        @endif
    </div>
</section>

<!-- Buatkan section slider dengan style minimalist, smooth, clean, and modern untuk our client, hanya mengambil gambar nya saja, harus rapih -->
<section id="our-clients" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Clients</h2>
            <p class="text-gray-600">Trusted by these amazing companies</p>
        </div>

        @if($ourClients && $ourClients->count() > 0)
        <div class="flex items-center justify-center space-x-8 overflow-x-auto py-4">
            @foreach($ourClients as $client)
            <div class="flex-shrink-0 w-32 h-32 flex items-center justify-center bg-white rounded-lg shadow-md p-4">
                @if($client->image)
                    <img src="{{ asset('storage/' . $client->image) }}" 
                         alt="{{ $client->name }}" 
                         class="max-w-full max-h-full object-contain">
                @else
                    <i data-lucide="users" class="w-12 h-12 text-gray-400"></i>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <i data-lucide="users" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
            <p class="text-gray-600">No clients to display at the moment.</p>
        </div>
        @endif
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-4">Ready to Get Started?</h2>
        <p class="text-xl text-gray-300 mb-8">Join us and explore amazing content and products</p>
        <a href="{{ route('dashboard') }}" 
           class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700">
            Go to Dashboard
        </a>
    </div>
</section>
@endsection