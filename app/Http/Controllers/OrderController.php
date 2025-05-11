<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;

class OrderController extends Controller
{
    public function __construct()
    {
        // Check admin access for all methods in this controller

           // Check if user is ID 1 (admin)
        if (!Auth::check() || Auth::id() !== 1) {
            return redirect()->route('dashboard')
                ->with('error', 'Access denied. Admin privileges required.');
        }
    }

    public function index()
    {
        $orders = Order::all(); // Fetch all orders
        return view('admin.adminboard', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'delivery_status' => 'required|string',
        ]);
    
        // Convert the delivery status to lowercase before saving
        $order->delivery_status = strtolower($request->delivery_status);
    
        // Check if the status is being updated to "order received" and ensure a confirmation photo exists
        if ($order->delivery_status == 'order received' && !$order->confirmation_photo) {
            return back()->withErrors(['error' => 'Confirmation photo is required to mark as Order Received.']);
        }

        // Set received_date when status becomes delivered
        if ($order->delivery_status == 'order received') {
            $order->received_date = now();
        }

        // Create status update message
        $statusMessages = [
            'processing' => 'Your order is now being processed.',
            'ordered pickup' => 'Your order is ready for pickup.',
            'in transit' => 'Your order is now in transit.',
            'out for delivery' => 'Your order is out for delivery.',
            'order received' => 'Your order has been received.',
        ];

        $messageContent = $statusMessages[$order->delivery_status] ?? 'Your order status has been updated.';
        
        // Create message for the user
        Message::create([
            'sender_id' => 1, // Admin ID
            'receiver_id' => $order->user_id,
            'message_content' => $messageContent,
            'sent_at' => now(),
        ]);
    
        $order->save();
    
        return back()->with('success', 'Order status updated successfully.');
    }

    public function getOrders()
    {
        $orders = Order::all(); // Fetch all orders
        return response()->json($orders);
    }

    public function deliveryBoard()
    {
        if (!Auth::check() || Auth::id() !== 1) {
            return redirect()->route('dashboard')
                ->with('error', 'Access denied. Admin privileges required.');
        }
        else
        {
           // Fetch orders without a confirmation photo
            $orders = Order::whereNull('confirmation_photo')->get();
            return view('admin.deliveryboard', compact('orders')); 
        }
        
    }

    
    public function confirmDelivery(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,order_id',
            'confirmation_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Updated field name
        ]);
    
        try {
            // Get the order
            $order = Order::where('order_id', $validated['order_id'])->firstOrFail();
    
            // Handle file upload
            $file = $request->file('confirmation_photo'); // Updated field name
            $fileName = 'delivery_' . $order->order_id . '_' . time() . '.' . $file->extension();
            $filePath = 'flowershop_db/confirmation/' . $fileName;
    
            // Save the file directly to the public directory
            $file->move(public_path('flowershop_db/confirmation'), $fileName);
    
            // Generate the public URL
            $publicUrl = asset($filePath);
    
            // Update order status
            $order->update([
                'confirmation_photo' => $publicUrl,
                'delivery_status' => 'delivered',
                'delivered_at' => now(),
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Delivery confirmed successfully',
                'photo_url' => $publicUrl
            ]);
    
        } catch (\Exception $e) {
            \Log::error('Delivery confirmation failed', [
                'error' => $e->getMessage(),
                'order' => $request->order_id ?? null
            ]);
    
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request'
            ], 500);
        }
    }



    public function store(Request $request)
    {
        $request->validate([
            'total_amount' => 'required|numeric',
            'final_amount' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'product_name' => 'required|string|max:255',
        ]);
    
        // Create the order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $request->input('total_amount'),
            'final_amount' => $request->input('final_amount'),
        ]);
    
        // Save the success message to the messages table
        $messageContent = "You successfully purchased {$request->input('quantity')} {$request->input('product_name')}! Total payment: ₱{$request->input('final_amount')}";
        Message::create([
            'sender_id' => 1, // Assuming the admin's user ID is 1
            'receiver_id' => Auth::id(),
            'message_content' => $messageContent,
            'sent_at' => now(),
        ]);
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Order placed successfully!');
    }
}