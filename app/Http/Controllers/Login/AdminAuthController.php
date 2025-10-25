<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\User;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.admin_login');
    }

  public function login(Request $request) 
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required|string|min:4',
    ], [
        'email.required'    => 'Email is required.',
        'email.email'       => 'Enter a valid email.',
        'password.required' => 'Password is required.',
        'password.min'      => 'Password must be at least 4 characters.',
    ]);

    $admin = User::where('email', $request->email)->first();

    if(!$admin){
        return back()->withErrors(['email' => 'No account found with this email.'])->withInput();
    }

    if(!Hash::check($request->password , $admin->password)){
        return back()->withErrors(['password' => 'Incorrect password.'])->withInput();
    }

    Session::put('role','admin');
    Session::put('user_id',$admin->id);
    Session::put('user_name',$admin->name);
    Session::put('email',$admin->email);
    Session::put('status',$admin->status);

    return redirect()->route('admin.dashboard');
}

    public function logout()
    {
        Session::flush();
        return redirect()->route('admin.login');
    }
}
