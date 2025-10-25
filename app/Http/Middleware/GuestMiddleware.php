<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class GuestMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Session::has('role')) {
            switch (Session::get('role')) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'teacher':
                    return redirect()->route('teacher.dashboard');
                case 'student':
                    return redirect()->route('student.dashboard');
            }
        }

        return $next($request);
    }
}
