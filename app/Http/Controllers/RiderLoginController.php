<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RiderLoginController extends Controller
{
    public function show()
    {
        return view('rider_login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Rider account not found'], 401);
            }
            return redirect()->back()->withErrors(['email' => 'Rider account not found'])->withInput();
        }

        if (!$user->isRider()) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'This account is not a rider account'], 403);
            }
            return redirect()->back()->withErrors(['email' => 'This account is not a rider account'])->withInput();
        }

        if ($user->account_status !== 'active') {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Your rider account has been deactivated'], 403);
            }
            return redirect()->back()->withErrors(['email' => 'Your rider account has been deactivated'])->withInput();
        }

        if (!Hash::check($validated['password'], $user->password)) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Invalid credentials'], 401);
            }
            return redirect()->back()->withErrors(['password' => 'Invalid credentials'])->withInput();
        }

        Auth::login($user, $request->boolean('remember'));

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'redirect' => route('rider.dashboard')]);
        }

        return redirect()->route('rider.dashboard')->with('success', 'Welcome back, rider!');
    }
}
