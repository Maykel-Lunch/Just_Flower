<!-- Ang random ng animation (fix this latur) -->
<!-- Modal (Success Message) -->
<!-- <div x-show="showModal" x-transition.opacity 
    @click="showModal = false; localStorage.removeItem('cartModal')"
    x-init="$el.classList.add('animate-bounce'); setTimeout(() => $el.classList.remove('animate-bounce'), 1000)" 
    class="fixed left-1/2 transform -translate-x-1/2 top-20 bg-gradient-to-r from-[#EBC980] to-[#EC59A0] text-white px-8 py-4 rounded-xl shadow-2xl cursor-pointer flex items-center space-x-4">

    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
    </svg>
    <span class="text-lg font-semibold">Successfully added to cart! Click to close.</span>
</div> -->

<!-- <div x-show="showModal"
    x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="opacity-0 scale-75"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-75"
    @click="showModal = false; localStorage.removeItem('cartModal')"
    x-init="
        $el.style.opacity = '0';
        $el.style.transform = 'scale(0.75)';
        setTimeout(() => {
            $el.classList.add('animate-[bounce_0.8s_ease-in-out_2]');
            $el.style.opacity = '1';
            $el.style.transform = 'scale(1)';
        }, 10);
    "
    class="fixed inset-0 flex items-center justify-center z-50">
    

    <div class="bg-gradient-to-r from-[#EBC980] to-[#EC59A0] text-white px-8 py-4 rounded-xl shadow-2xl cursor-pointer flex items-center space-x-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
        </svg>
        <span class="text-lg font-semibold">Successfully added to cart! Click to close.</span>
    </div>
</div> -->
<!-- <div x-data="{ showModal: false }">
    <div x-show="showModal"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-8"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-8"
        @click="showModal = false;"
        x-init="
            $el.style.transform = 'translate(-50%, 20px)';
            $el.style.opacity = '0';
            setTimeout(() => {
                $el.style.transform = 'translate(-50%, 0)';
                $el.style.opacity = '1';
                // Enhanced bounce animation
                const bounce = () => {
                    $el.style.transform = 'translate(-50%, -10px)';
                    setTimeout(() => {
                        $el.style.transform = 'translate(-50%, 5px)';
                        setTimeout(() => {
                            $el.style.transform = 'translate(-50%, -3px)';
                            setTimeout(() => {
                                $el.style.transform = 'translate(-50%, 0)';
                            }, 100);
                        }, 100);
                    }, 150);
                };
                bounce();
            }, 20);
        "
        class="fixed left-1/2 top-20 z-50 transform -translate-x-1/2">

        <div class="bg-gradient-to-r from-[#EBC980] to-[#EC59A0] text-white px-8 py-4 rounded-xl shadow-2xl cursor-pointer flex items-center space-x-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
            </svg>
            <span class="text-lg font-semibold">Successfully added to cart! Click to close.</span>
        </div>
    </div>
</div> -->




<!-- Another version -->
<!-- <div x-show="showModal" x-cloak x-transition.opacity.duration.300ms class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-80">
        <h2 class="text-lg font-semibold text-gray-800">Product Added to Cart</h2>
        <p class="text-sm text-gray-600 mt-2">Your product has been successfully added to the cart.</p>
        <div class="mt-4 flex justify-end space-x-4">
            <button @click="showModal = false" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                Close
            </button>
            <a href="{{ route('cart.view') }}" class="px-4 py-2 bg-[#EBC980] text-white rounded hover:bg-[#EC59A0]">
                View Cart
            </a>
        </div>
    </div>
</div> -->


<!-- Edit the animation here if wanted -->
<div x-show="showModal"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-8"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-8"
    @click="showModal = false; localStorage.removeItem('cartModal')"
    
    x-init="
        $el.style.transform = 'translate(-50%, 20px)';
        $el.style.opacity = '0';
        setTimeout(() => {
            $el.style.transform = 'translate(-50%, 0)';
            $el.style.opacity = '1';
            // Enhanced bounce animation
            const bounce = () => {
                $el.style.transform = 'translate(-50%, -10px)';
                setTimeout(() => {
                    $el.style.transform = 'translate(-50%, 5px)';
                    setTimeout(() => {
                        $el.style.transform = 'translate(-50%, -3px)';
                        setTimeout(() => {
                            $el.style.transform = 'translate(-50%, 0)';
                        }, 100);
                    }, 100);
                }, 150);
            };
            bounce();
        }, 20);
    "
    class="fixed left-1/2 top-20 z-50 transform -translate-x-1/2">

    <div class="bg-gradient-to-r from-[#EBC980] to-[#EC59A0] text-white px-8 py-4 rounded-xl shadow-2xl cursor-pointer flex items-center space-x-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
        </svg>
        <span class="text-lg font-semibold">Successfully added to cart! Click to close.</span>
    </div>
</div>
