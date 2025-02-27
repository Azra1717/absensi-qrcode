<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            if ($user->role === 'admin') {
                return redirect('/admin/siswa');
            } else {
                return redirect('/siswa');
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
