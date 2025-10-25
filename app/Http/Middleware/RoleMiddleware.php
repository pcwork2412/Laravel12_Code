<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
 public function handle($request, Closure $next, ...$roles)
{
    $currentRole = session('role');

    // Agar current role allowed roles me nahi hai
    if (!$currentRole || !in_array($currentRole, $roles)) {
        return redirect('/login');
    }

    return $next($request);
}


}
