@extends('layouts.dashboard')

@section('header')
    Create Our Client
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-2">
            <a href="{{ route('ourclient.index') }}" class="hover:text-teal-600">Our Clients</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <span class="text-gray-900">Create New</span>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">Create New Client</h2>
    </div>

    <!-- Form -->
    <form action="{{ route('ourclient.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i data-lucide="info" class="w-5 h-5 mr-2 text-teal-600"></i>
                Basic Information
            </h3>

            <div class="space-y-4">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Client Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Client Logo/Image
                    </label>
                    <div class="flex items-center gap-4">
                        <div id="image-preview" class="w-32 h-32 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center bg-gray-50 overflow-hidden">
                            <div class="text-center">
                                <i data-lucide="image" class="w-8 h-8 text-gray-400 mx-auto mb-2"></i>
                                <p class="text-xs text-gray-500">No image</p>
                            </div>
                        </div>
                        <div class="flex-1">
                            <input type="file" 
                                   id="image" 
                                   name="image" 
                                   accept="image/*"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('image') border-red-500 @enderror">
                            <p class="mt-1 text-xs text-gray-500">Recommended: Square image, max 2MB</p>
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Sort Order -->
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                        Display Order
                    </label>
                    <input type="number" 
                           id="order" 
                           name="order" 
                           value="{{ old('order', 0) }}"
                           min="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 @error('order') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500">Lower numbers appear first</p>
                    @error('order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <label class="flex items-center mt-2">
                        <input type="checkbox" 
                               name="status" 
                               value="1"
                               {{ old('status', true) ? 'checked' : '' }}
                               class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">Active</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('ourclient.index') }}" 
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                Cancel
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition duration-200 flex items-center">
                <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                Create Client
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Image preview
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');
    
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover" alt="Preview">`;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush

