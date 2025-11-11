<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    public function index()
    {
    $teams = Team::with('category')->orderByDesc('id')->get();
    return view('team.index', compact('teams'));
    }

    public function create()
    {
        $categories = Category::where('type', 'team')->where('is_active', 1)->get();
        return view('team.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'status' => 'required|in:0,1',
        ]);

        $data = $request->only(['name', 'category_id', 'description', 'status']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('teams', 'public');
        }
    Team::create($data);
    return redirect()->route('teams.index')->with('success', 'Team member created successfully.');
    }

    public function edit(Team $team)
    {
        $categories = Category::where('type', 'team')->where('is_active', 1)->get();
        return view('team.edit', compact('team', 'categories'));
    }

    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'status' => 'required|in:0,1',
        ]);

        $data = $request->only(['name', 'category_id', 'description', 'status']);
        if ($request->hasFile('image')) {
            // Delete old image
            if ($team->image) {
                Storage::disk('public')->delete($team->image);
            }
            $data['image'] = $request->file('image')->store('teams', 'public');
        }
    $team->update($data);
    return redirect()->route('teams.index')->with('success', 'Team member updated successfully.');
    }

    public function destroy(Team $team)
    {
        if ($team->image) {
            Storage::disk('public')->delete($team->image);
        
    $team->delete();
    return redirect()->route('teams.index')->with('success', 'Team member deleted successfully.');
    }
}

}