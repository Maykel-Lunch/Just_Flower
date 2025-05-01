<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GiftCardController extends Controller
{
    public function index()
    {
        // Fetch user's gift cards
        $giftCards = auth()->user()->giftCards; // Assuming a relationship exists
        return view('gift-cards.index', compact('giftCards'));
    }
}
