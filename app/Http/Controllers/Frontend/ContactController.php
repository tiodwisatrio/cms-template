<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.pages.contact.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        $validated['ip_address'] = $request->ip();
        $validated['status'] = 'new';

        ContactMessage::create($validated);

        return redirect()->route('frontend.contact.index')
            ->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }
}
