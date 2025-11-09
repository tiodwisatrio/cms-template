<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function index()
    {
        $abouts = About::all();
        return view('about.index', compact('abouts'));
    }

    public function create()
    {
        return view('about.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|max:2048'
        ]);

        $image = $request->file('image') ? $request->file('image')->store('abouts', 'public') : null;

        About::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'image' => $image,
        ]);

        return redirect()->route('abouts.index')->with('success', 'About created successfully.');
    }

    public function edit(About $about)
    {
        return view('about.edit', compact('about'));
    }

    public function update(Request $request, About $about)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->only(['title', 'content']);

        if ($request->file('image')) {
            if ($about->image) {
                Storage::disk('public')->delete($about->image);
            }
            $data['image'] = $request->file('image')->store('abouts', 'public');
        }

        $about->update($data);

        return redirect()->route('abouts.index')->with('success', 'About updated successfully.');
    }

    public function destroy(About $about)
    {
        if ($about->image) {
            Storage::disk('public')->delete($about->image);
        }

        $about->delete();
        return redirect()->route('abouts.index')->with('success', 'About deleted successfully.');
    }
}
