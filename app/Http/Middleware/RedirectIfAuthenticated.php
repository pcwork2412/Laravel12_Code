<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next)
    {
        // Agar session me role already set hai = user logged in
        if (Session::has('role')) {
            $role = Session::get('role');

            // Role ke hisaab se redirect karo
            if ($role === 'teacher') {
                return redirect()->route('teacher.dashboard');
            }
            if ($role === 'student') {
                return redirect()->route('student.dashboard');
            }
            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
        }

        return $next($request);
    }
}
