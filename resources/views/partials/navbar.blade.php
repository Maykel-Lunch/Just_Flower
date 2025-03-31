
<div x-data="{ openLogoutModal: false }">
    <nav class="bg-gradient-to-r from-[#EBC980] to-[#EC59A0] shadow-md w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <img src="{{ asset('flowershop_db/store_logo/Logo2.png') }}" alt="Logo" class="h-10 w-10 mr-2">
                    <a href="#" class="text-white font-bold text-xl" style="font-family: 'Lora', serif;">
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


                    <a href="#" @click.prevent="openLogoutModal = true" class="text-white hover:text-gray-300 inline-flex flex-col items-center px-1 pt-1 text-xs font-medium">
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
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>




