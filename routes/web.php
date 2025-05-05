<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\GiftCardController;
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
Route::get('/product/{product_id}', [ProductController::class, 'showProductDetails'])->name('product.details')->middleware('auth');;


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


Route::get('/profile', [ProfileController::class, 'show'])->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile'); // Profile page
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit'); // Edit profile form
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update'); // Update profile
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
// Route::get('/rewards', [RewardController::class, 'index'])->name('rewards.index');

Route::middleware(['auth'])->group(function () {
    // Gift Card Routes
    Route::post('/gift-cards/avail', [GiftCardController::class, 'availGiftCard'])->name('gift-cards.avail');
    Route::get('/gift-cards', [GiftCardController::class, 'index'])->name('gift-cards.my');
});


// Route::get('/gift-cards', [GiftCardController::class, 'index'])->name('gift-cards.index');
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

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

Route::middleware('auth')->group(function () {
    // Admin Dashboard Route
    Route::get('/admin/dashboard', function () {
        $products = \App\Models\Product::all(); // Fetch all products
        return view('admin.adminboard', compact('products'));
    })->name('admin.dashboard');

    // Manage Products Route
    Route::get('/admin/products', [ProductController::class, 'index'])->name('products.index');
});


// Route::middleware(['auth'])->group(function () {
//     Route::get('/product', [OrderController::class, 'showOrders'])->name('orders.view');
// });

// Route::middleware(['auth'])->group(function () {
//     Route::get('/check-free-shipping', [OrderController::class, 'checkFreeShipping'])->name('check.freeShipping');
// });



Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout')->middleware('auth');






