<div id="checkoutModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <!-- EXTRA WIDE - max-w-4xl (56rem/896px) -->
        <div class="w-full max-w-4xl bg-white rounded-lg shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="p-4 border-b relative">
                <h1 class="text-2xl font-bold">Checkout</h1>
                <button id="closeCheckoutModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-3xl">&times;</button>
            </div>
            
            <!-- Scrollable Content -->
            <div class="max-h-[calc(100vh-200px)] overflow-y-auto">
                <!-- Shipping Address - Now with 2-column layout -->
                <div class="p-6 border-b grid grid-cols-2 gap-6">
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Shipping Address</h2>
                        <p class="font-medium">{{ $shippingAddress }}</p>
                        <p class="text-gray-600">{{ $user->name }}</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Contact Information</h2>
                        <p class="font-medium">Email: {{ $contactEmail }}</p>
                        <p class="text-gray-600">Phone: {{ $contactPhone }}</p>
                    </div>
                </div>
                
                <!-- Product Details -->
                <div class="p-6 border-b">
                    <h2 class="text-xl font-bold mb-4">Product Details</h2>
                    <div class=" grid grid-cols-2 gap-6">
                        <div>
                            <p class="font-medium">{{ $product->product_name }}</p>
                            <p class="text-gray-600 text-sm">Quantity: <span class="modal-quantity">1</span></p>
                        </div>
                        <div>
                            <img src="{{ $product->primaryImage ? asset($product->primaryImage->image_url) : 'https://via.placeholder.com/150' }}" alt="{{ $product->product_name }}" class="w-48 h-48 object-cover rounded-lg mr-4">
                        </div>
                    </div>
                </div>

                <!-- Membership Card -->
                <div class="p-6 border-b">
                    <h2 class="text-xl font-bold mb-4">Product Details</h2>
                    <div class="flex justify-center">
                        @if($cardType === 'Non-Member')
                            <p class="text-gray-600">You are currently not a member. Enjoy shopping as a guest!</p>
                        @else
                            <div class="p-4 rounded-lg shadow-md text-center w-96 bg-gradient-to-r {{ $cardBg }}">
                                <h2 class="text-xl font-bold text-white mb-2">{{ $cardType }}</h2>
                                @if($cardType === 'Welcome Card')
                                    <p class="text-white">Enjoy your first purchase with exclusive benefits!</p>
                                @else
                                    <p class="text-white">Exclusive benefits for our valued members!</p>
                                @endif
                            </div>
                        @endif
                    </div> 
                </div>

                <!-- Payment Methods - Wider layout -->
                <div class="p-6 border-b">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Payment Methods</h2>
                        <button class="text-blue-500 hover:text-blue-700">View All Payment Options →</button>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Left Column -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                                <div class="flex items-center">
                                    <input type="radio" name="payment" checked class="mr-3 h-5 w-5">
                                    <span class="text-lg">Cash on Delivery</span>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                                <div class="flex items-center">
                                    <input type="radio" name="payment" class="mr-3 h-5 w-5">
                                    <span class="text-lg">Gcash</span>
                                </div>
                                <!-- <span class="text-gray-600">₱32.23</span>   if there are additional fees for Gcash payment, you can uncomment this line -->
                            </div>
                        </div>
                        
                        <!-- Right Column -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                                <div class="flex items-center">
                                    <input type="radio" name="payment" class="mr-3 h-5 w-5">
                                    <span class="text-lg">Maya</span>
                                </div>
                                <!-- <span class="text-gray-600">₱32.23</span>   if there are additional fees for Gcash payment, you can uncomment this line -->
                            </div>
                        </div>
                    </div>
                
                </div>
                
                <!-- Payment Details - Wider layout -->
                <div class="p-6 border-b">
                    <h2 class="text-xl font-bold mb-4">Payment Details</h2>
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Merchandise Subtotal</span>
                                <span id="checkout-total-price" class="font-medium">₱0.00</span>
                            </div>

                            
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping Fee</span>
                                <span id="shipping-fee" class="font-medium {{ $freeShipping ? 'text-green-600' : '' }}">
                                    {{ $freeShipping ? '₱0.00' : '₱80.00' }}
                                </span>
                            </div>

                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Discount</span>
                                <span id="discount-amount" class="text-green-600">
                                -₱0.00
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Summary (Sticky Bottom) - Wider layout -->
            <div class="p-6 border-t bg-white sticky bottom-0">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-lg font-bold">Total Payment</span>
                            <span class="text-2xl font-bold text-orange-500">₱1,710</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Savings</span>
                            <span class="text-green-600">-₱110</span>
                        </div>
                    </div>
                    <button class="w-full bg-orange-500 hover:bg-orange-600 text-white py-4 rounded-lg font-bold text-lg transition-colors">
                        Place Order Now
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('checkoutModal');
    const openBtn = document.getElementById('openCheckoutModal');
    const closeBtn = document.getElementById('closeCheckoutModal');
    const totalPriceElement = document.getElementById('checkout-total-price');
    const discountAmountElement = document.getElementById('discount-amount');
    const shippingFeeElement = document.getElementById('shipping-fee');

    // Helper function to extract numeric value from price string
    const extractPrice = (priceString) => {
        return parseFloat(priceString.replace(/[^\d.]/g, '')) || 0;
    };

    // Function to calculate and apply discounts
    const applyDiscount = () => {
        const originalPrice = extractPrice(totalPriceElement.textContent);
        const membershipLvl = "{{ strtolower(trim($cardType)) }}".toLowerCase().trim();

        console.log('[Discount Debug] Membership:', membershipLvl);
        console.log('[Discount Debug] Original Price:', originalPrice);

        let discount = 0;

        // Apply discount based on membership level and price threshold
        if (membershipLvl.includes('silver') && originalPrice >= 500) {
            discount = Math.min(originalPrice * 0.05, 50); // 5% discount, max ₱50
        } else if (membershipLvl.includes('gold') && originalPrice >= 500) {
            discount = Math.min(originalPrice * 0.10, 100); // 10% discount, max ₱100
        } else if (membershipLvl.includes('platinum') && originalPrice >= 200) {
            discount = originalPrice * 0.15; // 15% discount, no max
        }

        console.log('[Discount Debug] Calculated Discount:', discount);

        // Update discount display
        discountAmountElement.textContent = `-₱${discount.toFixed(2)}`;

        // Update total payment
        const totalPaymentElement = document.querySelector('.text-orange-500');
        if (totalPaymentElement) {
            const shippingFee = extractPrice(shippingFeeElement.textContent);
            const totalPayment = originalPrice - discount + shippingFee;
            totalPaymentElement.textContent = `₱${totalPayment.toLocaleString("en-PH", {
                minimumFractionDigits: 2
            })}`;
        }
    };

    // Function to open the modal
    const openModal = () => {
        const hiddenTotalPrice = document.getElementById('hidden-total-price');
        if (hiddenTotalPrice && totalPriceElement) {
            const priceValue = parseFloat(hiddenTotalPrice.value) || 0;
            totalPriceElement.textContent = `₱${priceValue.toLocaleString("en-PH", {
                minimumFractionDigits: 2
            })}`;
            
            // Apply discount after price is set
            applyDiscount();
        }

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };

    // Function to close the modal
    const closeModal = () => {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    };

    // Event listeners
    if (openBtn) openBtn.addEventListener('click', openModal);
    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });

    // Initialize shipping fee (assuming this function exists)
    if (typeof fetchFreeShipping === 'function') {
        fetchFreeShipping();
    }

    // Observer for price changes (optional)
    if (totalPriceElement) {
        const observer = new MutationObserver(() => {
            applyDiscount();
            if (typeof fetchFreeShipping === 'function') {
                fetchFreeShipping();
            }
        });

        observer.observe(totalPriceElement, { 
            childList: true, 
            characterData: true,
            subtree: true
        });
    }
});
</script>