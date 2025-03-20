

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
    
    <!-- Breadcrumb Navigation (Aligned) -->
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-2">
        <nav class="text-gray-600 text-sm">
            <ol class="list-reset flex items-center">
                <li>
                    <a href="{{ route('dashboard') }}" class="text-[#F566BC] hover:underline">Home</a>
                </li>
                <li><span class="mx-2"> \ </span></li>
                <li class="text-gray-800 font-semibold">{{ $product->product_name }}</li>
            </ol>
        </nav>
    </div>


    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        @if(isset($product))
            <div class="bg-white rounded-lg p-6 border-[#F566BC] border-2 shadow-md">
                <div class="flex">
                    <!-- Left Section: Thumbnail Images -->
                    <div class="w-1/4 flex flex-col space-y-2">
                        @if($product->images && $product->images->count() > 0)
                            @foreach($product->images as $image)
                                <img 
                                    src="{{ asset($image->image_url) }}" 
                                    alt="Product Image" 
                                    class="w-16 h-16 rounded-lg cursor-pointer border border-gray-300 hover:border-[#F566BC]" 
                                    onclick="document.getElementById('mainImage').src=@js($image->image_url ? asset($image->image_url) : 'https://via.placeholder.com/150')"
                                >
                            @endforeach
                        @endif
                    </div>

                    <!-- Center Section: Primary Image -->
                    <div class="w-1/2">
                        <img id="mainImage" src="{{ $product->primaryImage ? asset($product->primaryImage->image_url) : 'https://via.placeholder.com/150' }}" alt="{{ $product->product_name }}" class="rounded-lg w-2/3 h-auto">
                    </div>

                    <!-- Right Section: Product Details -->
                    <div class="w-2/4">
                        <h1 class="text-2xl font-bold text-gray-800">{{ $product->product_name }}</h1>
                        <p class="text-gray-600 mt-2">{{ $product->description }}</p>
                        <p class="text-lg font-semibold text-gray-800 mt-4">Price: ₱{{ number_format($product->price, 2) }}</p>

                        <!-- Customization Options -->
                        <div class="mt-4">
                            <h2 class="text-lg font-semibold text-gray-800 uppercase italic">Customization Options:</h2>
                            <div class="mt-2">
                                <label class="block text-gray-700">Wrapping Color:</label>
                                <div class="flex items-center mt-1">
                                    <input type="radio" id="default" name="wrapping_color" value="default" class="mr-2">
                                    <label for="default" class="mr-4">Default</label>
                                    <input type="radio" id="pink" name="wrapping_color" value="pink" class="mr-2">
                                    <label for="pink" class="mr-4">Pink</label>
                                    <input type="radio" id="blue" name="wrapping_color" value="blue" class="mr-2">
                                    <label for="blue" class="mr-4">Blue</label>
                                    <input type="radio" id="green" name="wrapping_color" value="green" class="mr-2">
                                    <label for="green" class="mr-4">Green</label>
                                </div>
                            </div>
                            <div class="mt-2">
                                <input type="checkbox" id="card_message" name="card_message" class="mr-2">
                                <label for="card_message" class="text-gray-700">Add a card message</label>
                            </div>

                            <!-- Message Input Box (Initially Hidden) -->
                            <div id="message_box" class="mt-2 hidden">
                                <textarea id="message_text" name="message_text" class="w-full p-2 border rounded" placeholder="Enter your message here..."></textarea>
                            </div>
                           
                        </div>

                        <!-- Quantity Selector and Add to Cart Button -->
                        <div class="mt-6 flex items-center space-x-4">
                            <div class="flex items-center border border-gray-300 rounded-full">
                                <button id="decrement" class="px-4 py-2 text-gray-600 hover:text-gray-800 focus:outline-none">-</button>
                                <input id="quantity" type="text" value="1" class="w-16 text-center text-gray-700 focus:outline-none">
                                <button id="increment" class="px-4 py-2 text-gray-600 hover:text-gray-800 focus:outline-none">+</button>
                            </div>
                            <button type="submit" class="bg-[#F566BC] text-white px-14 py-2 rounded-full hover:bg-[#EC59A0] flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.4 5.6a1 1 0 001 1.4h12a1 1 0 001-1.4L17 13M7 13H5.4M5.4 5L7 13m0 0h10m-6 8a2 2 0 100-4 2 2 0 000 4z" />
                                </svg>
                                Add to Cart
                            </button>
                            <!-- Wishlist Icon -->
                            <button class="text-gray-500 hover:text-[#F566BC] focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                                </svg>
                                <span class="sr-only">Add to Wishlist</span>
                            </button>
                        </div>
                        <div class="flex justify-between items-center mt-4">
                            <!-- Total Price -->
                            <p class="text-lg font-semibold text-gray-800">
                                Total Price: ₱<span id="total-price">{{ number_format($product->price, 2) }}</span>
                            </p>

                            <!-- Place Order Button -->
                            <button type="submit" class="bg-gradient-to-r from-pink-500 to-yellow-400 text-white px-6 py-2 rounded-full text-lg font-semibold hover:from-pink-600 hover:to-yellow-500 transition duration-300 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
                                </svg>
                                Place Order
                            </button>
                        </div>


                    </div>
                </div>
            </div>
        @else
            <div class="text-center text-gray-600">
                <p>Product not found.</p>
            </div>
        @endif
    </div>
    

    
    <div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Our Products</h2>

    @if($products->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
                <div class="bg-white shadow-lg rounded-xl overflow-hidden transition-transform transform hover:scale-105">
                    <a href="{{ route('product.details', ['product_id' => $product->product_id]) }}">
                        <img src="{{ $product->primaryImage ? asset($product->primaryImage->image_url) : 'https://via.placeholder.com/300' }}" 
                            alt="{{ $product->product_name }}" 
                            class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $product->product_name }}</h3>
                            <p class="text-gray-600 text-sm mt-1 truncate">{{ Str::limit($product->description, 50, '...') }}</p>
                            <p class="text-[#EC59A0] font-bold text-lg mt-2">₱{{ number_format($product->price, 2) }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="mt-8 flex justify-center">
            {{ $products->onEachSide(1)->links() }}
        </div>

    @else
        <p class="text-center text-gray-500 text-lg">No products available.</p>
    @endif

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

    <script>
        document.getElementById('card_message').addEventListener('change', function () {
            document.getElementById('message_box').classList.toggle('hidden', !this.checked);
        });
    </script>


    <script>
        document.getElementById('increment').addEventListener('click', function () {
            let qty = document.getElementById('quantity');
            qty.value = parseInt(qty.value) + 1;
        });

        document.getElementById('decrement').addEventListener('click', function () {
            let qty = document.getElementById('quantity');
            if (parseInt(qty.value) > 1) {
                qty.value = parseInt(qty.value) - 1;
            }
        });
    </script>


    <script>
        // Get elements
        let qty = document.getElementById('quantity');
        let totalPrice = document.getElementById('total-price');
        
        // Set base price from PHP
        let basePrice = {{ $product->price }}; // Assuming PHP variable is available

        // Function to update total price
        function updateTotalPrice() {
            let quantity = parseInt(qty.value);
            totalPrice.textContent = (basePrice * quantity).toFixed(2);
        }

        // Event Listeners for increment and decrement
        document.getElementById('increment').addEventListener('click', function () {
            qty.value = parseInt(qty.value) + 1;
            updateTotalPrice();
        });

        document.getElementById('decrement').addEventListener('click', function () {
            if (parseInt(qty.value) > 1) {
                qty.value = parseInt(qty.value) - 1;
                updateTotalPrice();
            }
        });

        // Initialize total price
        updateTotalPrice();
    </script>

</body>
</html>