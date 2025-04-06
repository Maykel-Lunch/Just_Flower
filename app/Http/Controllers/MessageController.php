<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\User;
use App\Models\Store;

class MessageController extends Controller
{
    // Working (if everything become worse)
    // public function index(Request $request)
    // {
    //     if (!Auth::check()) {
    //         return redirect('/login')->with('error', 'You must be logged in to view messages.');
    //     }

    //     // Fetch the store details
    //     $storeId = $request->query('store', 1); 
    //     $store = Store::select('store_id', 'store_logo', 'store_name')->find($storeId);

    //     // Fetch messages for the store
    //     $messages = Message::with(['sender', 'receiver']) ->where('receiver_id', $storeId)->orderBy('sent_at', 'asc')->get();

    //     return view('auth.message', compact('store', 'messages'));
    // }

    public function index()
    {
        $userId = Auth::id();
        $messages = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->orderBy('sent_at', 'desc')
            ->with('store')
            ->get();

        return view('auth.message', compact('messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message_content' => 'required|string'
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message_content' => $request->message_content,
        ]);

        return redirect()->back()->with('success', 'Message sent successfully!');
    }
}
