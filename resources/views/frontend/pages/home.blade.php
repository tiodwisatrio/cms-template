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
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300 flex flex-col">
                <div class="h-48 bg-gray-100 flex items-center justify-center relative">
                    @if($product->featured_image)
                        <img src="{{ asset('storage/' . $product->featured_image) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover rounded-t-xl">
                    @else
                        <i data-lucide="package" class="w-16 h-16 text-gray-300"></i>
                    @endif
                    @if($product->category)
                        <span class="absolute top-3 left-3 px-2 py-1 bg-teal-600 text-white text-xs rounded-full shadow">{{ $product->category->name }}</span>
                    @endif
                </div>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">{{ $product->name }}</h3>
                        <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ Str::limit(strip_tags($product->description), 80) }}</p>
                    </div>
                    <div class="flex items-center justify-between mt-auto">
                        <div>
                            @if($product->sale_price)
                                <span class="text-lg font-bold text-teal-600">{{ $product->formatted_sale_price }}</span>
                                <span class="text-sm text-gray-400 line-through ml-1">{{ $product->formatted_price }}</span>
                            @else
                                <span class="text-lg font-bold text-gray-900">{{ $product->formatted_price }}</span>
                            @endif
                        </div>
                        <a href="{{ route('frontend.products.show', $product->slug) }}" class="inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors text-sm font-semibold shadow">
                            View
                            <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
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

<!-- Section Teams -->
 <section id="teams" class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Meet Our Team</h2>
            <p class="text-gray-600">The people behind our success</p>
        </div>

        @if($teams && $teams->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($teams as $team)
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                @if($team->image)
                    <div class="h-40 w-40 mx-auto mb-4">
                        <img src="{{ asset('storage/' . $team->image) }}" 
                             alt="{{ $team->name }}" 
                             class="w-full h-full object-cover rounded-full">
                    </div>
                @endif
                <h3 class="text-xl font-semibold text-gray-900 mb-2 text-center">{{ $team->name }}</h3>
                <p class="text-gray-500 text-center">{{ $team->position }}</p>
                <span class="text-gray-700 text-center">{{ $team->category ? $team->category->name : '' }}</span>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <i data-lucide="users" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
            <p class="text-gray-600">No team members to display at the moment.</p>
        </div>
        @endif
    </div>
 </section>

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

<!-- Testimonials -->
 <section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">What Our Clients Say</h2>
            <p class="text-gray-600">Testimonials from our valued clients</p>
        </div>

        @if($testimonials && $testimonials->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($testimonials as $testimonial)
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                <div class="mb-4">
                    <i data-lucide="quote" class="w-8 h-8 text-blue-600"></i>
                </div>
                <p class="text-gray-700 italic mb-4">"{{ $testimonial->content }}"</p>
                <div class="flex items-center">
                    @if($testimonial->image)
                        <img src="{{ asset('storage/' . $testimonial->image) }}" 
                             alt="{{ $testimonial->name }}" 
                             class="w-12 h-12 rounded-full object-cover mr-4">
                    @else
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mr-4">
                            <i data-lucide="user" class="w-6 h-6 text-gray-400"></i>
                        </div>
                    @endif
                    <div>
                        <h4 class="text-gray-900 font-semibold">{{ $testimonial->name }}</h4>
                        <span class="text-gray-500 text-sm">{{ $testimonial->position }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <i data-lucide="message-square" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
            <p class="text-gray-600">No testimonials available at the moment.</p>
        </div>
        @endif
    </div>
</section>

@endsection