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
}
