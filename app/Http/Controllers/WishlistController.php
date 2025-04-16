<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Add a product to the wishlist.
     */
    public function addToWishlist(Request $request, $productId)
    {
        $user = Auth::user();
        
        // Prevent duplicate entries
        $exists = Wishlist::where('user_id', $user->id)
                          ->where('product_id', $productId)
                          ->exists();

        if ($exists) {
            return response()->json(['message' => 'Product is already in your wishlist.'], 200);
        }

        Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $productId,
        ]);

        return response()->json(['message' => 'Product added to wishlist.'], 201);
    }

    /**
     * Remove a single product from the wishlist.
     */
    public function removeFromWishlist($productId)
    {
        Wishlist::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->delete();

        return response()->json(['message' => 'Product removed from wishlist.']);
    }

    /**
     * View all wishlist items for the authenticated user.
     */
    public function viewWishlist()
    {
        $wishlist = Wishlist::with('product')
                    ->where('user_id', Auth::id())
                    ->get();

        return response()->json($wishlist);
    }

    

    /**
     * Clear the entire wishlist for the authenticated user.
     */
    public function clearWishlist()
    {
        Wishlist::where('user_id', Auth::id())->delete();

        return response()->json(['message' => 'Wishlist cleared.']);
    }

    public function viewWishlistPage()
    {
        $wishlist = Wishlist::with('product')
                    ->where('user_id', Auth::id())
                    ->get();

        return view('auth.wishlist', compact('wishlist'));
    }

    public function toggleWishlist($productId)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Check if the product is already in the wishlist
        $wishlistItem = $user->wishlist()->where('product_id', $productId)->first();

        if ($wishlistItem) {
            // Remove from wishlist
            $user->wishlist()->detach($productId);
            return response()->json(['message' => 'Removed from wishlist']);
        } else {
            // Add to wishlist
            $user->wishlist()->attach($productId);
            return response()->json(['message' => 'Added to wishlist']);
        }
    }

    public function toggle(Request $request, $productId)
    {
        $user = Auth::user();
    
        // Check if the product is already in the wishlist
        $wishlistItem = Wishlist::where('user_id', $user->id)
                                ->where('product_id', $productId)
                                ->first();
    
        if ($wishlistItem) {
            // Remove from wishlist
            $wishlistItem->delete();
    
            return response()->json([
                'status' => 'removed',
                'message' => 'Removed from wishlist.'
            ]);
        } else {
            // Add to wishlist
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId
            ]);
    
            return response()->json([
                'status' => 'added',
                'message' => 'Added to wishlist.'
            ]);
        }
    }

}
