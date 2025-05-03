<div x-data="{ openLogoutModal: false, isLoading: false}">
    <nav class="bg-gradient-to-r from-[#EBC980] to-[#EC59A0] shadow-md w-full h-24 flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="flex justify-between items-center h-full">
                <div class="flex items-center">
                    <img src="{{ asset('flowershop_db/store_logo/Logo2.png') }}" alt="Logo" class="h-16 w-16 mr-2">
                    <a href="/dashboard" class="text-white font-bold text-xl" style="font-family: 'Lora', serif;"
                        @click.prevent="isLoading = true; window.location.href = '/dashboard'">
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
                    @if (!Request::is('messages'))
                        <a href="/messages" class="text-white hover:text-gray-300 inline-flex flex-col items-center px-1 pt-1 text-xs font-medium"
                            @click.prevent="isLoading = true; window.location.href = '/messages'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 3.866-3.582 7-8 7-1.294 0-2.515-.248-3.6-.688L3 20l1.688-4.4C3.248 14.515 3 13.294 3 12c0-3.866 3.582-7 8-7s8 3.134 8 7z" />
                            </svg>
                            <span>Chat</span>
                        </a>
                    @endif

                    @if (!Request::is('wishlist'))
                        <a href="/wishlist" class="text-white hover:text-gray-300 inline-flex flex-col items-center px-1 pt-1 text-xs font-medium"
                            @click.prevent="isLoading = true; window.location.href = '/wishlist'">
                            
                            <!-- Wishlist Icon with badge -->
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                                </svg>

                                <!-- Wishlist Count Badge -->
                                @if ($wishlistItems->count() > 0)
                                    <span class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px] font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                        {{ $wishlistItems->count() }}
                                    </span>
                                @endif
                            </div>

                            <!-- Wishlist Label -->
                            <span>Wishlist</span>
                        </a>
                    @endif


                    @if (!Request::is('cart'))
                        <a href="/cart" class="text-white hover:text-gray-300 inline-flex flex-col items-center px-1 pt-1 text-xs font-medium"
                            @click.prevent="isLoading = true; window.location.href = '/cart'">
                                <!-- Cart Icon with badge -->
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.4 5.6a1 1 0 001 1.4h12a1 1 0 001-1.4L17 13M7 13H5.4M5.4 5L7 13m0 0h10m-6 8a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>

                                    <!-- Cart Count Badge -->
                                    @if ($cartItems->count() > 0)
                                        <span class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px] font-bold rounded-full h-5 w-5 flex items-center justify-center">
                                            {{ $cartItems->count() }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Cart Label -->
                                <span>Cart</span>
                        </a>
                    @endif



                    <div class="relative" x-data="{ open: false }">
                        <!-- Profile Icon -->
                            <button @click="open = !open" class="text-white hover:text-gray-300 inline-flex flex-col items-center px-1 pt-1 text-xs font-medium focus:outline-none">
                                @if(auth()->check() && auth()->user()->profile)
                                    <!-- Display Profile Picture -->
                                    <img src="{{ asset(auth()->user()->profile) }}" alt="Profile Picture" class="w-8 h-8 rounded-full">
                                @elseif(auth()->check())
                                    <!-- Display Initials if No Profile Picture -->
                                    <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center">
                                        <span class="text-gray-600 text-sm font-bold">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                                <span class="text-xs font-medium mt-1">{{ auth()->user()->name }}</span>
                            </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" x-cloak @click.away="open = false" 
                            class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-lg overflow-hidden z-50">
                            <ul class="text-gray-700 text-sm">
                                <!-- My Profile -->
                                <li>
                                    <a href="{{ route('profile') }}" class="flex items-center px-4 py-2 hover:bg-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <circle cx="12" cy="8" r="4" />
                                            <path d="M4 20h16M4 20c0-4 4-6 8-6s8 2 8 6" />
                                        </svg>
                                        My Profile
                                    </a>
                                </li>
                                <!-- Order History -->
                                <li>
                                    <a href="/orders" class="flex items-center px-4 py-2 hover:bg-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M3 3h18v18H3V3z" />
                                            <path d="M8 12h8M8 16h8M8 8h8" />
                                        </svg>
                                        Order History
                                    </a>
                                </li>
                                <!-- Loyalty Rewards -->
                                <li>
                                    <a href="/rewards" class="flex items-center px-4 py-2 hover:bg-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M12 17l-5 3 1-5-4-4 5-1L12 2l3 8 5 1-4 4 1 5z" />
                                        </svg>
                                        Loyalty Rewards
                                    </a>
                                </li>
                                <!-- Gift Cards -->
                                <li>
                                    <a href="/gift-cards" class="flex items-center px-4 py-2 hover:bg-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <rect x="2" y="6" width="20" height="12" rx="2" />
                                            <path d="M12 6V4m-4 4h8m-6 4v2m4-2v2" />
                                        </svg>
                                        Gift Cards
                                    </a>
                                </li>
                                <!-- Notifications -->
                                <li>
                                    <a href="/notifications" class="flex items-center px-4 py-2 hover:bg-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M12 22c1.5 0 3-1.5 3-3H9c0 1.5 1.5 3 3 3zm6-6v-5c0-3.9-3-6-6-6s-6 2.1-6 6v5l-2 2v1h16v-1l-2-2z" />
                                        </svg>
                                        Notifications
                                    </a>
                                </li>
                                
                        
                                <!-- Divider -->
                                <li><hr class="border-t border-gray-300 my-1"></li>
                                <!-- Logout -->
                                <li>
                                    <button @click="openLogoutModal = true" class="w-full flex items-center px-4 py-2 text-red-600 hover:bg-red-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 1-2 2h-4" />
                                            <polyline points="10 17 15 12 10 7" />
                                            <line x1="15" y1="12" x2="3" y2="12" />
                                        </svg>
                                        Logout
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </nav>

    <!-- Logout Confirmation Modal -->
    <div x-show="openLogoutModal" 
         x-cloak 
         class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-[1000]"
         x-transition.opacity.duration.300ms>
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3 relative">
            <h2 class="text-xl font-bold text-gray-800">Confirm Logout</h2>
            <p class="text-gray-600 mt-2">Are you sure you want to log out?</p>
            <div class="mt-4 flex justify-end space-x-2">
                <button @click="openLogoutModal = false" 
                        class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                    Cancel
                </button>

                <form @submit.prevent="isLoading = true; $event.target.submit()" method="GET" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Logout
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>