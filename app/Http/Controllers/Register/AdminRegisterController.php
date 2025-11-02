<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminRegisterController extends Controller
{
    /**
     * Show registration form
     */
    public function showRegisterForm()
    {
        // Redirect if already logged in
        if (Session::has('user_id') && Session::get('role') === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        return view('auth.admin_register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255|min:2',
            'email' => 'required|string|email:rfc,dns|max:255|unique:users,email',
            'password' => 'required|string|confirmed|min:8', // Changed from 4 to 8 for security
        ], [
            'name.required' => 'Name is required.',
            'name.min' => 'Name must be at least 2 characters.',
            'email.required' => 'Email is required.',
            'email.email' => 'Enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min' => 'Password must be at least 8 characters for security.',
        ]);

        try {
            // Use transaction for data integrity
            DB::beginTransaction();

            // Create user
            $user = User::create([
                'name' => trim($validated['name']),
                'email' => strtolower(trim($validated['email'])),
                'password' => Hash::make($validated['password']),
                'role' => 'admin',
                'status' => 'approved',
            ]);

            // Create session
            Session::put([
                'role' => 'admin',
                'user_id' => $user->id,
                'user_name' => $user->name,
                'email' => $user->email,
                'status' => $user->status,
            ]);

            // Regenerate session for security
            $request->session()->regenerate();

            DB::commit();

            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Registration successful! Welcome, ' . $user->name);

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log error
            Log::error('Admin Registration Error: ' . $e->getMessage());
            
            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['error' => 'Registration failed. Please try again.']);
        }
    }
}