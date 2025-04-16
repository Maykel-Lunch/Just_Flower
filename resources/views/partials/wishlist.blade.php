<!-- Heart Wishlist Button -->
<div 
    x-data="{ 
        liked: {{ $isInWishlist ? 'true' : 'false' }}, 
        showToast: false, 
        toastMessage: '', 
        productId: {{ $product->product_id }} 
    }" 
    class="relative inline-block"
>
    <!-- Toast Notification -->
    <div 
        x-show="showToast" 
        x-transition:enter="transform ease-out duration-300" 
        x-transition:enter-start="scale-75 opacity-0" 
        x-transition:enter-end="scale-100 opacity-100" 
        x-transition:leave="transform ease-in duration-200" 
        x-transition:leave-start="scale-100 opacity-100" 
        x-transition:leave-end="scale-75 opacity-0" 
        class="absolute left-1/2 -translate-x-1/2 bottom-full mb-2 bg-[#F566BC] text-white text-sm font-semibold rounded-lg px-4 py-2 shadow-xl flex items-center space-x-2 z-50 max-w-xs whitespace-nowrap"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span x-text="toastMessage" class="flex-grow text-center"></span>
    </div>

    <!-- Heart Wishlist Button -->
    <button
        @click="
            const self = $data;
            const prevLiked = liked;
            liked = !liked;
            toastMessage = liked ? 'Added to Wishlist' : 'Removed from Wishlist';
            showToast = true;
            setTimeout(() => showToast = false, 1500);
            addToWishlist(productId, self, prevLiked);
        "
        class="focus:outline-none"
    >
        <svg 
            xmlns="http://www.w3.org/2000/svg" 
            :class="{
                'text-[#F566BC] fill-current animate-heartbeat': liked,
                'text-gray-500': !liked
            }"
            class="h-8 w-8 transition-all duration-300 ease-out"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
        >
            <path 
                stroke-linecap="round" 
                stroke-linejoin="round" 
                stroke-width="2"
                d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z"
                :fill="liked ? '#F566BC' : 'none'"
            />
        </svg>
        <span class="sr-only">Toggle Wishlist</span>
    </button>
</div>

<script>
    function addToWishlist(productId, stateRef, previousLiked) {
        fetch(`/wishlist/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ productId: productId })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Server error');
            }
            return response.json();
        })
        .then(data => {
            console.log(data.message);
        })
        .catch(error => {
            console.error('Error:', error);
            // Rollback state and show error
            stateRef.liked = previousLiked;
            stateRef.toastMessage = 'Something went wrong!';
            stateRef.showToast = true;
            setTimeout(() => stateRef.showToast = false, 2000);
        });
    }
</script>
