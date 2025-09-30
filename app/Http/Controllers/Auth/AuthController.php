<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Role-based redirect
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'restaurant_owner': // updated
                    return redirect()->route('owner.dashboard');
                case 'customer':
                    return redirect()->route('user.home');
                default:
                    Auth::logout();
                    return redirect()->route('login')->withErrors('Unknown role!');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Show register form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|confirmed|min:6',
        'tel' => 'nullable|string|max:15',
    ]);

    // Auto-assign role based on email
    if ($request->email === 'admin@swiftdine.com') {
        $role = 'admin';
    } elseif ($request->email === 'owner@swiftdine.com') {
        $role = 'restaurant';
    } else {
        $role = 'customer';
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'tel' => $request->tel,
        'password' => Hash::make($request->password),
        'role' => $role,
    ]);

    Auth::login($user);

    // Redirect by role
    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'restaurant':
            return redirect()->route('owner.dashboard');
        case 'customer':
            return redirect()->route('user.home');
    }
}

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
