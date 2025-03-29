<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <nav class="bg-gradient-to-r from-[#EBC980] to-[#EC59A0] shadow-md w-full font-poppins">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <img src="{{ asset('flowershop_db/store_logo/Logo2.png') }}" alt="Logo" class="h-10 w-10 mr-2">
                    <a href="/" class="flex-shrink-0 flex items-center text-white font-bold text-xl">
                        just_flowers
                    </a>
                    <div class="ml-4 w-96">
                        <form action="/search" method="GET" class="relative">
                            <input 
                                type="text" 
                                name="query" 
                                placeholder="Search for products, stores, or categories..." 
                                class="bg-white text-gray-700 rounded-full px-4 py-2 text-sm w-full font-poppins focus:outline-none focus:ring-2 focus:ring-[#F566BC] focus:border-transparent"
                            >
                            <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-[#F566BC]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16.65 10.65a6 6 0 11-12 0 6 6 0 0112 0z" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-4">
                    <a href="/login" class="text-white hover:text-gray-300 inline-flex flex-col items-center px-1 pt-1 text-xs font-medium font-poppins">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h10m0 0l-4-4m4 4l-4 4" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 5v14a2 2 0 01-2 2h-4M19 5H15" />
                        </svg>
                        <span>Login</span>
                    </a>
                    <a href="/login" class="text-white hover:text-gray-300 inline-flex flex-col items-center px-1 pt-1 text-xs font-medium font-poppins">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 3.866-3.582-7-8 7-1.294 0-2.515-.248-3.6-.688L3 20l1.688-4.4C3.248 14.515 3 13.294 3 12c0-3.866 3.582-7 8-7s8 3.134 8 7z" />
                        </svg>
                        <span>Chat</span>
                    </a>
                    <a href="/login" class="text-white hover:text-gray-300 inline-flex flex-col items-center px-1 pt-1 text-xs font-medium font-poppins">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                        </svg>
                        <span>Wishlist</span>
                    </a>
                    <a href="/login" class="text-white hover:text-gray-300 inline-flex flex-col items-center px-1 pt-1 text-xs font-medium font-poppins">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.4 5.6a1 1 0 001 1.4h12a1 1 0 001-1.4L17 13M7 13H5.4M5.4 5L7 13m0 0h10m-6 8a2 2 0 100-4 2 2 0 000 4z" />
                        </svg>
                        <span>Cart</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</body>
</html>
