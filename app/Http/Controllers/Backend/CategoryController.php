<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type', 'post');

        $query = Category::query()->where('type', $type);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active' ? 1 : 0);
        }

        // Filter by search
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $categories = $query->orderBy('sort_order')->paginate(15);

        return view('categories.index', compact('categories', 'type'));
    }

    public function create(Request $request)
    {
        $type = $request->input('type', 'post');
        return view('categories.create', compact('type'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:post,product,portfolio,team,general',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Category::create($validated);

        return redirect()->route('categories.index', ['type' => $validated['type']])
                         ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', ['category' => $category]);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:post,product,portfolio,team,general',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? $category->sort_order;

        $category->update($validated);

        return redirect()->route('categories.index', ['type' => $validated['type']])
                         ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->posts()->count() > 0 || $category->products()->count() > 0) {
            return redirect()->route('categories.index', ['type' => $category->type])
                             ->with('error', 'Cannot delete category because it has items.');
        }

        $category->delete();

        return redirect()->route('categories.index', ['type' => $category->type])
                         ->with('success', 'Category deleted successfully.');
    }
}
