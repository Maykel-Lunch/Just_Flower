<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
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
        // Fetch orders without a confirmation photo
        $orders = Order::whereNull('confirmation_photo')->get();
        return view('admin.deliveryboard', compact('orders'));
    }

    public function confirmDelivery(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'orderId' => 'required|exists:orders,order_id',
            'deliveryProof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        try {
            // Get the order with authorization check
            $order = Order::where('order_id', $validated['orderId'])->firstOrFail();
            
            // Verify the user has permission to confirm this delivery
            if (!auth()->user()->can('confirm-delivery', $order)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action'
                ], 403);
            }
    
            // Handle file upload
            $file = $request->file('deliveryProof');
            $fileName = 'delivery_' . $order->order_id . '_' . time() . '.' . $file->extension();
            $filePath = $file->getPathname();
    
            // Supabase upload configuration
            $supabaseUrl = config('services.supabase.url');
            $supabaseKey = config('services.supabase.key');
            $bucketName = config('services.supabase.bucket', 'photo-confirmation');
    
            // Initialize cURL
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => "$supabaseUrl/storage/v1/object/$bucketName/$fileName",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => file_get_contents($filePath),
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer $supabaseKey",
                    "Content-Type: " . $file->getMimeType(),
                    "Cache-Control: no-cache",
                ],
                CURLOPT_TIMEOUT => 30,
            ]);
    
            $response = curl_exec($ch);
            $error = curl_error($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
    
            // Handle upload failure
            if ($error || !in_array($httpCode, [200, 201])) {
                \Log::error('Supabase upload failed', [
                    'error' => $error,
                    'response' => $response,
                    'code' => $httpCode
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to upload delivery proof'
                ], 500);
            }
    
            // Update order status
            $publicUrl = "$supabaseUrl/storage/v1/object/public/$bucketName/$fileName";
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
                'order' => $request->orderId ?? null
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