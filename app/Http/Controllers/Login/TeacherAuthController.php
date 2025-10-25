<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Teacher\TeacherCrud;
use Illuminate\Support\Facades\Hash;

class TeacherAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.teacher_login');
    }

    public function login(Request $request)
    {
        // ✅ Step 1: Validation
        $request->validate([
            'teacher_id'   => 'required|string|max:20',
            'teacher_name' => 'required|string|max:100',
            'password'     => 'required|string|min:6',
        ], [
            'teacher_id.required'   => 'कृपया अपना Teacher ID दर्ज करें।',
            'teacher_name.required' => 'कृपया अपना नाम दर्ज करें।',
            'teacher_id.string'     => 'Teacher ID मान्य होना चाहिए।',
            'teacher_name.string'   => 'नाम मान्य होना चाहिए।',
            'password.required'     => 'कृपया अपना पासवर्ड दर्ज करें।',
        ]);

        // ✅ Step 2: Teacher record fetch
        $teacherById = TeacherCrud::where('teacher_id', $request->teacher_id)->first();

        // 🧩 Step 2A: Agar Teacher ID hi galat hai
        if (!$teacherById) {
            return back()->withErrors([
                'teacher_id' => 'यह Teacher ID मौजूद नहीं है। कृपया सही ID दर्ज करें।'
            ])->withInput();
        }

        // 🧩 Step 2B: Ab ID sahi hai par name galat hai
        if ($teacherById->teacher_name !== $request->teacher_name) {
            return back()->withErrors([
                'teacher_name' => 'आपका नाम इस ID से मेल नहीं खा रहा है। कृपया सही नाम दर्ज करें।'
            ])->withInput();
        }

        // 🧩 Step 2C: Ab ID sahi hai par name sahi hai par password galat hai
        if (!Hash::check($request->password, $teacherById->password)) {
            return back()->withErrors([
                'password' => 'आपका पासवर्ड इस ID से मेल नहीं खा रहा है। कृपया सही पासवर्ड दर्ज करें।'
            ])->withInput();
        }

        // ✅ Step 3: Status check
        if ($teacherById->status === 'pending') {
            return back()->withErrors([
                'teacher_id' => 'आपका अकाउंट अभी Pending में है। कृपया एडमिन से संपर्क करें।'
            ])->withInput();
        }

        if ($teacherById->status === 'rejected') {
            return back()->withErrors([
                'teacher_id' => 'आपका अकाउंट Reject कर दिया गया है। कृपया एडमिन से संपर्क करें।'
            ])->withInput();
        }

        if ($teacherById->status !== 'approved') {
            return back()->withErrors([
                'teacher_id' => 'आपके अकाउंट की स्थिति मान्य नहीं है।'
            ])->withInput();
        }

        // ✅ Step 4: Login success
        Session::put('role', 'teacher');
        Session::put('id', $teacherById->id);
        Session::put('user_id', $teacherById->teacher_id);
        Session::put('user_name', $teacherById->teacher_name);
        Session::put('password', $teacherById->password);


        return redirect()->route('teacher.dashboard')->with('success', 'सफलतापूर्वक लॉगिन हो गया।');
    }


    public function logout()
    {
        Session::flush();
        return redirect()->route('teacher.login')->with('success', 'आप सफलतापूर्वक लॉगआउट हो गए हैं।');
    }
}
