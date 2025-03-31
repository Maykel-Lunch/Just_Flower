<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MessageController;
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

Route::get('/search', [ProductController::class, 'search'])->name('search');
Route::get('/product/{product_id?}', [ProductController::class, 'showProductDetails'])->name('product.details');

Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');

Route::middleware(['auth'])->group(function () {
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
    Route::delete('/cart/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
});








