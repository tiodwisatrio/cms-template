<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class TeamCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('type', 'team')->orderByDesc('id')->get();
        return view('team.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('team.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'status' => 'required|in:0,1',
        ]);
        Category::create([
            'name' => $request->name,
            'slug' => $request->slug ?: \Str::slug($request->name),
            'description' => $request->description,
            'type' => 'team',
            'status' => $request->status,
        ]);
        return redirect()->route('team.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('team.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'status' => 'required|in:0,1',
        ]);
        $category->update([
            'name' => $request->name,
            'slug' => $request->slug ?: \Str::slug($request->name),
            'description' => $request->description,
            'status' => $request->status,
        ]);
        return redirect()->route('team.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('team.categories.index')->with('success', 'Category deleted successfully.');
    }
}
