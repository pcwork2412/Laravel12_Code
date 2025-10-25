<?php

namespace App\Http\Controllers\Password;

use App\Http\Controllers\Controller;
use App\Models\Teacher\TeacherCrud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class TeacherPasswordController extends Controller
{
  

public function passwordUpdate(Request $request)
{
    $request->validate([
        'current_password' => 'required|string|min:6',
        'new_password'     => 'required|string|min:6|different:current_password',
        'confirm_password' => 'required|same:new_password',
    ], [
        'current_password.required' => 'कृपया अपना वर्तमान पासवर्ड दर्ज करें।',
        'new_password.required'     => 'कृपया नया पासवर्ड दर्ज करें।',
        'confirm_password.same'     => 'नया और पुष्टि पासवर्ड एक जैसे होने चाहिए।',
    ]);

    // ✅ Step 1: Current teacher find करें
    $teacherId = Session::get('id');
    $teacher = TeacherCrud::find($teacherId);

    if (!$teacher) {
        return response()->json(['message' => 'User not found.'], 404);
    }

    // ✅ Step 2: Current password verify करें
    if (!Hash::check($request->current_password, $teacher->password)) {
        return response()->json(['message' => 'वर्तमान पासवर्ड गलत है।'], 422);
    }

    // ✅ Step 3: नया password save करें
    $teacher->password = Hash::make($request->new_password);
    // $teacher->is_first_login = false; // अगर आपने flag इस्तेमाल किया है
    $teacher->save();

    // ✅ Step 4: Response return करें
    return response()->json([
        'message' => 'पासवर्ड सफलतापूर्वक अपडेट हो गया है।'
    ]);
}

}
