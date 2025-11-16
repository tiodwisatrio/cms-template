<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Navigation;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function index()
    {
        $navigations = Navigation::orderBy('order')->get();
        return view('navigations.index', compact('navigations'));
    }

    public function update(Request $request, Navigation $navigation)
    {
        $data = $request->validate([
            'status' => 'required|in:0,1',
        ]);
        
        $navigation->update($data);
        return response()->json(['success' => true]);
    }

    // Handle AJAX reorder request
    public function reorder(Request $request)
    {
        $ids = $request->input('ids', []);
        foreach ($ids as $order => $id) {
            Navigation::where('id', $id)->update(['order' => $order]);
        }
        return response()->json(['success' => true]);
    }
}
