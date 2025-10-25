<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class ProfileController extends Controller
{
    public function show(){
        if(session('role') == 'admin'){
            return view('profile.show');
        }
    }
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $request->user()->update(
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
            ])
        );

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request)
    {
        $request->user()->delete();
        FacadesAuth::logout();
        return redirect('/');
    }
}
