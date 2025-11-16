<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agenda;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AgendaController extends Controller
{
    public function index()
    {
        // $agendas = Agenda::orderByDesc('start_date')->get();
        // return view('agendas.index', compact('agendas'));

        $agendas = Agenda::orderBy('start_date')->get();
        return view('agendas.index', compact('agendas'));
    }

    public function create()
    {
        return view('agendas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:agendas,slug',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:0,1',
        ]);
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('agendas', 'public');
        }
        Agenda::create($data);
        return redirect()->route('agendas.index')->with('success', 'Agenda created successfully.');
    }

    public function edit(Agenda $agenda)
    {
        return view('agendas.edit', compact('agenda'));
    }

    public function update(Request $request, Agenda $agenda)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:agendas,slug,' . $agenda->id,
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:0,1',
        ]);
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        if ($request->hasFile('image')) {
            if ($agenda->image) {
                Storage::disk('public')->delete($agenda->image);
            }
            $data['image'] = $request->file('image')->store('agendas', 'public');
        }
        $agenda->update($data);
        return redirect()->route('agendas.index')->with('success', 'Agenda updated successfully.');
    }

    public function destroy(Agenda $agenda)
    {
        if ($agenda->image) {
            Storage::disk('public')->delete($agenda->image);
        }
        $agenda->delete();
        return redirect()->route('agendas.index')->with('success', 'Agenda deleted successfully.');
    }

}
