<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SettingController extends Controller
{
    public function emailSettings()
    {
        $settings = Setting::where('group', 'email')->get()->keyBy('key');
        
        return view('settings.email', compact('settings'));
    }

    public function updateEmailSettings(Request $request)
    {
        $request->validate([
            'smtp_host' => 'required|string',
            'smtp_port' => 'required|integer',
            'smtp_username' => 'required|string',
            'smtp_password' => 'nullable|string',
            'smtp_encryption' => 'required|in:tls,ssl',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string',
        ]);

        $emailSettings = [
            'smtp_host' => $request->smtp_host,
            'smtp_port' => $request->smtp_port,
            'smtp_username' => $request->smtp_username,
            'smtp_encryption' => $request->smtp_encryption,
            'mail_from_address' => $request->mail_from_address,
            'mail_from_name' => $request->mail_from_name,
        ];

        // Only update password if provided
        if ($request->filled('smtp_password')) {
            $emailSettings['smtp_password'] = $request->smtp_password;
        }

        foreach ($emailSettings as $key => $value) {
            Setting::set($key, $value, 'text', 'email');
        }

        Setting::clearCache();

        return redirect()->route('settings.email')
            ->with('success', 'Email settings updated successfully!');
    }

    public function testEmail(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email'
        ]);

        try {
            \App\Services\MailConfigService::setMailConfig();
            
            Mail::raw('This is a test email from your CMS.', function ($message) use ($request) {
                $message->to($request->test_email)
                    ->subject('Test Email');
            });

            return back()->with('success', 'Test email sent successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send test email: ' . $e->getMessage());
        }
    }
}
