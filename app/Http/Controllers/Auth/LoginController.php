<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;



class LoginController extends Controller
{
    //
    public function showLoginForm()
    {
        return view(view: 'auth.login');
    }

    public function login(Request $request)
    {
         $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    if (Auth::attempt(credentials: $credentials)) {
        $request->session()->regenerate(); // important for session security
        return redirect()->intended(default: '/index')->with('success', 'Login successful');
    }

    return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/')->with('success', 'Logged out successfully');
    }
}
