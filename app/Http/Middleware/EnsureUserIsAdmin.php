<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     * Redirect non-admin users to the customer home page.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check if user is admin (handle both boolean and string user_type)
        $isAdmin = !empty($user->is_admin) || ($user->user_type ?? '') === 'admin';

        if (!$isAdmin) {
            return redirect()->route('home')->with('message', 'You do not have access to the admin area.');
        }

        return $next($request);
    }
}
