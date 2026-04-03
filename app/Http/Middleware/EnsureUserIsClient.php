<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsClient
{
    /**
     * Handle an incoming request.
     *
     * Prevent admin users from accessing client-only pages (like My Orders).
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Allow the system's main admin to access all pages (admin + client).
        // Other admin roles should not view customer-facing pages.
        if ($user && method_exists($user, 'isAdmin') && $user->isAdmin() && ! (method_exists($user, 'isMainAdmin') && $user->isMainAdmin())) {
            return redirect()->route('dashboard')->with('error', 'Admin users are not allowed to access client pages.');
        }

        // Riders should use their own dashboard, not client pages.
        if ($user && method_exists($user, 'isRider') && $user->isRider()) {
            return redirect()->route('rider.dashboard')->with('error', 'Please use the Rider Dashboard.');
        }

        return $next($request);
    }
}
