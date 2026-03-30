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
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Admin account request is still pending approval'], 401);
                }
                return redirect()->back()->withErrors(['email' => 'Admin account request is still pending approval'])->withInput();
            }
            \Log::warning('Admin login failed, user not found', ['identifier' => $identifier]);
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Admin not found'], 401);
            }
            return redirect()->back()->withErrors(['email' => 'Admin not found'])->withInput();
        }

        // Debug: Check the actual values
        \Log::info('Admin Login Attempt', [
            'email' => $validated['email'],
            'is_admin' => $user->is_admin,
            'is_admin_type' => gettype($user->is_admin),
            'user_type' => $user->user_type,
        ]);

        // Only admin users should be able to log in here.
        if (! method_exists($user, 'isAdmin') || ! $user->isAdmin()) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized - User is not an admin'], 403);
            }
            return redirect()->back()->withErrors(['email' => 'Unauthorized - User is not an admin'])->withInput();
        }

        if (!Hash::check($validated['password'], $user->password)) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Invalid credentials'], 401);
            }
            return redirect()->back()->withErrors(['password' => 'Invalid credentials'])->withInput();
        }

        Auth::login($user, $request->has('keep_signed'));

        if ($request->wantsJson() || $request->ajax()) {
            // always return JSON for POST logins
            return response()->json(['success' => true, 'redirect' => route('dashboard')]);
        }
        
        return redirect()->route('dashboard')->with('success', 'Logged in successfully.');
    }
}
