<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function index() {
        
    }

    public function show()
    {
        $user = Auth::user(); // Get the currently authenticated user
        return view('auth.profile', compact('user'));
    }
}
