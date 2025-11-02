<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AdminAuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        // Redirect if already logged in
        if (Session::has('user_id') && Session::get('role') === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        return view('auth.admin_login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'email' => 'required|email:rfc,dns',
            'password' => 'required|string|min:8',
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Enter a valid email address.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
        ]);

        // Rate limiting to prevent brute force attacks
        $key = Str::lower($request->input('email')) . '|' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            
            return back()->withErrors([
                'email' => "Too many login attempts. Please try again in {$seconds} seconds."
            ])->withInput($request->only('email'));
        }

        try {
            // Find user by email
            $admin = User::where('email', strtolower(trim($validated['email'])))->first();

            // Check if user exists
            if (!$admin) {
                RateLimiter::hit($key, 60); // Lock for 60 seconds after failed attempt
                
                return back()->withErrors([
                    'email' => 'No account found with this email address.'
                ])->withInput($request->only('email'));
            }

            // Check if user is admin
            if ($admin->role !== 'admin') {
                return back()->withErrors([
                    'email' => 'You do not have admin access.'
                ])->withInput($request->only('email'));
            }

            // Check account status
            if ($admin->status !== 'approved') {
                return back()->withErrors([
                    'email' => 'Your account is ' . $admin->status . '. Please contact administrator.'
                ])->withInput($request->only('email'));
            }

            // Verify password
            if (!Hash::check($validated['password'], $admin->password)) {
                RateLimiter::hit($key, 60);
                
                return back()->withErrors([
                    'password' => 'Incorrect password. Please try again.'
                ])->withInput($request->only('email'));
            }

            // Clear rate limiter on successful login
            RateLimiter::clear($key);

            // Create session
            Session::put([
                'role' => 'admin',
                'user_id' => $admin->id,
                'user_name' => $admin->name,
                'email' => $admin->email,
                'status' => $admin->status,
                'last_activity' => now(),
            ]);

            // Regenerate session for security
            $request->session()->regenerate();

            // Update last login (optional - add column if needed)
            // $admin->update(['last_login' => now()]);

            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Welcome back, ' . $admin->name . '!');

        } catch (\Exception $e) {
            // Log error
            Log::error('Admin Login Error: ' . $e->getMessage());
            
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['error' => 'Login failed. Please try again.']);
        }
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        // Get user info before flush
        $userName = Session::get('user_name', 'User');
        
        // Clear all session data
        Session::flush();
        
        // Regenerate session token
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()
            ->route('admin.login')
            ->with('success', 'Logged out successfully. See you soon!');
    }
}