<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and has an admin role
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request); // Allow access
        }

        // Redirect non-admin users to the home page or show a 403 error
        return redirect('/')->with('error', 'You do not have access to this page.');
    }
}