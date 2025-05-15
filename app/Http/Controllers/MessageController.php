<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\User;

class MessageController extends Controller
{
    /**
     * Display a list of users and messages for the admin or authenticated user.
     */
    
public function index(Request $request)
{
    $adminId = 1; // Assuming the admin's user ID is 1
    $currentUserId = Auth::id();

    if ($currentUserId === $adminId) {
        $selectedUserId = $request->query('user_id');
        $selectedUser = null;

        // Get all unique users who have conversations with admin, excluding admin
        $users = User::where('id', '!=', $adminId) // Exclude admin from the list
            ->whereHas('sentMessages', function($query) use ($adminId) {
                $query->where('receiver_id', $adminId);
            })->orWhereHas('receivedMessages', function($query) use ($adminId) {
                $query->where('sender_id', $adminId);
            })->with(['sentMessages' => function($query) use ($adminId) {
                $query->where('receiver_id', $adminId)
                      ->select('sender_id', 'receiver_id', 'message_content', 'sent_at')
                      ->latest('sent_at');
            }, 'receivedMessages' => function($query) use ($adminId) {
                $query->where('sender_id', $adminId)
                      ->select('sender_id', 'receiver_id', 'message_content', 'sent_at')
                      ->latest('sent_at');
            }])->get()
            ->map(function ($user) use ($adminId) {
                $latestMessage = $user->sentMessages->merge($user->receivedMessages)
                    ->sortByDesc('sent_at')
                    ->first();

                $user->recent_message = $latestMessage ? $latestMessage->message_content : null;
                $user->latest_message_time = $latestMessage ? $latestMessage->sent_at : null;
                
                unset($user->sentMessages);
                unset($user->receivedMessages);
                
                return $user;
            })
            ->sortByDesc('latest_message_time');

        // Get the selected user's data with full user information
        if ($selectedUserId) {
            $selectedUser = User::select('id', 'name', 'profile')
                              ->where('id', $selectedUserId)
                              ->first();
        }

        // Fetch messages with the selected user
        $messages = [];
        if ($selectedUserId) {
            $messages = Message::with(['sender' => function($query) {
                $query->select('id', 'name', 'profile');
            }])
            ->where(function($query) use ($adminId, $selectedUserId) {
                $query->where('sender_id', $adminId)
                      ->where('receiver_id', $selectedUserId);
            })->orWhere(function($query) use ($adminId, $selectedUserId) {
                $query->where('sender_id', $selectedUserId)
                      ->where('receiver_id', $adminId);
            })
            ->orderBy('sent_at', 'asc')
            ->get();
        }

        return view('auth.message', compact('users', 'messages', 'selectedUserId', 'selectedUser'));
    }

    // For regular users, show a simplified chat interface with the admin
    $messages = Message::with(['sender' => function($query) {
        $query->select('id', 'name', 'profile');
    }])
    ->where(function ($query) use ($adminId, $currentUserId) {
        $query->where('sender_id', $adminId)
            ->where('receiver_id', $currentUserId);
    })->orWhere(function ($query) use ($adminId, $currentUserId) {
        $query->where('sender_id', $currentUserId)
            ->where('receiver_id', $adminId);
    })->orderBy('sent_at', 'asc')->get();

    return view('auth.message', compact('messages', 'adminId'));
}

    /**
     * Store a new message in the database.
     */
    public function store(Request $request)
    {
        $currentUserId = Auth::id(); // Get the currently authenticated user's ID

        // Validate the incoming request
        $request->validate([
            'message_content' => 'required|string|max:1000', // Limit message length
            'receiver_id' => 'required|exists:users,id',     // Ensure the receiver exists
        ]);

        // Create the message
        Message::create([
            'sender_id' => $currentUserId,
            'receiver_id' => $request->receiver_id,
            'message_content' => $request->message_content,
            'sent_at' => now(),
        ]);

        return redirect()->route('messages.index', ['user_id' => $request->receiver_id])
            ->with('success', 'Message sent successfully!');
    }

    public function fetchMessages(Request $request)
    {
        $adminId = 1;
        $currentUserId = Auth::id();
        $selectedUserId = $request->query('user_id');

        $messages = Message::with(['sender' => function($query) {
            $query->select('id', 'name', 'profile')
                  ->withDefault(['profile' => null]);
        }])
        ->where(function ($query) use ($adminId, $selectedUserId, $currentUserId) {
            $query->where('sender_id', $currentUserId)
                  ->where('receiver_id', $selectedUserId);
        })
        ->orWhere(function ($query) use ($adminId, $selectedUserId, $currentUserId) {
            $query->where('sender_id', $selectedUserId)
                  ->where('receiver_id', $currentUserId);
        })
        ->orderBy('sent_at', 'asc')
        ->get();

        // Add debug logging
        \Log::info('Messages data:', [
            'count' => $messages->count(),
            'sample' => $messages->first() ? [
                'sender_id' => $messages->first()->sender_id,
                'sender_name' => $messages->first()->sender->name ?? 'null',
                'sender_profile' => $messages->first()->sender->profile ?? 'null'
            ] : 'no messages'
        ]);

        return response()->json($messages);
    }

    public function latest()
    {
        $userId = auth()->id();

        // Fetch the latest message for each conversation involving the authenticated user
        $latestMessages = Message::with(['sender', 'receiver'])
            ->whereIn('id', function ($query) use ($userId) {
                $query->selectRaw('MAX(id)')
                    ->from('messages')
                    ->where(function ($q) use ($userId) {
                        $q->where('sender_id', $userId)
                        ->orWhere('receiver_id', $userId);
                    })
                    ->groupByRaw('LEAST(sender_id, receiver_id), GREATEST(sender_id, receiver_id)');
            })
            ->orderBy('sent_at', 'DESC')
            ->get();

        // Map the latest messages to users and sort them by the latest message time
        $users = $latestMessages->map(function ($message) use ($userId) {
            $user = $message->sender_id === $userId ? $message->receiver : $message->sender;
            $user->recent_message = $message->message_content;
            $user->latest_message_time = $message->sent_at;
            return $user;
        })->sortByDesc('latest_message_time')->unique('id'); // Ensure unique users

        return response()->json($users);
    }
}
