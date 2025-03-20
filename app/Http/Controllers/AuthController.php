<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;

class AuthController extends Controller
{

    
    // Show the login form
    public function index()
    {
        return view('auth.login');
    }

    // Handle login request
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')->withSuccess('You have successfully logged in.');
        }

        return redirect()->route('login')->withErrors('Invalid login credentials.');
    }

    // Show the registration form
    public function registration()
    {
        return view('auth.registration');
    }

    // Handle registration request
    public function postRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $data = $request->all();
        $data['password'] = bcrypt($data['password']); // Hash the password

        User::create($data);

        return redirect()->route('dashboard')->withSuccess('Registration successful. Please log in.');
    }

    // Show the dashboard
    public function dashboard()
    {
        if (Auth::check()) {
            $stores = Store::all(); 
            $products = Product::all();
            return view('auth.dashboard', compact('stores', 'products'));
        }

        return redirect()->route('login')->withErrors('You need to log in first.');
    }

    // Handle logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->withSuccess('You have successfully logged out.');
    }
}