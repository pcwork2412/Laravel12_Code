<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Students\Crud;
use App\Models\Teacher\TeacherCrud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // login form blade
    }

    public function login(Request $request)
    {
        $request->validate([
            // 'role' => 'required|in:student,teacher',
            'id'   => 'required|string',
            'name' => 'required|string',
            // 'password' => 'required|string',
        ]);

        $role = 'teacher';
        $id   = $request->id;
        $name = $request->name;
        // $password = $request->password;

        if ($role == 'teacher') {
            $user = TeacherCrud::where('teacher_id', $id)->where('teacher_name', $name)->first();
        } elseif ($role == 'student') {
            $user = Crud::where('student_uid', $id)->where('student_name', $name)->first();
        }

        if (!$user) {
            return back()
                ->withInput()       // input fields retain honge
                ->with('error', 'Invalid ID or Name');
        }


        // Password check
        // if(!Hash::check($password, $user->password)) {
        //     return back()->with('error', 'Invalid Password');
        // }

        // Save session
        Session::put('role', $role);

        if ($role == 'teacher') {
            Session::put('user_id', $user->teacher_id);
            Session::put('user_name', $user->teacher_name);
        } elseif ($role == 'student') {
            Session::put('user_id', $user->student_uid);
            Session::put('user_name', $user->student_name);
        }


        // Redirect based on role
        if ($role == 'teacher') return redirect()->route('teacher_dashboard');
        if ($role == 'student') return redirect()->route('student_dashboard');
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('login');
    }
}
