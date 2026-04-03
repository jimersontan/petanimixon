<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show the edit profile form
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'color_theme' => 'nullable|string|in:sunset_orange,golden_sunshine,nature_fresh,sakura_bloom,cosmic_violet',
        ]);

        // Update user info
        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->email = $validated['email'];
        
        if (isset($validated['phone_number'])) {
            $user->phone_number = $validated['phone_number'];
        }

        // Update color theme
        if (isset($validated['color_theme'])) {
            $user->color_theme = $validated['color_theme'];
        }

        // Update password if provided
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
    }

    /**
     * Update color theme only (AJAX)
     */
    public function updateTheme(Request $request)
    {
        $validated = $request->validate([
            'color_theme' => 'required|string|in:sunset_orange,golden_sunshine,nature_fresh,sakura_bloom,cosmic_violet',
        ]);

        $user = Auth::user();
        $user->color_theme = $validated['color_theme'];
        $user->save();

        return response()->json(['success' => true, 'theme' => $validated['color_theme']]);
    }
}
