<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\ContactReplyMail;
use App\Models\ContactMessage;
use App\Services\MailConfigService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::latest();

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('subject', 'like', '%' . $request->search . '%');
            });
        }

        $messages = $query->paginate(15);
        $newCount = ContactMessage::where('status', 'new')->count();

        return view('contacts.index', compact('messages', 'newCount'));
    }

    public function show(ContactMessage $contact)
    {
        // Mark as read if new
        if ($contact->isNew()) {
            $contact->markAsRead();
        }

        return view('contacts.show', compact('contact'));
    }

    public function reply(Request $request, ContactMessage $contact)
    {
        $request->validate([
            'reply_message' => 'required|string'
        ]);

        try {
            // Set dynamic mail config
            MailConfigService::setMailConfig();

            // Send email
            Mail::to($contact->email)->send(
                new ContactReplyMail($contact, $request->reply_message)
            );

            // Update contact message
            $contact->update([
                'admin_reply' => $request->reply_message,
                'status' => 'replied',
                'replied_at' => now()
            ]);

            return redirect()->route('contacts.show', $contact)
                ->with('success', 'Reply sent successfully!');
        } catch (\Exception $e) {
            return redirect()->route('contacts.show', $contact)
                ->with('error', 'Failed to send email: ' . $e->getMessage());
        }
    }

    public function destroy(ContactMessage $contact)
    {
        $contact->delete();
        return redirect()->route('contacts.index')
            ->with('success', 'Contact message deleted successfully.');
    }
}
