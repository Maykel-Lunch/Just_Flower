<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Store;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    //public function index(Request $request)
    // {
    //     $storeId = $request->query('store');
    //     $priceFilter = $request->query('price');

    //     $productsQuery = Product::with('primaryImage');

    //     // Optional: If store is provided, filter by it
    //     $store = null;
    //     if ($storeId) {
    //         $store = Store::find($storeId);
    //         if ($store) {
    //             $productsQuery->where('store_id', $storeId);
    //         }
    //     }

    //     // Price filter
    //     if ($priceFilter === 'lt100') {
    //         $productsQuery->where('price', '<', 100);
    //     } elseif ($priceFilter === '100-500') {
    //         $productsQuery->whereBetween('price', [100, 500]);
    //     } elseif ($priceFilter === 'gt500') {
    //         $productsQuery->where('price', '>', 500);
    //     }

    //     $products = $productsQuery->get();

    //     return view('dashboard', compact('products', 'store'));
    // 
    

      public function welcome(Request $request)
{
    // Fetch all stores
    $stores = Store::all();

    // Get filter parameters from the request
    $priceFilter = $request->query('price');
    $categoryName = $request->query('category');
    $flowerType = $request->query('flower_type');
    $size = $request->query('size');
    $occasion = $request->query('occasion');

    // Build the query for products
    $productsQuery = Product::with('primaryImage', 'category');

    // Apply price filter
    if ($priceFilter === 'lt100') {
        $productsQuery->where('price', '<', 100);
    } elseif ($priceFilter === '100-500') {
        $productsQuery->whereBetween('price', [100, 500]);
    } elseif ($priceFilter === 'gt500') {
        $productsQuery->where('price', '>', 500);
    }

    // Apply category-related filters
    $productsQuery->whereHas('category', function ($query) use ($categoryName, $flowerType, $size, $occasion) {
        if ($categoryName) {
            $query->where('category_name', $categoryName);
        }
        if ($flowerType) {
            $query->where('flower_type', $flowerType);
        }
        if ($size) {
            $query->where('size', $size);
        }
        if ($occasion) {
            $query->where('occasion', $occasion);
        }
    });

    // Fetch the filtered products
    $products = $productsQuery->get();

    // Fetch distinct filter options from the product_category table
    $categories = DB::table('product_category')->distinct()->pluck('category_name');
    $flowerTypes = DB::table('product_category')->distinct()->pluck('flower_type');
    $sizes = DB::table('product_category')->distinct()->pluck('size');
    $occasions = DB::table('product_category')->distinct()->pluck('occasion');

    // Fetch Mother's Day products
    $mothersDayProducts = Product::with('primaryImage')
        ->join('product_category', 'products.product_id', '=', 'product_category.product_id')
        ->where('product_category.occasion', 'Mother\'s Day')
        ->take(6)
        ->get();

    // Return the welcome view with the data
    return view('welcome', compact(
        'stores', 'products',
        'categories', 'flowerTypes', 'sizes', 'occasions',
        'mothersDayProducts'
    ));
}

    



    public function search(Request $request)
    {
        $query = $request->input('query');

        // Search for matching products
        $products = Product::where('product_name', 'LIKE', "%{$query}%")
            ->take(10) // Limit to 10 results
            ->with('primaryImage')
            ->get();

        // Return view with search results
        return view('auth.search', compact('products', 'query'));
    }


    public function listProducts()
    {
        // Fetch 8 products per page
        $products = Product::paginate(8);
        
        return view('auth.product', compact('products'));
    }


    public function showProductDetails($id)
{
    $product = Product::with('primaryImage', 'images')->findOrFail($id);

    $isInWishlist = auth()->check() && auth()->user()->wishlist()->where('wishlists.product_id', $id)->exists();

    $products = Product::where('product_id', '!=', $id)
        ->inRandomOrder()
        ->paginate(8);

    $user = Auth::user();
    $shippingAddress = $user->address ?? 'No address provided';
    $contactEmail = $user->email;
    $contactPhone = $user->phone ?? 'No phone number provided';

    $membershipLvl = $user->giftCard->membership_lvl ?? null;
    $hasOrders = $user->orders()->exists();
    $cardType = null;
    $cardBg = null;
    $freeShipping = false;
    $discount = 0;
    $discountDetails = null;

    if ($membershipLvl) {
        if ($membershipLvl === 'silver') {
            $cardType = 'Silver Member';
            $cardBg = 'from-gray-400 to-gray-600';
            $freeShipping = true;

            // Silver discount logic
            $discountDetails = '5% discount capped at ₱50, minimum spend of ₱500';
            if ($product->price >= 500) {
                $discount = min($product->price * 0.05, 50);
            }
        } elseif ($membershipLvl === 'gold') {
            $cardType = 'Gold Member';
            $cardBg = 'from-yellow-500 to-yellow-700';
            $freeShipping = true;

            // Gold discount logic
            $discountDetails = '10% discount capped at ₱100, minimum spend of ₱500';
            if ($product->price >= 500) {
                $discount = min($product->price * 0.10, 100);
            }
        } elseif ($membershipLvl === 'platinum') {
            $cardType = 'Platinum Member';
            $cardBg = 'from-green-400 to-blue-500';
            $freeShipping = true;

            // Platinum discount logic
            $discountDetails = '15% discount, minimum spend of ₱200';
            if ($product->price >= 200) {
                $discount = $product->price * 0.15;
            }
        }
    } elseif (!$membershipLvl && !$hasOrders) {
        $cardType = 'Welcome Card';
        $cardBg = 'from-yellow-400 to-pink-500';
        $freeShipping = true;
    } elseif (!$membershipLvl && $hasOrders) {
        $cardType = 'Non-Member';
        $cardBg = null;
    }

    return view('auth.product', compact(
        'product', 'products', 'isInWishlist', 'user', 'shippingAddress', 'contactEmail', 'contactPhone', 'cardType', 'cardBg', 'freeShipping', 'discount', 'discountDetails', 'membershipLvl', 'hasOrders', 'cardType', 'cardBg', 'freeShipping', 'discount', 'discountDetails', 'membershipLvl', 'hasOrders', 'cardType', 'cardBg', 'freeShipping', 'discount', 'discountDetails', 'membershipLvl',
    ));
}


}
