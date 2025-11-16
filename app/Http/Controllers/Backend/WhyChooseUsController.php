<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WhyChooseUs;
use Illuminate\Support\Facades\Storage;

class WhyChooseUsController extends Controller
{
    public function index()
    {
        $items = WhyChooseUs::orderByDesc('id')->get();
        return view('whychooseus.index', compact('items'));
    }

    public function create()
    {
        return view('whychooseus.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:0,1',
        ]);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('whychooseus', 'public');
        }
        WhyChooseUs::create($data);
        return redirect()->route('whychooseus.index')->with('success', 'Item created successfully.');
    }

    public function edit(WhyChooseUs $whychooseus)
    {
        return view('whychooseus.edit', compact('whychooseus'));
    }

    public function update(Request $request, WhyChooseUs $whychooseus)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:0,1',
        ]);
        if ($request->hasFile('image')) {
            if ($whychooseus->image) {
                Storage::disk('public')->delete($whychooseus->image);
            }
            $data['image'] = $request->file('image')->store('whychooseus', 'public');
        }
        $whychooseus->update($data);
        return redirect()->route('whychooseus.index')->with('success', 'Item updated successfully.');
    }

    public function destroy(WhyChooseUs $whychooseus)
    {
        if ($whychooseus->image) {
            Storage::disk('public')->delete($whychooseus->image);
        }
        $whychooseus->delete();
        return redirect()->route('whychooseus.index')->with('success', 'Item deleted successfully.');
    }
}
