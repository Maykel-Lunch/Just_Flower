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

    // public function index(Request $request)
    // {
    //     if (!Auth::check()) {
    //         return redirect('/login')->with('error', 'You must be logged in to view messages.');
    //     }
    
    //     // Fetch the store details
    //     $storeId = $request->query('store', 1);
    //     $store = Store::select('store_id', 'store_logo', 'store_name')->find($storeId);
    
    //     if (!$store) {
    //         return redirect()->back()->with('error', 'Store not found.');
    //     }
    
    //     // Fetch messages where the store is either the sender or the receiver
    //     // $messages = Message::with(['sender', 'receiver'])
    //     //     ->where(function ($query) use ($storeId) {
    //     //         $query->where('receiver_id', $storeId)
    //     //               ->orWhere('sender_id', $storeId);
    //     //     })
    //     //     ->orderBy('sent_at', 'asc')
    //     //     ->get();

    //     $userId = Auth::id();
    //     $messages = Message::with(['sender', 'receiver'])
    //         ->where('sender_id', $userId)
    //         ->orWhere('receiver_id', $userId)
    //         ->orderBy('sent_at', 'asc')
    //         ->get();
    
    //     return view('auth.message', compact('store', 'messages'));
    // }


}
