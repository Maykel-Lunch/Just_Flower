<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Product;

class OrderController extends Controller
{
    public function index()
    {
        // Get orders for the current user
        $orders = Order::with(['orderItems.product'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function adminOrders()
    {
        // Check if user is admin
        if (!Auth::check() || Auth::id() !== 1) {
            return redirect()->route('dashboard')
                ->with('error', 'Access denied. Admin privileges required.');
        }

        $orders = Order::with(['orderItems.product', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

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

    public function placeOrder(Request $request)
    {
        // Log the incoming request data
        \Log::info('Order placement attempt', [
            'request_data' => $request->all(),
            'user_id' => Auth::id()
        ]);

        $request->validate([
            'total_amount' => 'required|numeric',
            'final_amount' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'product_name' => 'required|string|max:255',
            'product_id' => 'required|exists:products,product_id',
        ]);

        DB::beginTransaction();

        try {
            $product = Product::findOrFail($request->product_id);
            \Log::info('Product found', ['product' => $product->toArray()]);

            if ($product->stock_quantity < $request->quantity) {
                return redirect()->back()->with('error', 'Not enough stock available.');
            }

            // Create the order with all required fields
            $orderData = [
                'user_id' => Auth::id(),
                'total_amount' => $request->input('total_amount'),
                'final_amount' => $request->input('final_amount'),
                'payment_status' => 'pending',
                'delivery_status' => 'processing',
            ];

            \Log::info('Attempting to create order', ['order_data' => $orderData]);

            $order = Order::create($orderData);
            \Log::info('Order created', ['order' => $order->toArray()]);

            // Create order item
            $orderItemData = [
                'order_id' => $order->order_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'unit_price' => $product->price,
            ];

            \Log::info('Attempting to create order item', ['order_item_data' => $orderItemData]);
            $orderItem = OrderItem::create($orderItemData);
            \Log::info('Order item created', ['order_item' => $orderItem->toArray()]);

            // Update product stock
            $product->stock_quantity -= $request->quantity;
            $product->save();
            \Log::info('Product stock updated', ['product' => $product->toArray()]);

            // Create message
            $messageContent = "You successfully purchased {$request->input('quantity')} {$request->input('product_name')}! Total payment: ₱{$request->input('final_amount')}";
            Message::create([
                'sender_id' => 1,
                'receiver_id' => Auth::id(),
                'message_content' => $messageContent,
                'sent_at' => now(),
            ]);

            DB::commit();
            \Log::info('Transaction committed successfully');

            // Pass both order_id and product_id to the view
            return redirect()->back()->with([
                'order_success' => true,
                'order_id' => $order->order_id,
                'product_id' => $request->product_id
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Order placement failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return redirect()->back()->with('error', 'An error occurred while processing your order: ' . $e->getMessage());
        }
    }

    public function orderHistory()
    {
        $orders = Order::with(['orderItems.product'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Add pagination with 10 items per page

        return view('orders.index', compact('orders'));
    }
}