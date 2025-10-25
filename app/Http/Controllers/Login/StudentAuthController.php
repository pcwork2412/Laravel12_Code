<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Students\Crud;

class StudentAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.student_login');
    }
public function login(Request $request)
{
    // ✅ Step 1: Validation
    $request->validate([
        'student_uid'  => 'required|string|max:20',
        'student_name' => 'required|string|max:100',
    ], [
        'student_uid.required'  => 'कृपया अपना Student UID दर्ज करें।',
        'student_name.required' => 'कृपया अपना नाम दर्ज करें।',
        'student_uid.string'    => 'Student UID मान्य होना चाहिए।',
        'student_name.string'   => 'नाम मान्य होना चाहिए।',
    ]);

    // ✅ Step 2: UID check
    $studentByUid = Crud::where('student_uid', $request->student_uid)->first();

    // 🧩 Step 2A: Agar UID hi galat hai
    if (!$studentByUid) {
        return back()->withErrors([
            'student_uid' => 'यह Student UID मौजूद नहीं है। कृपया सही UID दर्ज करें।'
        ])->withInput();
    }

    // 🧩 Step 2B: Agar UID sahi hai, par naam match nahi karta
    if ($studentByUid->student_name !== $request->student_name) {
        return back()->withErrors([
            'student_name' => 'आपका नाम इस UID से मेल नहीं खा रहा है। कृपया सही नाम दर्ज करें।'
        ])->withInput();
    }

    // ✅ Step 3: Status check
    if ($studentByUid->status === 'pending') {
        return back()->withErrors([
            'student_uid' => 'आपका अकाउंट अभी Pending में है। कृपया एडमिन से संपर्क करें।'
        ])->withInput();
    }

    if ($studentByUid->status === 'rejected') {
        return back()->withErrors([
            'student_uid' => 'आपका अकाउंट Reject कर दिया गया है। कृपया एडमिन से संपर्क करें।'
        ])->withInput();
    }

    if ($studentByUid->status !== 'approved') {
        return back()->withErrors([
            'student_uid' => 'आपके अकाउंट की स्थिति मान्य नहीं है।'
        ])->withInput();
    }

    // ✅ Step 4: Login success
    Session::put('role', 'student');
    Session::put('user_id', $studentByUid->student_uid);
    Session::put('user_name', $studentByUid->student_name);

    return redirect()->route('student.dashboard')->with('success', 'सफलतापूर्वक लॉगिन हो गया।');
}


    public function logout()
    {
        Session::flush();
        return redirect()->route('student.login')->with('success', 'आप सफलतापूर्वक लॉगआउट हो गए हैं।');
    }
}
