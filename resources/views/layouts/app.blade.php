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

</head>
<body class="bg-gray-100 min-h-screen">
    
    @include('partials.navbar') <!-- Include the navbar -->

    <div class="max-w-7xl mx-auto px-6 py-8">
        @yield('content') <!-- Main content section -->
    </div>

    @include('partials.footer') <!-- Include the footer -->

</body>
</html>
