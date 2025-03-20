<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                    <div class="ml-4 w-96">
                        <form action="/search" method="GET" class="relative">
                            <input 
                                type="text" 
                                name="query" 
                                placeholder="Search for products, stores, or categories..." 
                                class="bg-white text-gray-700 rounded-full px-4 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-[#F566BC] focus:border-transparent"
                            >
                            <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-[#F566BC]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16.65 10.65a6 6 0 11-12 0 6 6 0 0112 0z" />
                                </svg>
                            </button>
                        </form>
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
                    <a href="/chat" class="text-white hover:text-gray-300 inline-flex flex-col items-center px-1 pt-1 text-xs font-medium">
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

    <div class="flex flex-col items-center justify-center min-h-screen space-y-8">
    

        <div class="flex flex-col items-center justify-center min-h-screen space-y-8">
        <!-- Products Section -->
        <div class="p-4 w-full max-w-4xl">
            <div class="flex justify-between items-center mb-4">
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
                    <div class="p-3 border border-[#F566BC] rounded-lg shadow-md relative transition-transform transform hover:scale-105 hover:shadow-lg">
                        <img src="{{ $product->primaryImage ? asset($product->primaryImage->image_url) : 'https://via.placeholder.com/150' }}" 
                             alt="{{ $product->product_name }}" 
                             class="w-full h-28 object-cover rounded-md mb-2">
                        <h3 class="text-sm font-medium">{{ $product->product_name }}</h3>
                        <p class="text-gray-600 text-xs truncate">{{ Str::limit($product->description, 50, '...') }}</p>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-black-600 font-bold text-sm">₱{{ number_format($product->price, 2) }}</span>
                            <button class="bg-orange-400 hover:bg-orange-500 text-white px-3 py-1 rounded-full flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.4 5.6a1 1 0 001 1.4h12a1 1 0 001-1.4L17 13M7 13H5.4M5.4 5L7 13m0 0h10m-6 8a2 2 0 100-4 2 2 0 000 4z" />
                                </svg>
                                <span class="text-xs">Add to Cart</span>
                            </button>
                        </div>
                        <button 
                            class="absolute top-2 right-2 bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded-full flex items-center justify-center" 
                            onclick="toggleFavorite(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="heart-icon">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                            </svg>
                        </button>

                        <!-- ilipat to sa resources/js -->
                        <script>
                            function toggleFavorite(button) {
                                const icon = button.querySelector('#heart-icon');
                                if (icon.getAttribute('fill') === 'none') {
                                    icon.setAttribute('fill', 'red');
                                } else {
                                    icon.setAttribute('fill', 'none');
                                }
                            }
                        </script>

                        <div class="mt-2 text-gray-500 text-xs">
                            Stock: {{ $product->stock_quantity }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    </div>
</body>
</html>