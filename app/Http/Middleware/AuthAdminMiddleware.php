<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class AuthAdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if(!Session::has('role') || Session::get('role') != 'admin'){
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
