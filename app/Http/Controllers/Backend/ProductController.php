<?php
// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'user']);

        // Search functionality
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by stock status
        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'in_stock':
                    $query->inStock();
                    break;
                case 'low_stock':
                    $query->where('track_stock', true)
                          ->whereColumn('stock', '<=', 'min_stock');
                    break;
                case 'out_of_stock':
                    $query->where('track_stock', true)
                          ->where('stock', '<=', 0);
                    break;
            }
        }

        // Filter by featured
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured);
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(10);
        $categories = Category::forProducts()->active()->ordered()->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::forProducts()->active()->ordered()->get();
        
        return view('products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('products/images', 'public');
        }

        // Handle gallery images upload
        if ($request->hasFile('gallery_images')) {
            $galleryImages = [];
            foreach ($request->file('gallery_images') as $file) {
                $path = $file->store('products/gallery', 'public');
                $galleryImages[] = $path;
            }
            $validated['gallery_images'] = $galleryImages;
        }

        // Process specifications
        if ($request->has('specifications')) {
            $specs = [];
            foreach ($request->specifications as $spec) {
                if (!empty($spec['key']) && !empty($spec['value'])) {
                    $specs[] = $spec;
                }
            }
            $validated['specifications'] = $specs;
        }

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Add user_id
        $validated['user_id'] = Auth::id();

        $product = Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dibuat!');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'user']);
        
        // Increment view count
        $product->increment('view_count');
        
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::forProducts()->active()->ordered()->get();
        
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        // Handle remove current image
        if ($request->has('remove_current_image') && $product->featured_image) {
            Storage::disk('public')->delete($product->featured_image);
            $validated['featured_image'] = null;
        }

        // Handle new featured image upload
        if ($request->hasFile('featured_image')) {
            if ($product->featured_image && !$request->has('remove_current_image')) {
                Storage::disk('public')->delete($product->featured_image);
            }
            
            $validated['featured_image'] = $request->file('featured_image')
                ->store('products/images', 'public');
        }

        // Handle remove gallery images
        $currentGallery = $product->gallery_images ?: [];
        if ($request->has('remove_gallery_images')) {
            $imagesToRemove = $request->input('remove_gallery_images', []);
            foreach ($imagesToRemove as $index) {
                if (isset($currentGallery[$index])) {
                    Storage::disk('public')->delete($currentGallery[$index]);
                    unset($currentGallery[$index]);
                }
            }
            $currentGallery = array_values($currentGallery);
            $validated['gallery_images'] = $currentGallery;
        }

        // Handle new gallery images
        if ($request->hasFile('gallery_images')) {
            $newGalleryImages = [];
            foreach ($request->file('gallery_images') as $file) {
                $path = $file->store('products/gallery', 'public');
                $newGalleryImages[] = $path;
            }
            
            // Merge with existing gallery images
            $validated['gallery_images'] = array_merge($currentGallery, $newGalleryImages);
        }

        // Process specifications
        if ($request->has('specifications')) {
            $specs = [];
            foreach ($request->specifications as $spec) {
                if (!empty($spec['key']) && !empty($spec['value'])) {
                    $specs[] = $spec;
                }
            }
            $validated['specifications'] = $specs;
        }

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        // Delete associated files
        if ($product->featured_image) {
            Storage::disk('public')->delete($product->featured_image);
        }

        if ($product->gallery_images) {
            foreach ($product->gallery_images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}