<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;

class AuthController extends Controller
{
    
    
    // Show the login form
    public function index()
    {
        return view('auth.login');
    }

    // Handle login request
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')->withSuccess('You have successfully logged in.');
        }

        return redirect()->route('login')->withErrors('Invalid login credentials.');
    }

    // Show the registration form
    public function registration()
    {
        return view('auth.registration');
    }

    // Handle registration request
    public function postRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $data = $request->all();
        $data['password'] = bcrypt($data['password']); // Hash the password

        $user = User::create($data); // Create the user

        // Log the user in
        Auth::login($user);

        // Redirect to the dashboard
        return redirect()->route('dashboard')->withSuccess('Registration successful. Welcome to your dashboard!');
    }

    // Handle logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->withSuccess('You have successfully logged out.');
    }

    

    // TRANSFER THIS 2 TO PRODUCT CONTROLLER (dashboard and getEnumValues function)
    // public function dashboard(Request $request)
    // {
    //     if (!Auth::check()) {
    //         return redirect()->route('login')->withErrors('You need to log in first.');
    //     }

    //     $stores = Store::all();
    //     $priceFilter = $request->query('price');
    //     $categoryName = $request->query('category');
    //     $flowerType = $request->query('flower_type');
    //     $size = $request->query('size');
    //     $occasion = $request->query('occasion');

    //     $productsQuery = Product::with('primaryImage', 'category');

    //     if ($priceFilter === 'lt100') {
    //         $productsQuery->where('price', '<', 100);
    //     } elseif ($priceFilter === '100-500') {
    //         $productsQuery->whereBetween('price', [100, 500]);
    //     } elseif ($priceFilter === 'gt500') {
    //         $productsQuery->where('price', '>', 500);
    //     }

    //     $productsQuery->whereHas('category', function ($query) use ($categoryName, $flowerType, $size, $occasion) {
    //         if ($categoryName) {
    //             $query->where('category_name', $categoryName);
    //         }
    //         if ($flowerType) {
    //             $query->where('flower_type', $flowerType);
    //         }
    //         if ($size) {
    //             $query->where('size', $size);
    //         }
    //         if ($occasion) {
    //             $query->where('occasion', $occasion);
    //         }
    //     });

    //     $products = $productsQuery->get();

    //     // Get distinct filter options from product_category table
    //     $categories = DB::table('product_category')->distinct()->pluck('category_name');
    //     $flowerTypes = DB::table('product_category')->distinct()->pluck('flower_type');
    //     $sizes = DB::table('product_category')->distinct()->pluck('size');
    //     $occasions = DB::table('product_category')->distinct()->pluck('occasion');

    //     return view('auth.dashboard', compact(
    //         'stores', 'products',
    //         'categories', 'flowerTypes', 'sizes', 'occasions'
    //     ));
    // }

    public function dashboard(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors('You need to log in first.');
        }

        $stores = Store::all();
        $priceFilter = $request->query('price');
        $categoryName = $request->query('category');
        $flowerType = $request->query('flower_type');
        $size = $request->query('size');
        $occasion = $request->query('occasion');

        $productsQuery = Product::with('primaryImage', 'category');

        if ($priceFilter === 'lt100') {
            $productsQuery->where('price', '<', 100);
        } elseif ($priceFilter === '100-500') {
            $productsQuery->whereBetween('price', [100, 500]);
        } elseif ($priceFilter === 'gt500') {
            $productsQuery->where('price', '>', 500);
        }

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

        $products = $productsQuery->get();

        // Get distinct filter options from product_category table
        $categories = DB::table('product_category')->distinct()->pluck('category_name');
        $flowerTypes = DB::table('product_category')->distinct()->pluck('flower_type');
        $sizes = DB::table('product_category')->distinct()->pluck('size');
        $occasions = DB::table('product_category')->distinct()->pluck('occasion');

        $mothersDayProducts = Product::with('primaryImage')
            ->join('product_category', 'products.product_id', '=', 'product_category.product_id')
            ->where('product_category.occasion', 'Mother\'s Day')
            ->take(6)
            ->get();

        return view('auth.dashboard', compact(
            'stores', 'products',
            'categories', 'flowerTypes', 'sizes', 'occasions',
            'mothersDayProducts'
        ));
    }


    // Helper to extract enum values from a column
    private function getEnumValues($table, $column)
    {
        $type = DB::select("SHOW COLUMNS FROM {$table} WHERE Field = '{$column}'")[0]->Type;

        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = [];
        if (!empty($matches)) {
            foreach (explode(',', $matches[1]) as $value) {
                $enum[] = trim($value, "'");
            }
        }
        return $enum;
    }  
}