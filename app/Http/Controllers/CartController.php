<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        // Validate the request
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Retrieve the product
        $product = Product::findOrFail($request->product_id);

        // Check if there's enough stock
        if ($product->stock_quantity < $request->quantity) {
            return redirect()->back()->with('error', 'Not enough stock available.');
        }

        // Check if the product is already in the cart
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->product_id)
            ->first();

        if ($cartItem) {
            // Check if adding the new quantity would exceed stock
            if (($cartItem->quantity + $request->quantity) > $product->stock_quantity) {
                return redirect()->back()->with('error', 'Not enough stock available.');
            }
            
            // Update the quantity if the product is already in the cart
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // Add the product to the cart
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->product_id,
                'quantity' => $request->quantity,
                'price' => $product->price,
            ]);
        }

        return redirect()->back()->with('cart_success', 'Product added to cart!');
    }

    public function viewCart()
    {
        // Retrieve all cart items for the authenticated user
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        // Pass the cart items to the cart view
        return view('cart.index', compact('cartItems'));
    }

    public function removeFromCart($id)
    {
        // Find the cart item by ID and ensure it belongs to the authenticated user
        $cartItem = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Delete the cart item
        $cartItem->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Item removed from cart successfully!');
    }

    public function clearCart(){
        Cart::where('user_id', Auth::id())->delete();
        return redirect()->back()->with('success', 'Cart cleared successfully!');
    }
}
