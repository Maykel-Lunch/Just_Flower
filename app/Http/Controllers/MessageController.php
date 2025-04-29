<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\User;
use App\Models\Store;

class MessageController extends Controller
{
    /**
     * Display a list of messages for the authenticated user.
     */
    public function index()
    {
        $userId = Auth::id();
        $adminId = 1; // Assuming the admin's user ID is 1

        // Fetch messages between the authenticated user and the admin
        $messages = Message::where(function ($query) use ($userId, $adminId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', $adminId);
        })->orWhere(function ($query) use ($userId, $adminId) {
            $query->where('sender_id', $adminId)
                ->where('receiver_id', $userId);
        })->orderBy('sent_at', 'asc') // Order messages by the time they were sent
        ->get();

        return view('auth.message', compact('messages'));
    }

    /**
     * Store a new message in the database.
     */
    public function store(Request $request)
    {
        $adminId = 1; // Assuming the admin's user ID is 1

        // Validate the incoming request
        $request->validate([
            'message_content' => 'required|string|max:1000', // Limit message length
        ]);

        // Create the message
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $adminId,
            'message_content' => $request->message_content,
            'sent_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Message sent successfully!');
    }
}