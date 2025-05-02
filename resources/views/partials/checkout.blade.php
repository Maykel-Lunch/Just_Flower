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
                        <p class="font-medium text-lg">P-4, Prieto Street Banuyo (Pob.), ...</p>
                        <p class="text-gray-600">John Russel Soreda</p>
                        <p class="mt-2 text-gray-500">Coins cannot be redeemed 😊</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Contact Information</h2>
                        <p class="font-medium">Email: example@email.com</p>
                        <p class="text-gray-600">Phone: +63 912 345 6789</p>
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
                                    <span class="text-lg">ShopeePay</span>
                                </div>
                                <span class="text-gray-600">📌32.23</span>
                            </div>
                        </div>
                        
                        <!-- Right Column -->
                        <div class="space-y-3">
                            
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
                                <span id="shipping-fee" class="font-medium">₱80.00</span>
                            </div>

                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping Discount</span>
                                <span class="text-green-600">-₱110</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Taxes</span>
                                <span class="font-medium">₱0.00</span>
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
                            <span class="text-2xl font-bold text-orange-500">📌1,710</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Savings</span>
                            <span class="text-green-600">📌110</span>
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
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('checkoutModal');
        const openBtn = document.getElementById('openCheckoutModal');
        const closeBtn = document.getElementById('closeCheckoutModal');
        const totalPriceElement = modal.querySelector('#checkout-total-price');

        // Open modal
        if (openBtn) {
            openBtn.addEventListener('click', () => {
                // Get the updated total price from the hidden input
                const hiddenTotalPrice = document.getElementById('hidden-total-price');
                if (hiddenTotalPrice && totalPriceElement) {
                    totalPriceElement.textContent = `₱${parseFloat(hiddenTotalPrice.value).toLocaleString("en-PH", { 
                        minimumFractionDigits: 2 
                    })}`;
                }

                // Show the modal
                modal.classList.remove('hidden');
                modal.classList.add('flex', 'items-center', 'justify-center');
                document.body.style.overflow = 'hidden';
            });
        }

        // Close modal
        const closeModal = () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex', 'items-center', 'justify-center');
            document.body.style.overflow = '';
        };

        // Close handlers
        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => e.target === modal && closeModal());
        document.addEventListener('keydown', (e) => e.key === 'Escape' && !modal.classList.contains('hidden') && closeModal());
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Fetch free shipping eligibility
        fetch('{{ route('check.freeShipping') }}')
            .then(response => response.json())
            .then(data => {
                const shippingFeeElement = document.getElementById('shipping-fee');
                if (data.freeShipping) {
                    shippingFeeElement.textContent = '₱0.00'; // Free shipping
                } else {
                    shippingFeeElement.textContent = '₱80.00'; // Standard shipping fee
                }
            })
            .catch(error => console.error('Error checking free shipping:', error));
    });
</script>