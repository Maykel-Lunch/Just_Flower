<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\User;

class MessageController extends Controller
{
    /**
     * Display a list of messages for the authenticated user.
     */
    
public function index(Request $request)
{
    $adminId = 1; // Assuming the admin's user ID is 1
    $currentUserId = Auth::id(); // Get the currently authenticated user's ID

    if ($currentUserId === $adminId) {
        $selectedUserId = $request->query('user_id'); // Get the selected user ID from the query string

        // Fetch all users who have messaged the admin or been messaged by the admin
        $users = Message::where('receiver_id', $adminId)
            ->orWhere('sender_id', $adminId)
            ->with(['sender', 'receiver'])
            ->get()
            ->map(function ($message) use ($adminId) {
                return $message->sender_id === $adminId ? $message->receiver : $message->sender;
            })
            ->unique('id')
            ->map(function ($user) {
                $user->recent_message = Message::where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id)
                    ->latest('sent_at')
                    ->value('message_content');
                return $user;
            });

        // Fetch messages with the selected user
        $messages = [];
        if ($selectedUserId) {
            $messages = Message::where(function ($query) use ($adminId, $selectedUserId) {
                $query->where('sender_id', $adminId)
                    ->where('receiver_id', $selectedUserId);
            })->orWhere(function ($query) use ($adminId, $selectedUserId) {
                $query->where('sender_id', $selectedUserId)
                    ->where('receiver_id', $adminId);
            })->orderBy('sent_at', 'asc')->get();
        }

        return view('auth.message', compact('users', 'messages', 'selectedUserId'));
    }

    // For regular users, show a simplified chat interface with the admin
    $messages = Message::where(function ($query) use ($adminId, $currentUserId) {
        $query->where('sender_id', $adminId)
            ->where('receiver_id', $currentUserId);
    })->orWhere(function ($query) use ($adminId, $currentUserId) {
        $query->where('sender_id', $currentUserId)
            ->where('receiver_id', $adminId);
    })->orderBy('sent_at', 'asc')->get();

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