<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (Response) $next
     * @return mixed|Response
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and has the 'Admin' role
        if (Auth::user() && !Auth::user()->hasAnyRole(['Super Admin', 'Admin'])) {
            // Or simply abort with a 403 Forbidden status
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
