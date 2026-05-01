<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login() {
        return view("login");
    }

    public function authentication(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email:dns', 
            'password' => 'required|max:20'
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('/dashboard')->with('success', "Selamat Datang Admin Bumdes");
        }

        // if (Auth::guard('customer')->attempt($credentials)) {
        //     return redirect()->intended('/dashboard');
        // }

        if (Auth::guard('customer')->attempt($credentials)) {
            return redirect()->intended('/');
        }

        return back()->with('loginFailed', 'Login Failed');

    }

    public function logout(Request $request) {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } else {
            Auth::guard('customer')->logout();
        }

        return redirect('/');
    }   
}
