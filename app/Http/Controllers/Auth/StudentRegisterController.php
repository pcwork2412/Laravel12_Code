<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Students\Crud;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class StudentRegisterController extends Controller
{
     public function create()
    {
        return view('auth.student-register');
    }

 public function store(Request $request)
{
    // ✅ Step 0: Validate incoming request
    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|confirmed|min:8',
    ], [
        'name.required'     => 'Full Name is required.',
        'name.max'          => 'Full Name cannot exceed 255 characters.',
        'email.required'    => 'Email is required.',
        'email.email'       => 'Please enter a valid email address.',
        'email.unique'      => 'This email is already registered.',
        'password.required' => 'Password is required.',
        'password.confirmed'=> 'Passwords do not match.',
        'password.min'      => 'Password must be at least 8 characters.',
    ]);

    // ✅ Step 1: Check if email exists in cruds table (school email validation)
    $exists = Crud::where('email_id', $request->email)->exists();
    if (!$exists) {
        return back()->withErrors([
            'email' => 'Enter your school email id',
        ])->onlyInput('email');
    }

    // ✅ Step 2: Create the user
    User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'role'     => 'student',
        'status'   => 'pending', // default status
    ]);

    // ✅ Step 3: Redirect with success
    return redirect()->route('login')->with('success', 'Registration successful. Please wait for admin approval.');
}

}
