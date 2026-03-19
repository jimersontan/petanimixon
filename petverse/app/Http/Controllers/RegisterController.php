<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'pet_type' => 'nullable|string|max:100',
            'promos' => 'sometimes|boolean',
            'tips' => 'sometimes|boolean',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.,;:()])/',
            ],
            'terms' => 'accepted',
        ], [
            'password.regex' => 'Password must be at least 8 characters with one uppercase, one number, and one special character (!@$%*?&).',
            'terms.accepted' => 'You must agree to the Terms & Conditions and Privacy Policy.',
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'user_type' => 'customer',
            'pet_type' => $validated['pet_type'] ?? null,
            'wants_promos' => $request->boolean('promos'),
            'wants_tips' => $request->boolean('tips'),
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        return response()->json(['success' => true, 'redirect' => route('home')]);
    }
}
