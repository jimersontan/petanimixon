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
            'email' => 'required|string', // could be email or username
            'password' => 'required|string',
        ]);

        $identifier = trim($validated['email']);
        $query = User::query();
        if (str_contains($identifier, '@')) {
            $query->where('email', $identifier);
        } else {
            if (\Schema::hasColumn('users', 'name')) {
                $query->orWhere('name', $identifier);
            }
            if (\Schema::hasColumn('users', 'first_name') && \Schema::hasColumn('users', 'last_name')) {
                $query->orWhereRaw("concat(first_name,' ',last_name) = ?", [$identifier]);
            }
        }
        $user = $query->first();
        if (!$user) {
            // maybe the email belongs to a pending admin request
            $pending = \App\Models\AdminRequest::where('email', $identifier)
                        ->where('status', 'pending')
                        ->first();
            if ($pending) {
                return response()->json(['success' => false, 'message' => 'Admin account request is still pending approval'], 401);
            }
            \Log::warning('Admin login failed, user not found', ['identifier' => $identifier]);
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

        // always return JSON for POST logins
        return response()->json(['success' => true, 'redirect' => route('dashboard')]);
    }
}
