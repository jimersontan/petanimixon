<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        if (! method_exists($user, 'adminRole') || ! $user->isAdmin()) {
            return redirect()->route('home')->with('message', 'You do not have access to this area.');
        }

        $role = $user->adminRole();
        if (! $role || ! in_array($role, $roles, true)) {
            return redirect()->route('dashboard')->with('message', 'You do not have access to this area.');
        }

        return $next($request);
    }
}
