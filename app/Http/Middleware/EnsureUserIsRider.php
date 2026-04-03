<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsRider
{
    /**
     * Allow only rider users to access rider routes.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('rider.login');
        }

        $user = Auth::user();

        if (!method_exists($user, 'isRider') || !$user->isRider()) {
            Auth::logout();
            return redirect()->route('rider.login')->with('error', 'Access restricted to delivery riders only.');
        }

        return $next($request);
    }
}
