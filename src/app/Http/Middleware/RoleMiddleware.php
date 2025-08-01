<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|array  $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth('api')->user();
        if (!$user || !in_array($user->role, $roles)) {
            return response()->json(['message' => '無權限'], 403);
        }
        return $next($request);
    }
}
