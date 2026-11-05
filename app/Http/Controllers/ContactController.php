<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'need' => ['required', 'in:supplies,contracting,export'],
            'name' => ['required', 'string', 'max:120'],
            'company' => ['nullable', 'string', 'max:160'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['nullable', 'string', 'max:40'],
            'subject' => ['nullable', 'string', 'max:190'],
            'message' => ['nullable', 'string', 'max:4000'],
            'website' => ['nullable', 'max:0'], // honeypot: bots fill this in
        ]);

        unset($data['website']);

        // 1) Always keep the enquiry, so nothing is lost even if email is not configured.
        try {
            $message = ContactMessage::create($data + [
                'locale' => app()->getLocale(),
                'ip' => $request->ip(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Contact message could not be saved: '.$e->getMessage());

            return back()->withInput()->with('error', true);
        }

        // 2) Then try to email it. A mail problem must not turn into a failed submission.
        try {
            $body = collect($data)
                ->map(fn ($value, $key) => ucfirst($key).': '.($value ?: '-'))
                ->implode("\n");

            Mail::raw($body, function ($mail) use ($data) {
                $mail->to(config('mail.contact_to'))
                    ->replyTo($data['email'], $data['name'])
                    ->subject('Royal Frost website: '.(($data['subject'] ?? null) ?: 'New enquiry from '.$data['name']));
            });

            $message->update(['emailed' => config('mail.default') !== 'log']);
        } catch (\Throwable $e) {
            Log::error('Contact form email failed: '.$e->getMessage());
        }

        return redirect()->to(route('contact').'#contact-form')->with('sent', true);
    }
}
