<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminRegisterController extends Controller
{
    // Show registration form
public function showRegisterForm()
{
    return view('auth.admin_register');
}

// Handle registration
public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|confirmed|min:4', // password_confirmation field must be present in form
    ], [
        'name.required'     => 'Name is required.',
        'email.required'    => 'Email is required.',
        'email.email'       => 'Enter a valid email.',
        'email.unique'      => 'Email already exists.',
        'password.required' => 'Password is required.',
        'password.confirmed'=> 'Passwords do not match.',
        'password.min'      => 'Password must be at least 4 characters.',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'admin',
        'status' => 'approved',
    ]);

    // Automatically log in the user after registration (optional)
    Session::put('role', 'admin');
    Session::put('user_id', $user->id);
    Session::put('user_name', $user->name);
    Session::put('email', $user->email);
    Session::put('status', $user->status);

    return redirect()->route('admin.dashboard')->with('success', 'Registration successful!');
}

}
