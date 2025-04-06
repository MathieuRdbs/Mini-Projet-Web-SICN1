<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $validation = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ],[
            'email.email' => 'Please enter a valid email address.',
            'email.required' => 'The email field is required.',
            'password.required' => 'The password field is required.',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('users');
            }
            return redirect()->route('homepage')->with('success', 'You have been logged in.');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phonenumber' => 'required|string|max:20',
        ],[
            'fullname.required' => 'the full name field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'this email is already used.',
            'email.required' => 'The email field is required.',
            'password.required' => 'The password field is required.',
            'password.min' => 'the password is below the length authorized.',
            'phonenumber.required' => 'The phone field is required.',
            'phonenumber.max' => 'the phone length does not match',
        ]);

        $user = User::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phonenumber' => $request->phonenumber,
        ]);

        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('homepage')->with('success', 'You have been registered and logged in.');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('homepage')->with('success', 'You have been logged out successfully.');
    }
}