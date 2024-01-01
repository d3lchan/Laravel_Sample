<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        // Redirect to home page or protected area
        return redirect()->intended('home');
    } else {
        // Display error message
        return redirect()->back()->with('error', 'Invalid email or password');
    }
}
public function register(Request $request)
{
    $this->validate($request, [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // Redirect to login or home page with a success message
    return redirect()->intended('login')->with('success', 'Registration successful! Please log in.');
}

}
