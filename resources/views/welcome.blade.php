<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Just Flowers</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Navigation Bar -->
    <nav class="bg-gradient-to-r from-[#EBC980] to-[#EC59A0] shadow-md w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <img src="{{ asset('flowershop_db/store_logo/Logo2.png') }}" alt="Logo" class="h-10 w-10 mr-2">
                    <a href="/" class="text-white font-bold text-xl">just_flowers</a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:items-center space-x-6">
                    <a href="/" class="text-white hover:text-gray-300 text-sm font-medium">Home</a>
                    <a href="/about" class="text-white hover:text-gray-300 text-sm font-medium">About</a>
                    <a href="/contact" class="text-white hover:text-gray-300 text-sm font-medium">Contact</a>
                    <a href="/login" class="text-white hover:text-gray-300 text-sm font-medium">Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Featured Products Section -->
  

    <!-- All Products Section -->
    <div class="max-w-7xl mx-auto px-6 py-8">
        <h2 class="text-2xl font-bold mb-6">All Products</h2>
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

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-[#EBC980] to-[#EC59A0] text-white py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Just Flowers Section -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Just Flowers</h3>
                <p class="flex items-center mb-2">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/gift.png" alt="Gift Icon" class="h-5 w-5 mr-2">
                    Gift Shop · Flower Delivery · Contactless Delivery Available
                </p>
                <p class="flex items-center mb-2">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/marker.png" alt="Location Icon" class="h-5 w-5 mr-2">
                    Zone 4, Marifosque, Pilar, Philippines
                </p>
                <p class="flex items-center mb-2">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/phone.png" alt="Phone Icon" class="h-5 w-5 mr-2">
                    0910 494 8212
                </p>
                <p class="flex items-center">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/mail.png" alt="Mail Icon" class="h-5 w-5 mr-2">
                    justflowers0420@gmail.com
                </p>
            </div>

            <!-- Our Shop Section -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Our Shop</h3>
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3877.123456789012!2d123.456789012345!3d10.123456789012!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1234567890abcdef%3A0xabcdef1234567890!2sMarifosque%2C%20Pilar%2C%20Philippines!5e0!3m2!1sen!2sph!4v1234567890123" 
                    width="250" 
                    height="200" 
                    style="border:0; border-radius: 8px;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
                <p class="mt-2">Visit our store today</p>
            </div>

            <!-- Categories Section -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Categories</h3>
                <ul class="space-y-2">
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

            <!-- Customer Service Section -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Customer Service</h3>
                <ul class="space-y-2">
                    <li>Contact Us</li>
                    <li>FAQs</li>
                    <li>Shipping & Delivery</li>
                    <li>Returns</li>
                    <li>Track Order</li>
                </ul>
            </div>
        </div>

        <div class="text-center mt-8">
            <p class="text-sm">&copy; 2025 Just Flowers. All rights reserved.</p>
        </div>
    </footer>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // Initialize Swiper with minimal configuration
        const swiper = new Swiper('.motherDaySwiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                }
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
        });

        // Toggle favorite functionality
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