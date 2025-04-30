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
    /**
     * Display the user's profile page.
     */
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

        // If there are recent items (1 day ago), take up to 3
        if ($recentWishlistItems->isNotEmpty()) {
            $wishlistItems = $recentWishlistItems->take(3);
        } else {
            // Otherwise, take the latest 2 items
            $wishlistItems = $wishlistItems->take(2);
        }

        // Fetch cart items
        $cartItems = Cart::where('user_id', $user->id)->get();
        $cartCount = $cartItems->count();
        $cartTotal = $cartItems->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->product->price; // Assuming each cart item has a product relationship
        });

        // Fetch wishlist count
        $wishlistCount = Wishlist::where('user_id', $user->id)->count();

        return view('auth.profile', [
            'user' => $user,
            'wishlistItems' => $wishlistItems,
            'wishlistCount' => $wishlistCount,
            'cartCount' => $cartCount,
            'cartTotal' => $cartTotal,
        ]);
    }

    /**
     * Display the edit profile form.
     */
    public function edit()
    {
        $user = Auth::user(); // Get the currently authenticated user
        return view('auth.edit-profile', compact('user')); // Load the edit profile view
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user(); // Get the currently authenticated user

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate profile picture
        ]);

        // Update user information
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;

        // Handle profile picture upload
        if ($request->hasFile('profile')) {
            $profilePath = $request->file('profile')->store('profiles', 'public');
            $user->profile = '/storage/' . $profilePath;
        }

        $user->save(); // Save the updated user information

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }
}