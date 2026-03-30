<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $validated = $validator->validated();

        // Determine identifier, allow email or name (or full name)
        $identifier = trim($validated['email']);

        $query = User::query();
        if (str_contains($identifier, '@')) {
            $query->where('email', $identifier);
        } else {
            // search name column if present
            if (\Schema::hasColumn('users', 'name')) {
                $query->orWhere('name', $identifier);
            }
            // also try first_name + last_name
            if (\Schema::hasColumn('users', 'first_name') && \Schema::hasColumn('users', 'last_name')) {
                $query->orWhereRaw("concat(first_name,' ',last_name) = ?", [$identifier]);
            }
        }
        $user = $query->first();

        if (!$user) {
            \Log::warning('Login attempt failed, user not found', ['identifier' => $identifier]);
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'User not found'], 401);
            }
            return redirect()->back()->withErrors(['email' => 'User not found'])->withInput();
        }

        if (!Hash::check($validated['password'], $user->password)) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Invalid credentials'], 401);
            }
            return redirect()->back()->withErrors(['password' => 'Invalid credentials'])->withInput();
        }

        Auth::login($user, $request->has('remember'));

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'redirect' => route('home')]);
        }
        
        return redirect()->route('home')->with('success', 'Logged in successfully.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
