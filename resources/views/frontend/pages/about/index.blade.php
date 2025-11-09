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
@endsection
