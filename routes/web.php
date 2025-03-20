<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use App\Models\Store;
use App\Models\Product;

// Route::get('/', function () {
//     return redirect()->route('login');
// });

Route::get('/', function () {
    $stores = Store::all(); 
    $products = Product::all();
    return view('welcome', compact('stores', 'products')); 
});

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');

Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');

Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

Route::get('logout', [AuthController::class, 'logout'])->name('logout');



