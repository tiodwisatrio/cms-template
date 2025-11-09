<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\OurClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OurClientController extends Controller
{
    public function index()
    {
        $clients = OurClient::orderBy('order', 'asc')->paginate(10);
        return view('ourclient.index', compact('clients'));
    }

    public function create()
    {
        return view('ourclient.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'image' => 'nullable|image|max:2048',
            'status' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ]);

        $data = $request->only(['name', 'status', 'order']);
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('ourclient', 'public');
        }

        OurClient::create($data);
        return redirect()->route('ourclient.index')->with('success', 'Client created successfully.');
    }

    public function edit(OurClient $ourclient)
    {
        return view('ourclient.edit', compact('ourclient'));
    }

    public function update(Request $request, OurClient $ourclient)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'image' => 'nullable|image|max:2048',
            'status' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ]);

        $data = $request->only(['name', 'status', 'order']);
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($ourclient->image) {
                Storage::disk('public')->delete($ourclient->image);
            }
            $data['image'] = $request->file('image')->store('ourclient', 'public');
        }

        $ourclient->update($data);
        return redirect()->route('ourclient.index')->with('success', 'Client updated successfully.');
    }

    public function destroy(OurClient $ourclient)
    {
        if ($ourclient->image) {
            Storage::disk('public')->delete($ourclient->image);
        }
        $ourclient->delete();

        return redirect()->route('ourclient.index')->with('success', 'Client deleted successfully.');
    }
}
