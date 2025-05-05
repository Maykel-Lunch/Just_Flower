<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    // public function index()
    // {
    //     // Fetch user's order history
    //     $orders = auth()->user()->orders; // Assuming a relationship exists
    //     return view('orders.index', compact('orders'));
    // }

    // public function checkFreeShipping()
    // {
    //     $user = auth()->user(); // Get the authenticated user

    //     // Check if the user has any previous orders
    //     $hasOrderHistory = $user->orders()->exists();

    //     // Determine free shipping eligibility
    //     $freeShipping = !$hasOrderHistory; // Free shipping if no order history

    //     // Return the result as JSON (useful for AJAX or API calls)
    //     return response()->json(['freeShipping' => $freeShipping]);
    // }

    
    // public function showOrders()
    // {
    //     $user = auth()->user(); // Get the authenticated user
    
    //     // Check if the user has an order history
    //     $hasOrderHistory = $user->orders()->exists();
    
    //     // Determine free shipping eligibility
    //     $freeShipping = !$hasOrderHistory; // Free shipping if no order history
    
    //     // Pass the variables to the view
    //     return view('product', compact('freeShipping'));
    // }
}