<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Kiểm tra đăng nhập
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();

        // 2. Kiểm tra tồn tại role
        if (empty($user->roles)) {
            return response()->json(['message' => 'Role not assigned'], Response::HTTP_FORBIDDEN);
        }

        $userRoleNames = $user->roles->pluck('role_name')->toArray();
        $hasPermission = !empty(array_intersect($roles, $userRoleNames));

        if (!$hasPermission) {
            return response()->json(['message' => 'Forbidden'], Response::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}
