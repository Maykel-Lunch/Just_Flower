<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Wishlist;
use App\Models\Cart;
use Carbon\Carbon;


class ProfileController extends Controller
{
    public function index() {
        
    }

    public function show()
    {
        $user = auth()->user();

        // Fetch the latest wishlist items
        $wishlistItems = Wishlist::where('user_id', $user->id)
            ->join('products', 'wishlists.product_id', '=', 'products.product_id')
            ->select('wishlists.*', 'products.product_name')
            ->orderBy('wishlists.created_at', 'desc')
            ->get();

        // Filter based on the conditions
        $recentWishlistItems = $wishlistItems->filter(function ($item) {
            return Carbon::parse($item->created_at)->greaterThanOrEqualTo(Carbon::now()->subDay());
        });

        // If there are recent items (1 day ago), take up to 5
        if ($recentWishlistItems->isNotEmpty()) {
            $wishlistItems = $recentWishlistItems->take(3);
        } else {
            // Otherwise, take the latest 3 items
            $wishlistItems = $wishlistItems->take(2);
        }

        // Fetch cart items
        $cartItems = Cart::where('user_id', $user->id)->get();
        $cartCount = $cartItems->count();
        $cartTotal = $cartItems->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->product->price; // Assuming each cart item has a product relationship
        });

        $wishlist = Wishlist::where('user_id', $user->id)->get();
        $wishlistCount = $wishlist->count();
        return view('auth.profile', [
            'user' => $user,
            'wishlistItems' => $wishlistItems,
            'wishlistCount' => $wishlistCount,
            'cartCount' => $cartCount,
            'cartTotal' => $cartTotal,
        ]);
    }
}
