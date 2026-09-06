<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show Login form
    public function showLoginForm()
    {
        if (Auth::check()) {
            return Auth::user()->is_admin 
                ? redirect()->route('admin.dashboard')
                : redirect()->route('home');
        }
        return view('login');
    }

    // Show Register form
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('register');
    }

    // Handle user registration
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'phone'    => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'is_admin' => false,
        ]);

        // Automatically log in the user after registration
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Registration successful! Welcome to Advance Travel.');
    }

    // Handle login attempt
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->is_admin) {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome to Admin Dashboard!');
            }

            return redirect()->intended(route('home'))->with('success', 'Logged in successfully as ' . $user->name . '!');
        }

        return back()
            ->withErrors(['email' => 'Invalid email or password. Please try again.'])
            ->onlyInput('email');
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'You have been logged out successfully.');
    }
}
