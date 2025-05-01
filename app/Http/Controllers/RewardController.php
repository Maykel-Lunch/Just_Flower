<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function index()
    {
        // Fetch user's loyalty rewards
        $rewards = auth()->user()->rewards; // Assuming a relationship exists
        return view('rewards.index', compact('rewards'));
    }
}