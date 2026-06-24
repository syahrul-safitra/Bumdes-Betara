<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login() {

    if (Auth::guard('admin')->check() || Auth::guard('admin')->check()) {
        return redirect('/');
    }

        return view("login");
    }

    public function authentication(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email:dns', 
            'password' => 'required|max:20'
        ]);

        if ( Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('/dashboard')->with('success', "Selamat Datang " . Auth::guard('admin')->user()->name . " Bumdes");
        }

        if (Auth::guard('customer')->attempt($credentials)) {
            return redirect()->intended('/');
        }

        return back()->with('loginFailed', 'Login Failed');

    }

    public function logout(Request $request) {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('customer')->check()) {
            Auth::guard('customer')->logout();
        } else {
            Auth::guard('spp')->logout();
        }

        return redirect('/');
    }   

    public function loginSpp() {

    if (Auth::guard('admin')->check() || Auth::guard('admin')->check() || Auth::guard('spp')->check()) {
        return redirect('/');
    }

        return view("login-spp");
    }

    public function authenticationSpp(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email:dns', 
            'password' => 'required|max:20'
        ]);

        if (Auth::guard('spp')->attempt($credentials)) {
            return redirect()->intended('/spp-dashboard');
        }

        return back()->with('loginFailed', 'Login Failed');
    }
    
}
