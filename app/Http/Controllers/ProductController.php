<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Store;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $storeId = $request->query('store');
        $store = Store::findOrFail($storeId);
        $products = Product::where('store_id', $storeId)->with('primaryImage')->get();
        return view('dashboard', compact('store','products'));
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

        // Fetch random products (excluding the current product)
        $products = Product::where('product_id', '!=', $id)
            ->inRandomOrder()
            ->paginate(8);

        return view('auth.product', compact('product', 'products'));
    }


}
