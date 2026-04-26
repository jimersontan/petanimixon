<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show the Me dashboard
     */
    public function me()
    {
        $user = Auth::user();
        
        $allOrders = \App\Models\Order::where('user_id', $user->id)->get();
        $orderStats = [
            'pending' => $allOrders->where('order_status', 'pending')->count(),
            'processing' => $allOrders->where('order_status', 'processing')->count(),
            'out_for_delivery' => $allOrders->where('order_status', 'out_for_delivery')->count(),
            'delivered' => $allOrders->where('order_status', 'delivered')->count(),
        ];

        return view('profile.me', compact('user', 'orderStats'));
    }

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
            'profile_picture' => 'nullable|image|max:2048',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'color_theme' => 'nullable|string|in:meadow_honey,sunny_paws,ocean_breeze,citrus_tail,lavender_sky,rosy_petal',
            'address' => 'nullable|string|max:1000',
            'gender' => 'nullable|string|in:Male,Female,Other,Prefer not to say',
            'bio' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date',
        ]);

        // Handle profile picture
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture && Storage::disk('public')->exists('profile_pictures/' . $user->profile_picture)) {
                Storage::disk('public')->delete('profile_pictures/' . $user->profile_picture);
            }
            $file = $request->file('profile_picture');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('profile_pictures', $filename, 'public');
            $user->profile_picture = $filename;
        }

        // Update user info
        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->email = $validated['email'];
        
        $user->phone_number = $validated['phone_number'] ?? null;
        $user->address = $validated['address'] ?? null;
        $user->gender = $validated['gender'] ?? null;
        $user->bio = $validated['bio'] ?? null;
        $user->date_of_birth = $validated['date_of_birth'] ?? null;

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
            'color_theme' => 'required|string|in:meadow_honey,sunny_paws,ocean_breeze,citrus_tail,lavender_sky,rosy_petal',
        ]);

        $user = Auth::user();
        $user->color_theme = $validated['color_theme'];
        $user->save();

        return response()->json(['success' => true, 'theme' => $validated['color_theme']]);
    }
}
