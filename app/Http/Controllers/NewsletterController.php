<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsletterController extends Controller
{
    /**
     * Subscribe an email to the newsletter (AJAX endpoint).
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $existing = NewsletterSubscriber::where('email', $request->email)->first();

        if ($existing) {
            if ($existing->subscription_status === 'active') {
                return response()->json([
                    'success' => false,
                    'message' => 'This email is already subscribed!',
                ]);
            }

            // Resubscribe
            $existing->update([
                'subscription_status' => 'active',
                'subscription_date' => now()->toDateTimeString(),
                'unsubscribed_date' => null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Welcome back! You\'ve been re-subscribed.',
            ]);
        }

        NewsletterSubscriber::create([
            'subscriber_id' => 'SUB-' . strtoupper(Str::random(8)),
            'email' => $request->email,
            'subscription_status' => 'active',
            'subscription_source' => 'footer_form',
            'subscription_date' => now()->toDateTimeString(),
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'You\'re subscribed! Watch your inbox for pet deals & tips. 🐾',
        ]);
    }
}
