<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use App\Models\Store;
use App\Models\Product;


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


// if successfully chnage the product controller
// Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::middleware(['auth'])->group(function () {
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
    Route::delete('/cart/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
});

// Route::get('/profile', function () {
//     return view('auth.profile'); 
// })->name('profile')->middleware('auth');

Route::get('/profile', [ProfileController::class, 'show'])->middleware('auth');



Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'viewWishlistPage'])->name('wishlist.page');
    Route::delete('/wishlist/remove/{productId}', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');
    Route::delete('/wishlist/clear', [WishlistController::class, 'clearWishlist'])->name('wishlist.clear');

    
});

// Route::middleware('auth')->post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
// Route::post('/wishlist/{productId}', [WishlistController::class, 'toggleWishlist'])->name('wishlist.toggle');

// Route::post('/wishlist/{productId}', [WishlistController::class, 'toggleWishlist'])
//     ->middleware('auth')
//     ->name('wishlist.toggle');

Route::post('/wishlist/{productId}', [WishlistController::class, 'toggle'])->middleware('auth');












