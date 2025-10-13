<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Models\Post;
use App\Models\Category;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['category', 'user']);

        // Search functionality
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%')
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

        // Filter by featured
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured);
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(10);
        $categories = Category::forPosts()->active()->ordered()->get();

        return view('posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::forPosts()->active()->ordered()->get();
        
        return view('posts.create', compact('categories'));
    }

    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('posts/images', 'public');
        }

        // Handle document files upload
        if ($request->hasFile('document_files')) {
            $documentFiles = [];
            foreach ($request->file('document_files') as $file) {
                $filename = $file->getClientOriginalName();
                $path = $file->store('posts/documents', 'public');
                $documentFiles[] = [
                    'filename' => $filename,
                    'path' => $path,
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType()
                ];
            }
            $validated['document_files'] = $documentFiles;
        }

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Add user_id
        $validated['user_id'] = Auth::id();

        // Handle publish date
        if (empty($validated['publish_date']) && $validated['status'] === 'active') {
            $validated['publish_date'] = now()->toDateString();
        }

        $post = Post::create($validated);

        return redirect()->route('posts.index')
            ->with('success', 'Post berhasil dibuat!');
    }

    public function show(Post $post)
    {
        $post->load(['category', 'user']);
        
        // Increment view count
        $post->increment('view_count');
        
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $categories = Category::forPosts()->active()->ordered()->get();
        
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $validated = $request->validated();

        // Handle remove current image
        if ($request->has('remove_current_image') && $post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
            $validated['featured_image'] = null;
        }

        // Handle new featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists and not already deleted
            if ($post->featured_image && !$request->has('remove_current_image')) {
                Storage::disk('public')->delete($post->featured_image);
            }
            
            $validated['featured_image'] = $request->file('featured_image')
                ->store('posts/images', 'public');
        }

        // Handle remove current files
        $currentFiles = $post->document_files ?: [];
        if ($request->has('remove_current_files')) {
            $filesToRemove = $request->input('remove_current_files', []);
            foreach ($filesToRemove as $index) {
                if (isset($currentFiles[$index]) && isset($currentFiles[$index]['path'])) {
                    Storage::disk('public')->delete($currentFiles[$index]['path']);
                    unset($currentFiles[$index]);
                }
            }
            // Re-index array
            $currentFiles = array_values($currentFiles);
            $validated['document_files'] = $currentFiles;
        }

        // Handle new document files upload
        if ($request->hasFile('document_files')) {
            // If new files are uploaded, replace all current files
            // Delete remaining old documents
            if ($currentFiles) {
                foreach ($currentFiles as $doc) {
                    if (isset($doc['path'])) {
                        Storage::disk('public')->delete($doc['path']);
                    }
                }
            }

            $documentFiles = [];
            foreach ($request->file('document_files') as $file) {
                $filename = $file->getClientOriginalName();
                $path = $file->store('posts/documents', 'public');
                $documentFiles[] = [
                    'filename' => $filename,
                    'path' => $path,
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType()
                ];
            }
            $validated['document_files'] = $documentFiles;
        }

        $post->update($validated);

        return redirect()->route('posts.index')
            ->with('success', 'Post berhasil diperbarui!');
    }

    public function destroy(Post $post)
    {
        // Delete associated files
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        if ($post->document_files) {
            foreach ($post->document_files as $doc) {
                Storage::disk('public')->delete($doc['path']);
            }
        }

        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Post berhasil dihapus!');
    }
}