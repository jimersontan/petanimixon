<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
{
    public function show()
    {
        return view('admin_login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validated['email'])->first();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Admin not found'], 401);
        }

        // Debug: Check the actual values
        \Log::info('Admin Login Attempt', [
            'email' => $validated['email'],
            'is_admin' => $user->is_admin,
            'is_admin_type' => gettype($user->is_admin),
            'user_type' => $user->user_type,
        ]);

        // Check if user is admin (handle both boolean and integer)
        if (!$user->is_admin && $user->user_type !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized - User is not an admin'], 403);
        }

        if (!Hash::check($validated['password'], $user->password)) {
            return response()->json(['success' => false, 'message' => 'Invalid credentials'], 401);
        }

        Auth::login($user, $request->has('keep_signed'));

        return response()->json(['success' => true, 'redirect' => route('dashboard')]);
    }
}
