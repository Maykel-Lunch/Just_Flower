<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/search.js') }}"></script>

</head>
<body class="bg-gray-100 min-h-screen">
    
    <nav class="bg-gradient-to-r from-[#EBC980] to-[#EC59A0] shadow-md w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <img src="{{ asset('flowershop_db/store_logo/Logo2.png') }}" alt="Logo" class="h-10 w-10 mr-2">
                    <a href="#" class="text-white font-bold text-xl">
                        just_flowers
                    </a>
                    
                    <div class="ml-4 w-96 relative">
                    <form action="{{ route('search') }}" method="GET" class="relative">
                            <input 
                                type="text" 
                                id="search-input"
                                name="query" 
                                placeholder="Search for products..." 
                                class="bg-white text-gray-700 rounded-full px-4 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-[#F566BC]"
                                autocomplete="off"
                            >
                            <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-[#F566BC]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16.65 10.65a6 6 0 11-12 0 6 6 0 0112 0z" />
                                </svg>
                            </button>
                        </form>

                        <!-- Dropdown for search results -->
                        <div id="search-results" class="absolute top-full left-0 w-full bg-white border border-gray-200 rounded-lg shadow-lg hidden">
                            <ul id="results-list"></ul>
                        </div>
                    </div>

                </div>
                <div class="flex items-center space-x-4">
                    @if(auth()->check() && auth()->user()->profile_picture)
                        <a href="/profile" class="text-white hover:text-gray-300 inline-flex flex-col items-center px-1 pt-1 text-xs font-medium">
                            <img src="{{ auth()->user()->profile_picture }}" alt="Profile Picture" class="w-5 h-5 rounded-full">
                            <span class="text-xs font-medium mt-1">{{ auth()->user()->name }}</span>
                        </a>
                    @elseif(auth()->check())
                        <a href="/profile" class="text-white hover:text-gray-300 inline-flex flex-col items-center px-1 pt-1 text-xs font-medium">
                            <div class="w-5 h-5 rounded-full bg-gray-300 flex items-center justify-center">
                                <span class="text-gray-600 text-[8px] font-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            </div>
                            <span class="text-xs font-medium mt-1">{{ auth()->user()->name }}</span>
                        </a>
                    @endif
                    <a href="/messages" class="text-white hover:text-gray-300 inline-flex flex-col items-center px-1 pt-1 text-xs font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 3.866-3.582 7-8 7-1.294 0-2.515-.248-3.6-.688L3 20l1.688-4.4C3.248 14.515 3 13.294 3 12c0-3.866 3.582-7 8-7s8 3.134 8 7z" />
                        </svg>
                        <span>Chat</span>
                    </a>
                    <a href="/wishlist" class="text-white hover:text-gray-300 inline-flex flex-col items-center px-1 pt-1 text-xs font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                        </svg>
                        <span>Wishlist</span>
                    </a>
                    <a href="/cart" class="text-white hover:text-gray-300 inline-flex flex-col items-center px-1 pt-1 text-xs font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.4 5.6a1 1 0 001 1.4h12a1 1 0 001-1.4L17 13M7 13H5.4M5.4 5L7 13m0 0h10m-6 8a2 2 0 100-4 2 2 0 000 4z" />
                        </svg>
                        <span>Cart</span>
                    </a>

                    
                    <a href="{{ route('logout') }}" class="text-white hover:text-gray-300 inline-flex flex-col items-center px-1 pt-1 text-xs font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-black-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                            <polyline points="10 17 15 12 10 7" />
                            <line x1="15" y1="12" x2="3" y2="12" />
                        </svg>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="flex flex-col items-center justify-center min-h-screen space-y-8">
            <div class="flex justify-between items-center mb-4 w-full">
                <h2 class="text-2xl font-bold">All Products</h2>
                <button class="bg-white-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-full flex items-center space-x-2 border border-[#F566BC]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="#F566BC">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707v4.586a1 1 0 01-.293.707l-2 2A1 1 0 0110 20v-6.586a1 1 0 00-.293-.707L3.293 6.707A1 1 0 013 6V4z" />
                    </svg>
                    <span class="text-[#F566BC]"><strong>Filter</strong></span>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($products as $product)
                    <div class="bg-white shadow-lg p-5 rounded-lg hover:shadow-xl transition-shadow duration-300 border border-[#F566BC] relative transform hover:scale-105 min-h-[350px] flex flex-col">
                        <a href="{{ route('product.details', $product->product_id) }}" class="flex flex-col flex-grow">
                            <img src="{{ $product->primaryImage ? asset($product->primaryImage->image_url) : 'https://via.placeholder.com/150' }}" 
                            alt="{{ $product->product_name }}" 
                            class="w-full h-full object-cover">
                            <h3 class="text-sm font-medium text-gray-800">{{ $product->product_name }}</h3>
                            <p class="text-gray-600 text-xs truncate">{{ Str::limit($product->description, 50, '...') }}</p>
                        </a>

                        <div class="mt-auto">
                            <div class="flex justify-between items-center mt-3">
                                <span class="text-black font-bold text-sm">₱{{ number_format($product->price, 2) }}</span>
                                <button class="bg-orange-400 hover:bg-orange-500 text-white px-3 py-1 rounded-full flex items-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.4 5.6a1 1 0 001 1.4h12a1 1 0 001-1.4L17 13M7 13H5.4M5.4 5L7 13m0 0h10m-6 8a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                    <span class="text-xs">Add to Cart</span>
                                </button>
                            </div>

                            <div class="mt-2 text-gray-500 text-xs">Stock: {{ $product->stock_quantity }}</div>
                        </div>

                        <button 
                            class="absolute top-2 right-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs px-2 py-1 rounded-full flex items-center justify-center" 
                            onclick="toggleFavorite(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="heart-icon">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                            </svg>
                        </button>
                    </div>

                @endforeach
            </div>
        </div>
    </div>

    <footer class="bg-gradient-to-r from-[#EBC980] to-[#EC59A0] shadow-md w-full text-white py-8 mt-6 font-inter">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <h3 class="text-lg font-semibold mb-2">Just Flowers</h3>
                    <p class="flex items-center">
                        <img src="https://img.icons8.com/ios-filled/50/ffffff/gift.png" alt="Gift Icon" class="h-5 w-5 mr-2">
                        <span class="text-sm">Gift Shop · Flower Delivery · Contactless Delivery Available</span>
                    </p>
                    <p class="mt-2 flex items-center">
                        <img src="https://img.icons8.com/ios-filled/50/ffffff/marker.png" alt="Location Icon" class="h-5 w-5 mr-2">
                        Zone 4, Marifosque, Pilar, Philippines
                    </p>
                    <p class="flex items-center">
                        <img src="https://img.icons8.com/ios-filled/50/ffffff/phone.png" alt="Phone Icon" class="h-5 w-5 mr-2">
                        0910 494 8212
                    </p>
                    <p class="flex items-center">
                        <img src="https://img.icons8.com/ios-filled/50/ffffff/mail.png" alt="Mail Icon" class="h-5 w-5 mr-2">
                        justflowers0420@gmail.com
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-2">Our Shop</h3>
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3877.123456789012!2d123.456789012345!3d10.123456789012!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1234567890abcdef%3A0xabcdef1234567890!2sMarifosque%2C%20Pilar%2C%20Philippines!5e0!3m2!1sen!2sph!4v1234567890123" 
                        width="250" 
                        height="200" 
                        style="border:0; border-radius: 8px;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                    <p>Visit our store today</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-2">Categories</h3>
                    <ul>
                        <li>Roses</li>
                        <li>Lilies</li>
                        <li>Tulips</li>
                        <li>Orchids</li>
                        <li>Bouquets</li>
                        <li>Arrangements</li>
                        <li>Plants</li>
                        <li>Gifts</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-2">Customer Service</h3>
                    <ul>
                        <li>Contact Us</li>
                        <li>FAQs</li>
                        <li>Shipping & Delivery</li>
                        <li>Returns</li>
                        <li>Track Order</li>
                    </ul>
                </div>
            </div>
            <div class="text-center mt-6">
                <p>&copy; 2023 just_flowers. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <!-- Move this script to resources/js and include it properly -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[onclick="toggleFavorite(this)"]').forEach(button => {
                button.addEventListener('click', () => {
                    const icon = button.querySelector('#heart-icon');
                    if (icon.getAttribute('fill') === 'none') {
                        icon.setAttribute('fill', 'red');
                    } else {
                        icon.setAttribute('fill', 'none');
                    }
                });
            });
        });
    </script>
</body>
</html>