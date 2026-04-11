<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\PasswordResetMail;

class PasswordResetController extends Controller
{
    /**
     * Show the "forgot password" form.
     */
    public function showRequestForm()
    {
        return view('auth.password_request');
    }

    /**
     * Generate a token, store it, and send the reset email.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('status', 'If an account with that email exists, we have sent a password reset link.');
        }

        // Delete old tokens for this email
        DB::table('password_resets')->where('email', $request->email)->delete();

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        $resetUrl = url('/password/reset/' . $token . '?email=' . urlencode($request->email));

        Mail::to($request->email)->send(new PasswordResetMail($resetUrl, $user));

        return back()->with('status', 'If an account with that email exists, we have sent a password reset link.');
    }

    /**
     * Show the reset password form (with token).
     */
    public function showResetForm(Request $request, $token)
    {
        return view('auth.password_reset', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Validate the token and update the password.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $record = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if (!$record) {
            return back()->withErrors(['email' => 'No password reset request found for this email.']);
        }

        // Check token (it's hashed)
        if (!Hash::check($request->token, $record->token)) {
            return back()->withErrors(['email' => 'Invalid or expired reset token.']);
        }

        // Check expiration (1 hour)
        if (now()->diffInMinutes($record->created_at) > 60) {
            DB::table('password_resets')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'This reset link has expired. Please request a new one.']);
        }

        // Update the password
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        // Delete used token
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Your password has been reset successfully! Please log in.');
    }
}
