    <style>
        /* Custom CSS to enhance the Swiper */
        .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background-color: #d1d5db;
            opacity: 1;
        }
        .swiper-pagination-bullet-active {
            background-color: #ff6b6b;
            width: 24px;
            border-radius: 6px;
        }
    </style>


    <div class="container mx-auto px-4 py-12">
        <!-- Header with Mother's Day theme -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-[#ff6b6b] mb-2">Mother's Day Special Sale</h1>
            <p class="text-xl text-gray-600">Treat the special woman in your life with these thoughtful gifts</p>
            <div class="mt-4">
                <span class="inline-block bg-pink-400 text-white px-4 py-1 rounded-full text-sm font-medium">
                    Limited Time Offers
                </span>
            </div>
        </div>
        
        <!-- Swiper container -->
        <div class="swiper motherDaySwiper relative">
            <div class="swiper-wrapper pb-12">
                @foreach ($mothersDayProducts as $product)
                    <div class="swiper-slide px-4">
                        <a href="{{ route('product.details', ['product_id' => $product->product_id]) }}" class="block">
                            <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1 relative h-full flex flex-col">
                                <!-- Product Image -->
                                <div class="h-64 overflow-hidden flex-shrink-0">
                                    @if($product->primaryImage)
                                        <img
                                            src="{{ $product->primaryImage->image_url }}"
                                            alt="{{ $product->product_name }}"
                                            class="w-full h-full object-cover"
                                        />
                                    @else
                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400 text-4xl"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Product Details -->
                                <div class="p-4 flex-grow flex flex-col">
                                    <h3 class="text-lg font-semibold mb-2">{{ $product->product_name }}</h3>
                                    
                                    <!-- Rating (static for now) -->
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <i class="fas fa-star text-yellow-400"></i>
                                        <i class="fas fa-star-half-alt text-yellow-400"></i>
                                        <span class="text-gray-600 ml-2">4.8</span>
                                    </div>
                                    
                                    <!-- Price -->
                                    <div class="mt-auto">
                                        <p class="text-xl font-bold text-red-500">
                                            <span class="line-through text-gray-500 text-base mr-2">${{ number_format($product->price, 2) }}</span>
                                            <span class="text-red-500">${{ number_format($product->price * 0.9, 2) }}</span>
                                        </p>
                                                                    
                                        <!-- Add to Cart Button -->
                                        <button
                                            class="mt-4 w-full bg-gradient-to-r from-[#EBC980] to-[#EC59A0] text-white py-2 rounded-md hover:opacity-90 transition-all font-medium"
                                        >
                                            <i class="fas fa-gift mr-2"></i> Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="swiper-pagination !bottom-0"></div>

            <!-- Navigation Buttons -->
            <div class="swiper-button-prev bg-pink-500 rounded-full w-10 h-10 flex items-center justify-center shadow-md hover:bg-red-500 text-white transition-colors after:hidden">
                <i class="fas fa-chevron-left text-sm"></i>
            </div>
            <div class="swiper-button-next bg-pink-500 rounded-full w-10 h-10 flex items-center justify-center shadow-md hover:bg-red-500 text-white transition-colors after:hidden">
                <i class="fas fa-chevron-right text-sm"></i>
            </div>
        </div>
        
        <!-- Special Mother's Day CTA -->
        <div class="mt-16 text-center">
            <h3 class="text-2xl font-semibold text-purple-500 mb-4">Don't miss our exclusive Mother's Day bundles!</h3>
            <button class="bg-gradient-to-r from-[#ff9bb3] to-[#b399d4] text-white px-8 py-3 rounded-full font-bold hover:shadow-lg transition-all hover:scale-105">
                Shop All Mother's Day Gifts
            </button>
        </div>
    </div>

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
    </script>
</html>