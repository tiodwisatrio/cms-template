<?php

namespace App\Http\Controllers\Backend;

use App\Models\OurValue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class OurValueController extends Controller
{
    public function index()
    {
        $values = OurValue::orderBy('order')->get();
        return view('ourvalues.index', compact('values'));
    }

    public function create()
    {
        return view('ourvalues.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|boolean',
            'order' => 'required|integer',
        ]);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('ourvalues', 'public');
        }
        OurValue::create($data);
        return redirect()->route('ourvalues.index')->with('success', 'Value created successfully.');
    }

    public function edit(OurValue $ourvalue)
    {
        return view('ourvalues.edit', compact('ourvalue'));
    }

    public function update(Request $request, OurValue $ourvalue)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|boolean',
            'order' => 'required|integer',
        ]);
        if ($request->hasFile('image')) {
            if ($ourvalue->image) {
                Storage::disk('public')->delete($ourvalue->image);
            }
            $data['image'] = $request->file('image')->store('ourvalues', 'public');
        }
        $ourvalue->update($data);
        return redirect()->route('ourvalues.index')->with('success', 'Value updated successfully.');
    }

    public function destroy(OurValue $ourvalue)
    {
        if ($ourvalue->image) {
            Storage::disk('public')->delete($ourvalue->image);
        }
        $ourvalue->delete();
        return redirect()->route('ourvalues.index')->with('success', 'Value deleted successfully.');
    }
}
