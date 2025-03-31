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
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'You must be logged in to view messages.');
        }

        // Fetch the store details
        $storeId = $request->query('store', 1); 
        $store = Store::select('store_id', 'store_logo', 'store_name')->find($storeId);

        // Fetch messages for the store
        $messages = Message::with(['sender', 'receiver']) ->where('receiver_id', $storeId)->orderBy('sent_at', 'asc')->get();

        return view('auth.message', compact('store', 'messages'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'You must be logged in to send messages.');
        }

        $request->validate([
            'receiver_id' => 'required|integer|exists:users,id',
            'content' => 'required|string|max:1000',
        ]);

        $message = new Message();
        $message->sender_id = Auth::id();
        $message->receiver_id = $request->input('receiver_id');
        $message->content = $request->input('content');
        $message->sent_at = now();
        $message->save();

        return redirect()->back()->with('success', 'Message sent successfully.');
    }
}
