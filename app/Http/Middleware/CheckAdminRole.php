<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return $next($request);
        }
        // Check if the user is authenticated and has the 'Admin' role
        if (!Auth::user()->hasRole('Super Admin') || !Auth::user()->hasRole('Admin')) {
            // Optionally, you can redirect to a specific page or show a custom error
            // return redirect()->route('home')->with('error', 'Unauthorized.');

            // Or simply abort with a 403 Forbidden status
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
