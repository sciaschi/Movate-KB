<?php

namespace App\Auth;

use Closure;
use Illuminate\Http\Request;

class AuthToken
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if (! $request->user()->hasRole($role)) {
            return redirect('dashboard');
        }

        return $next($request);
    }
}
