<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role, $permission = null)
    {
        $user = Auth::user();

        if ($user->hasRole($role)) {
            // Check if the user also has a specific permission if provided
            if ($permission && !$user->roles()->first()->permissions()->where('name', $permission)->exists()) {
                return response()->json(['message' => 'Forbidden: Missing permission.'], 403);
            }

            return $next($request);
        }

        return response()->json(['message' => 'Forbidden: You do not have the required role.'], 403);
    }
}
