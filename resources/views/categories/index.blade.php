@extends('layouts.dashboard')

@section('header')
    Categories
@endsection

@section('content')
<div class="mb-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manage Categories</h2>
            <p class="text-gray-600 mt-1">Organize your content with categories</p>
        </div>
        <a href="{{ route('categories.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-lg shadow-md transition duration-200">
            <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
            Add Category
        </a>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
    <form method="GET" action="{{ route('categories.index') }}" class="flex flex-wrap gap-4">
        <!-- Search -->
        <div class="flex-1 min-w-[150px]">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="Search categories..." 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
        </div>

        <!-- Type Filter -->
        <div class="min-w-[150px]">
            <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                <option value="all" {{ request('type') === 'all' ? 'selected' : '' }}>All</option>
                <option value="post" {{ request('type') === 'post' ? 'selected' : '' }}>Post</option>
                <option value="product" {{ request('type') === 'product' ? 'selected' : '' }}>Product</option>
                <option value="portfolio" {{ request('type') === 'portfolio' ? 'selected' : '' }}>Portfolio</option>
                <option value="general" {{ request('type') === 'general' ? 'selected' : '' }}>General</option>
            </select>
        </div>

        <!-- Status Filter -->
        <div class="min-w-[150px]">
            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                <option value="" {{ request('status') === null ? 'selected' : '' }}>All</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <!-- Buttons -->
        <button type="submit" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition duration-200">
            <i data-lucide="search" class="w-4 h-4 inline mr-1"></i>
            Filter
        </button>
        <a href="{{ route('categories.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition duration-200">
            <i data-lucide="x" class="w-4 h-4 inline mr-1"></i>
            Reset
        </a>
    </form>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 flex items-center">
        <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6 flex items-center">
        <i data-lucide="alert-circle" class="w-5 h-5 mr-2"></i>
        {{ session('error') }}
    </div>
@endif

<!-- Categories Table -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($categories as $category)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <!-- Order -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $category->sort_order }}
                        </td>

                        <!-- Category Info -->
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($category->icon)
                                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center" 
                                         style="background-color: {{ $category->color ?? '#e5e7eb' }}15">
                                        <i data-lucide="{{ $category->icon }}" class="w-5 h-5" style="color: {{ $category->color ?? '#6b7280' }}"></i>
                                    </div>
                                @endif
                                <div class="{{ $category->icon ? 'ml-3' : '' }}">
                                    <div class="font-medium text-gray-900">{{ $category->name }}</div>
                                    @if($category->description)
                                        <div class="text-sm text-gray-500 line-clamp-1">{{ Str::limit($category->description, 50) }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Type Badge -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $category->type === 'post' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $category->type === 'product' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $category->type === 'portfolio' ? 'bg-purple-100 text-purple-800' : '' }}
                                {{ $category->type === 'general' ? 'bg-gray-100 text-gray-800' : '' }}">
                                {{ ucfirst($category->type) }}
                            </span>
                        </td>

                        <!-- Items Count -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex items-center gap-3">
                                @if($category->posts_count > 0)
                                    <span class="text-blue-600" title="Posts">
                                        <i data-lucide="file-text" class="w-4 h-4 inline"></i> {{ $category->posts_count }}
                                    </span>
                                @endif
                                @if($category->products_count > 0)
                                    <span class="text-green-600" title="Products">
                                        <i data-lucide="package" class="w-4 h-4 inline"></i> {{ $category->products_count }}
                                    </span>
                                @endif
                                @if($category->posts_count == 0 && $category->products_count == 0)
                                    <span class="text-gray-400">No items</span>
                                @endif
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($category->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i data-lucide="check-circle" class="w-3 h-3 mr-1"></i>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <i data-lucide="x-circle" class="w-3 h-3 mr-1"></i>
                                    Inactive
                                </span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('categories.edit', $category) }}" 
                                   class="text-teal-600 hover:text-teal-900 transition-colors"
                                   title="Edit">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('categories.destroy', $category) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('Are you sure you want to delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900 transition-colors"
                                            title="Delete">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <i data-lucide="folder-x" class="w-12 h-12 mb-3"></i>
                                <p class="text-lg font-medium">No categories found</p>
                                <p class="text-sm mt-1">Create your first category to get started</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($categories->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $categories->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    lucide.createIcons();
</script>
@endpush
