<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Fetch user's order history
        $orders = auth()->user()->orders; // Assuming a relationship exists
        return view('orders.index', compact('orders'));
    }
}