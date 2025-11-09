<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('order', 'asc')->get();
        return view('services.index', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:0,1',
            'order' => 'nullable|integer',
        ]);

        $data = $request->only(['name', 'description', 'status', 'order']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads/services', 'public');
        }

        Service::create($data);

        return redirect()->route('services.index')->with('success', 'Service berhasil ditambahkan.');
    }

    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:0,1',
            'order' => 'nullable|integer',
        ]);

        $data = $request->only(['name', 'description', 'status', 'order']);


        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $data['image'] = $request->file('image')->store('uploads/services', 'public');
        }

        $service->update($data);

        return redirect()->route('services.index')->with('success', 'Service berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service berhasil dihapus.');
    }
}
