@extends('layouts.app')

@section('title', 'Products')

@section('content')
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
                        <!-- <p class="text-lg font-semibold text-gray-800 mt-4">Price: ₱{{ number_format($product->price, 2) }}</p> -->
                        <p class="price">Price: ₱<span id="product-price">{{ number_format($product->price, 2) }}</span></p>

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
                        <div class="mt-6 flex items-center space-x-4" x-data="{ showModal: localStorage.getItem('cartModal') === 'true' }" >
                            
                            <form action="{{ route('cart.add') }}" method="POST" class="flex items-center space-x-4" id="cartForm">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                                
                                <!-- Quantity Selector -->
                                <div class="flex items-center border border-gray-300 rounded-full">
                                    <button type="button" id="decrement" class="px-4 py-2 text-gray-600 hover:text-gray-800 focus:outline-none">-</button>
                                    <input id="quantity" name="quantity" type="number" value="1" min="1" class="w-16 text-center text-gray-700 focus:outline-none">
                                    <button type="button" id="increment" class="px-4 py-2 text-gray-600 hover:text-gray-800 focus:outline-none">+</button>
                                </div>

                                <!-- Add to Cart Button -->
                                <button type="submit" class="bg-gradient-to-r from-[#EBC980] to-[#EC59A0] text-white px-6 py-2 rounded-full hover:opacity-90 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.4 5.6a1 1 0 001 1.4h12a1 1 0 001-1.4L17 13M7 13H5.4M5.4 5L7 13m0 0h10m-6 8a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                    Add to Cart
                                </button>
                            </form>

                            <!-- Wishlist Icon -->
                            <button class="text-gray-500 hover:text-[#F566BC] focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                                </svg>
                                <span class="sr-only">Add to Wishlist</span>
                            </button>

                            <!-- Ang random ng animation (fix this latur) -->
                            <!-- Modal (Success Message) -->
                            <div x-show="showModal" x-transition.opacity 
                                @click="showModal = false; localStorage.removeItem('cartModal')"
                                x-init="$el.classList.add('animate-bounce'); setTimeout(() => $el.classList.remove('animate-bounce'), 1000)" 
                                class="fixed left-1/2 transform -translate-x-1/2 top-20 bg-gradient-to-r from-[#EBC980] to-[#EC59A0] text-white px-8 py-4 rounded-xl shadow-2xl cursor-pointer flex items-center space-x-4">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
                                </svg>
                                <span class="text-lg font-semibold">Successfully added to cart! Click to close.</span>
                            </div>

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


            <nav class="flex justify-center mt-6"> <!-- Added margin-top -->
                <ul class="inline-flex items-center -space-x-px">
                    <li>
                        <a href="{{ $products->previousPageUrl() }}" class="px-3 py-2 ml-0 leading-tight text-[#F566BC] bg-white border border-[#F566BC] rounded-l-lg hover:bg-[#F566BC] hover:text-white">
                            Prev
                        </a>
                    </li>
                    @foreach ($products->links()->elements as $element)
                        @foreach ($element as $page => $url)
                            <li>
                                <a href="{{ $url }}" class="px-3 py-2 leading-tight text-black border border-[#F566BC] hover:bg-[#F566BC] hover:text-white {{ $page == $products->currentPage() ? 'bg-[#F566BC] text-white' : 'bg-white' }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @endforeach
                    @endforeach
                    <li>
                        <a href="{{ $products->nextPageUrl() }}" class="px-3 py-2 leading-tight text-[#F566BC] bg-white border border-[#F566BC] rounded-r-lg hover:bg-[#F566BC] hover:text-white">
                            Next
                        </a>
                    </li>
                </ul>
            </nav>
        @else
            <p class="text-center text-gray-500 text-lg">No products available.</p>
        @endif

    </div>

    <!-- Combine these js scripts into 1 or make this in a separate file -->
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

    <script>
        document.getElementById('card_message').addEventListener('change', function () {
            document.getElementById('message_box').classList.toggle('hidden', !this.checked);
        });
    </script>

    <script>
        document.getElementById('cartForm').addEventListener('submit', function() {
            // Store modal state before form submits
            localStorage.setItem('cartModal', 'true');
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const quantityInput = document.getElementById("quantity");
            const totalPriceElement = document.getElementById("total-price");
            const incrementButton = document.getElementById("increment");
            const decrementButton = document.getElementById("decrement");

            incrementButton.addEventListener("click", function () {
                quantityInput.value = parseInt(quantityInput.value) + 1;
            });

            function getPrice() {
                // Dynamically fetch the price from the DOM
                return parseFloat(document.getElementById("product-price").textContent.replace(/[^0-9.]/g, ""));
            }

            function updateTotalPrice() {
                const price = getPrice(); // Fetch the current price
                let quantity = parseInt(quantityInput.value) || 1;
                if (quantity < 1) quantity = 1;
                totalPriceElement.textContent = (price * quantity).toLocaleString("en-PH", { minimumFractionDigits: 2 });
            }

            incrementButton.addEventListener("click", function () {
                quantityInput.value = parseInt(quantityInput.value) + 1;
                updateTotalPrice();
            });

            decrementButton.addEventListener("click", function () {
                if (parseInt(quantityInput.value) > 1) {
                    quantityInput.value = parseInt(quantityInput.value) - 1;
                    updateTotalPrice();
                }
            });

            quantityInput.addEventListener("input", updateTotalPrice);

            updateTotalPrice();
        });
    </script>


@endsection