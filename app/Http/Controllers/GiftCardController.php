<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GiftCard;

class GiftCardController extends Controller
{
    public function index()
    { 
        $user = auth()->user(); // Get the authenticated user

        // Fetch the gift cards owned by the user
        $giftCards = GiftCard::where('user_id', $user->id)->get();

        // Return the view with the gift cards
        return view('gift-cards.index', compact('giftCards'));
    }


    public function availGiftCard(Request $request)
    {
        $user = auth()->user(); // Get the authenticated user

        // Check if the user is authorized
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to avail a gift card.');
        }

        // Create a new gift card for the user
        $giftCard = GiftCard::create([
            'user_id' => $user->id,
            'member_id' => uniqid(), // Generate a unique member ID
            'membership_lvl' => 'Basic', // Default membership level
            'member_since' => now(),
            'birthday_discount' => 10, // Example discount
            'membership_requirements' => 'None',
            'member_code' => strtoupper(Str::random(10)), // Generate a random member code
        ]);

        return redirect()->route('gift-cards.index')->with('success', 'Gift card availed successfully!');
    }
}
