<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        // Fetch user's notifications
        $notifications = auth()->user()->notifications; // Assuming a relationship exists
        return view('notifications.index', compact('notifications'));
    }
}