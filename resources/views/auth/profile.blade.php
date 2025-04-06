@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-6xl flex-grow">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Left Column - Profile Card -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 text-center relative">
                    <!-- Profile Picture -->
                    <div class="relative mx-auto w-32 h-32 rounded-full bg-blue-600 text-white flex items-center justify-center text-5xl font-bold mb-4">
                        J
                        <button class="absolute bottom-0 right-0 bg-blue-700 text-white rounded-full w-8 h-8 flex items-center justify-center border-2 border-white hover:bg-blue-800 transition" title="Change profile picture">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Name and Verification -->
                    <h1 class="text-2xl font-bold text-gray-800 mb-1">John Doe</h1>
                    <span class="inline-block bg-orange-500 text-white text-xs px-2 py-1 rounded-full mb-4">Verified</span>
                    
                    <!-- Edit Profile Button -->
                    <button id="editProfileBtn" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition mb-6 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Profile
                    </button>
                    
                    <!-- Membership Card -->
                    <div class="bg-gradient-to-r from-blue-600 to-gray-800 text-white rounded-lg p-4">
                        <div class="text-xl font-bold mb-1">Gold Member</div>
                        <div class="text-sm mb-1">Member ID: XF-7890-2023</div>
                        <div class="text-xs italic opacity-80">Member since: Jan 2020</div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - Profile Details -->
            <div class="md:col-span-3 space-y-6">
                <!-- Contact Information -->
                <div class="bg-white rounded-lg shadow-md p-6 relative">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-blue-600 border-b border-gray-200 pb-2 w-full">Contact Information</h2>
                        <button class="text-blue-600 hover:text-blue-800 ml-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                    </div>
                    <div class="space-y-2">
                        <p><strong class="text-gray-700">Email:</strong> john.doe@example.com</p>
                        <p><strong class="text-gray-700">Phone:</strong> (555) 123-4567</p>
                        <p><strong class="text-gray-700">Address:</strong> 123 Main Street, Apt 4B, New York, NY 10001</p>
                    </div>
                </div>
                
                <!-- Order History -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-blue-600 border-b border-gray-200 pb-2 mb-4">Order History</h2>
                    <div class="space-y-4">
                        <div class="bg-gray-50 p-4 rounded-md">
                            <p><strong class="text-gray-700">Recent Order:</strong> #ORD-7890 (Dec 15, 2023)</p>
                            <p><strong class="text-gray-700">Status:</strong> <span class="text-green-600">Delivered</span></p>
                            <p><strong class="text-gray-700">Items:</strong> 3 | <strong class="text-gray-700">Total:</strong> $145.99</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-md">
                            <p><strong class="text-gray-700">Previous Order:</strong> #ORD-6543 (Nov 28, 2023)</p>
                            <p><strong class="text-gray-700">Status:</strong> <span class="text-green-600">Delivered</span></p>
                            <p><strong class="text-gray-700">Items:</strong> 2 | <strong class="text-gray-700">Total:</strong> $89.50</p>
                        </div>
                        <a href="#" class="text-blue-600 hover:text-blue-800 inline-block mt-2">View all orders (12)</a>
                    </div>
                </div>
                
                <!-- Wishlist -->
                <div class="bg-white rounded-lg shadow-md p-6 relative">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-blue-600 border-b border-gray-200 pb-2 w-full">Wishlist</h2>
                        <button class="text-blue-600 hover:text-blue-800 ml-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-md">
                        <p><strong class="text-gray-700">5 items</strong> in wishlist</p>
                        <p><strong class="text-gray-700">Recently added:</strong> Wireless Headphones, Leather Wallet</p>
                    </div>
                    <a href="#" class="text-blue-600 hover:text-blue-800 inline-block mt-4">View wishlist</a>
                </div>
                
                <!-- Shopping Cart -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-blue-600 border-b border-gray-200 pb-2 mb-4">Shopping Cart</h2>
                    <div class="bg-gray-50 p-4 rounded-md">
                        <p><strong class="text-gray-700">3 items</strong> in cart</p>
                        <p><strong class="text-gray-700">Total:</strong> $67.99</p>
                    </div>
                    <a href="#" class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition">Proceed to checkout</a>
                </div>
            </div>
        </div>
    </div> 
@endsection