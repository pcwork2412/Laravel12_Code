<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use App\Models\Students\Crud;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.student_login');
    }
public function store(LoginRequest $request): RedirectResponse
{
    // ✅ Step 0: Validation
    $request->validate([
        'email'    => ['required', 'email'],
        'password' => ['required', 'string'],
    ], [
        'email.required' => 'Email is required.',
        'email.email'    => 'Enter a valid email address.',
        'password.required' => 'Password is required.',
    ]);

    $email = $request->email;
    $password = $request->password;

    try {
        // =========================
        // ✅ Teacher Login
        // =========================
        $teacher = \App\Models\Teacher\TeacherCrud::where('email', $email)->first();
        if ($teacher && $teacher->role === 'teacher') {

            if (!Hash::check($password, $teacher->password)) {
                return back()->withErrors(['password' => 'Incorrect password.'])->withInput();
            }

            // Status check
            if ($teacher->status === 'pending') {
                return back()->withErrors(['email' => 'Your account is not approved yet by admin.'])->withInput();
            } elseif ($teacher->status === 'rejected') {
                return back()->withErrors(['email' => 'Your account has been rejected by admin.'])->withInput();
            }

            // Approved → login
            auth()->guard('teacher')->login($teacher);
            $request->session()->regenerate();

            return redirect()->route('teacher_dashboard')->with('success', 'Teacher login successful.');
        }

        // =========================
        // ✅ Student Login
        // =========================
        $student = \App\Models\Students\Crud::where('email', $email)->first();
        if ($student && $student->role === 'student') {

            $user = \App\Models\User::where('email', $email)->first();

            if (!$user || !Hash::check($password, $user->password)) {
                return back()->withErrors(['password' => 'Incorrect password.'])->withInput();
            }

            if ($user->status === 'pending') {
                return back()->withErrors(['email' => 'Your account is not approved yet by admin.'])->withInput();
            } elseif ($user->status === 'rejected') {
                return back()->withErrors(['email' => 'Your account has been rejected by admin.'])->withInput();
            }

            auth()->guard('student')->login($student);
            $request->session()->regenerate();

            return redirect()->route('student_dashboard')->with('success', 'Student login successful.');
        }

        // =========================
        // ✅ Admin Login
        // =========================
        $admin = \App\Models\User::where('email', $email)->where('role', 'admin')->first();
        if ($admin) {
            if (!Hash::check($password, $admin->password)) {
                return back()->withErrors(['password' => 'Incorrect password.'])->withInput();
            }

            if ($admin->status === 'pending') {
                return back()->withErrors(['email' => 'Your admin account is not approved yet.'])->withInput();
            } elseif ($admin->status === 'rejected') {
                return back()->withErrors(['email' => 'Your admin account has been rejected.'])->withInput();
            }

            auth()->guard('admin')->login($admin);
            $request->session()->regenerate();

            return redirect()->route('admin_dashboard')->with('success', 'Admin login successful.');
        }

        // =========================
        // Invalid email fallback
        // =========================
        return back()->withErrors(['email' => 'No account found with this email.'])->withInput();

    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'Login failed: ' . $e->getMessage()])->withInput();
    }
}







    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        // ✅ Determine logged-in guard dynamically
        if (auth()->guard('admin')->check()) {
            auth()->guard('admin')->logout();
        } elseif (auth()->guard('teacher')->check()) {
            auth()->guard('teacher')->logout();
        } elseif (auth()->guard('student')->check()) {
            auth()->guard('student')->logout();
        }

        // ✅ Invalidate session & regenerate CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logged out successfully.');
    }
}
