<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Just Flowers')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="{{ asset('js/search.js') }}"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Great+Vibes&family=Quicksand:wght@700&family=Poppins:wght@700&family=Montserrat:wght@700&family=Lora:wght@700&family=Dancing+Script:wght@700&family=Pacifico&family=Amatic+SC:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/wishlist.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/carbon-js@1.0.0/carbon.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        [x-cloak] { display: none !important; }
    </style>


</head>
<body class="bg-gray-100 min-h-screen flex flex-col" x-data="{ isLoading: false }" x-init="isLoading = true; setTimeout(() => isLoading = false, 1000)">
    
    <!-- Loading Animation : Edit this based on your preferred animation-->
    <div x-show="isLoading" x-cloak class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-[2000]">
        <div class="flex flex-col items-center">
            <div class="relative flex space-x-2">
                <div class="h-3 w-3 bg-pink-400 rounded-full animate-bounce"></div>
                <div class="h-3 w-3 bg-pink-500 rounded-full animate-bounce [animation-delay:-0.2s]"></div>
                <div class="h-3 w-3 bg-pink-600 rounded-full animate-bounce [animation-delay:-0.4s]"></div>
            </div>
            <p class="text-white mt-4">Loading...</p>
        </div>
    </div>

    @include('partials.navbar') <!-- Include the navbar -->

    <div class="w-full mx-auto px-6 py-8 bg-gray-100 min-h-screen">
        @yield('content') <!-- Main content section -->
    </div>
    
    
    
    @include('partials.footer') <!-- Include the footer -->

</body>
</html>
