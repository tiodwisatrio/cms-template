@extends('frontend.layouts.app')

@section('title', 'About Us')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-green-600 to-blue-600 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">About Us</h1>
            <p class="text-xl opacity-90">Learn more about our mission, vision, and values</p>
        </div>
    </div>
</div>

<!-- About Section -->
<div class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        @if($abouts->count() > 0) 
            @foreach($abouts as $about)
                <div class="overflow-hidden mb-10 grid grid-cols-1 md:grid-cols-2">
                    <!-- Content -->
                    <div class="p-6">
                        <h3 class="text-2xl font-semibold text-gray-900 mb-4">{{ $about->title }}</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $about->content }}</p>
                    </div>

                    <!-- Image -->
                    @if($about->image)
                        <div class="h-64 md:h-auto">
                            <img src="{{ asset('storage/' . $about->image) }}" 
                                alt="{{ $about->title }}" 
                                class="w-full h-full object-cover rounded-md">
                        </div>
                    @endif
                </div>
            @endforeach
        @else
            <div class="py-16 text-center">
                <i data-lucide="info" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No About Information Found</h3>
                <p class="text-gray-500">The About section is currently unavailable. Please check back later.</p>
            </div>
        @endif
    </div>
</div>

<!-- Our Values Section -->
    <div class="container mx-auto px-4 mt-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Our Values</h2>
        @if($ourvalues->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($ourvalues as $value)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 text-center">
                        @if($value->image)
                            <img src="{{ asset('storage/' . $value->image) }}" 
                                alt="{{ $value->name }}" 
                                class="w-24 h-24 mx-auto mb-4 object-cover rounded-full">
                        @endif
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $value->name }}</h3>
                        <p class="text-gray-600">{{ $value->description }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="py-16 text-center">
                <i data-lucide="info" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No Values Found</h3>
                <p class="text-gray-500">Our company values are currently unavailable. Please check back later.</p>
            </div>
        @endif
    </div>

    <div class="py-16 bg-gray-800 mt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4 text-white">Ready to Get Started?</h2>
            <p class="text-xl text-gray-300 mb-8">Join us and explore amazing content and products</p>
            <a href="{{ route('frontend.products.index') }}" 
            class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700">
               View Products
            </a>
        </div>
    </div>
@endsection
