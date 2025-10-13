@extends('frontend.layouts.app')

@section('title', 'Products')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-green-600 to-blue-600 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Our Products</h1>
            <p class="text-xl opacity-90">Discover amazing products and services</p>
        </div>
    </div>
</div>

<!-- Search & Filter Section -->
<div class="bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <form method="GET" action="{{ route('frontend.products.index') }}" class="space-y-4">
            <div class="flex flex-col lg:flex-row gap-4">
                <!-- Search Input -->
                <div class="flex-1">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Search products..." 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    >
                </div>
                
                <!-- Category Filter -->
                <div class="lg:w-48">
                    <select 
                        name="category" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    >
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Sort Options -->
                <div class="lg:w-48">
                    <select 
                        name="sort" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    >
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                </div>
            </div>
            
            <!-- Price Range -->
            <div class="flex flex-col md:flex-row gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                    <div class="flex gap-2">
                        <input 
                            type="number" 
                            name="min_price" 
                            value="{{ request('min_price') }}"
                            placeholder="Min price" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        >
                        <span class="flex items-center px-2 text-gray-500">-</span>
                        <input 
                            type="number" 
                            name="max_price" 
                            value="{{ request('max_price') }}"
                            placeholder="Max price" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        >
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <button 
                        type="submit"
                        class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
                    >
                        Search
                    </button>
                    
                    @if(request()->hasAny(['search', 'category', 'min_price', 'max_price', 'sort']))
                        <a 
                            href="{{ route('frontend.products.index') }}"
                            class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors"
                        >
                            Clear
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Products Grid -->
<div class="py-16">
    <div class="container mx-auto px-4">
        @if($products->count() > 0)
            <!-- Results Count -->
            <div class="mb-8">
                <p class="text-gray-600">
                    Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }} products
                    @if(request('search'))
                        for "{{ request('search') }}"
                    @endif
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 mb-12">
                @foreach($products as $product)
                    <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow group">
                        <!-- Product Image -->
                        <div class="h-56 bg-gray-300 relative overflow-hidden">
                            @if($product->featured_image)
                                <img 
                                    src="{{ asset('storage/' . $product->featured_image) }}" 
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                >
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-green-400 to-blue-500 flex items-center justify-center">
                                    <i data-lucide="package" class="w-16 h-16 text-white opacity-50"></i>
                                </div>
                            @endif
                            
                            <!-- Category Badge -->
                            @if($product->category)
                                <div class="absolute top-3 left-3">
                                    <span class="px-2 py-1 bg-green-600 text-white text-xs font-medium rounded-full shadow-lg">
                                        {{ $product->category->name }}
                                    </span>
                                </div>
                            @endif
                            
                            <!-- Price Badge -->
                            @if($product->price)
                                <div class="absolute top-3 right-3">
                                    <span class="px-2 py-1 bg-blue-600 text-white text-sm font-bold rounded-lg shadow-lg">
                                        {{ $product->formatted_price }}
                                    </span>
                                </div>
                            @endif

                            <!-- Quick View Overlay -->
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-opacity duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                <a 
                                    href="{{ route('frontend.products.show', $product->slug) }}"
                                    class="px-4 py-2 bg-white text-gray-900 rounded-lg font-medium transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300"
                                >
                                    Quick View
                                </a>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-2 line-clamp-2">
                                <a href="{{ route('frontend.products.show', $product->slug) }}" class="hover:text-green-600 transition-colors">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            
                            <!-- Meta Info -->
                            <div class="flex items-center text-gray-500 text-sm mb-3">
                                <i data-lucide="user" class="w-4 h-4 mr-1"></i>
                                <span class="mr-4">{{ $product->user->name }}</span>
                                <i data-lucide="calendar" class="w-4 h-4 mr-1"></i>
                                <span>{{ $product->created_at->format('M d, Y') }}</span>
                            </div>
                            
                            <!-- Description -->
                            <p class="text-gray-600 mb-4 line-clamp-3">
                                {{ Str::limit(strip_tags($product->description), 100) }}
                            </p>
                            
                            <!-- Price & Action -->
                            <div class="flex items-center justify-between">
                                @if($product->price)
                                    <div class="text-2xl font-bold text-green-600">
                                        {{ $product->formatted_price }}
                                    </div>
                                @endif
                                
                                <a 
                                    href="{{ route('frontend.products.show', $product->slug) }}"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
                                >
                                    View Details
                                    <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $products->withQueryString()->links() }}
            </div>
        @else
            <!-- No Products Found -->
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <i data-lucide="search-x" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">No products found</h3>
                    <p class="text-gray-500 mb-6">
                        @if(request('search'))
                            No products match your search for "{{ request('search') }}"
                        @else
                            No products available at the moment.
                        @endif
                    </p>
                    @if(request()->hasAny(['search', 'category', 'min_price', 'max_price']))
                        <a 
                            href="{{ route('frontend.products.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700"
                        >
                            <i data-lucide="refresh-ccw" class="w-4 h-4 mr-2"></i>
                            Clear Filters
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection