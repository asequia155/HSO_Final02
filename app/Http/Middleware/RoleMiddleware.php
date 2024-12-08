<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $role
     * @return mixed
     * @throws \Spatie\Permission\Exceptions\UnauthorizedException
     */
    public function handle(Request $request, Closure $next, $role = null)
    {
        // Validate that $role is a string
        if (!is_string($role)) {
            throw new \TypeError("RoleMiddleware expects a string for the \$role parameter. Got: " . gettype($role));
        }

        // Check if the user has the required role
        if (!$request->user() || !$request->user()->hasRole($role)) {
            throw UnauthorizedException::forRoles([$role]);
        }

        return $next($request);
    }
}
