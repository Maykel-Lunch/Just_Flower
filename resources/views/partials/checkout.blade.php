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
                        <!-- <div class="flex justify-between">
                            <span class="text-gray-600">Total Savings</span>
                            <span id = "discount-amount" class="text-green-600">-₱0.00</span>
                        </div> -->
                    </div>
                    
                    <!-- Updated Form -->
                    <form action="{{ route('orders.place') }}" method="POST" id="orderForm">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                        <input type="hidden" name="quantity" id="order-quantity" value="1">
                        <input type="hidden" name="total_amount" id="order-total" value="{{ $product->price }}">
                        <input type="hidden" name="final_amount" id="order-final" value="{{ $product->price }}">
                        <input type="hidden" name="product_name" value="{{ $product->product_name }}">
                        <input type="hidden" name="unit_price" id="order-unit-price" value="{{ $product->price }}">
                        
                        <button type="submit" class="w-full bg-gradient-to-r from-pink-500 to-yellow-400 text-white py-4 rounded-lg font-bold text-lg hover:from-pink-600 hover:to-yellow-500 transition duration-300 flex items-center justify-center" {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
                            </svg>
                            {{ $product->stock_quantity <= 0 ? 'Out of Stock' : 'Place Order Now' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal with Receipt Design -->
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden overflow-y-auto">
    <div class="min-h-full py-8 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96 mx-auto my-8 text-center">
            <!-- Receipt Header -->
            <div class="border-b-2 border-dashed border-gray-300 pb-4 mb-4">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Just Flower</h2>
                <p class="text-sm text-gray-600">Zone 4, Marifosque, Pilar, Philippines</p>
                <p class="text-sm text-gray-600">Tel: 0910 494 8212</p>
                <p class="text-sm text-gray-600">Date: <span id="receipt-date"></span></p>
                <p class="text-sm text-gray-600">Order #: <span id="receipt-order-id"></span></p>
            </div>

            <!-- Order Details -->
            <div class="text-left mb-4">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Product:</span>
                    <span id="receipt-product-name" class="font-medium"></span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Quantity:</span>
                    <span id="receipt-quantity" class="font-medium"></span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Unit Price:</span>
                    <span id="receipt-unit-price" class="font-medium"></span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Subtotal:</span>
                    <span id="receipt-subtotal" class="font-medium"></span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Shipping:</span>
                    <span id="receipt-shipping" class="font-medium"></span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Discount:</span>
                    <span id="receipt-discount" class="font-medium"></span>
                </div>
                <div class="border-t-2 border-dashed border-gray-300 my-2"></div>
                <div class="flex justify-between font-bold">
                    <span>Total:</span>
                    <span id="receipt-total" class="text-green-600"></span>
                </div>
            </div>

            <!-- Payment Status -->
            <div class="border-t-2 border-dashed border-gray-300 pt-4 mb-4">
                <p class="text-sm text-gray-600">Payment Status: <span class="text-green-600 font-medium">Pending</span></p>
                <p class="text-sm text-gray-600">Delivery Status: <span class="text-blue-600 font-medium">Processing</span></p>
            </div>

            <!-- Thank You Message -->
            <div class="border-t-2 border-dashed border-gray-300 pt-4">
                <h3 class="text-lg font-bold text-green-600 mb-2">Thank You!</h3>
                <p class="text-sm text-gray-600 mb-4">Your order has been placed successfully.</p>
                <button id="closeSuccessModal" class="bg-green-500 hover:bg-green-600 text-white py-2 px-6 rounded-lg transition duration-300">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const successModal = document.getElementById('successModal');
        const closeSuccessModal = document.getElementById('closeSuccessModal');

        // Function to format currency
        const formatCurrency = (amount) => {
            return '₱' + parseFloat(amount).toFixed(2);
        };

        // Function to update receipt details
        const updateReceiptDetails = (orderData) => {
            // Format the order ID with leading zeros
            const productId = orderData.product_id.toString().padStart(3, '0');
            const orderId = orderData.order_id.toString().padStart(3, '0');
            const formattedOrderId = `ORD-${productId}${orderId}`;

            document.getElementById('receipt-date').textContent = new Date().toLocaleDateString();
            document.getElementById('receipt-order-id').textContent = formattedOrderId;
            document.getElementById('receipt-product-name').textContent = orderData.product_name;
            document.getElementById('receipt-quantity').textContent = orderData.quantity;
            document.getElementById('receipt-unit-price').textContent = formatCurrency(orderData.unit_price);
            document.getElementById('receipt-subtotal').textContent = formatCurrency(orderData.total_amount);
            document.getElementById('receipt-shipping').textContent = formatCurrency(orderData.free_shipping ? 0 : 80);
            document.getElementById('receipt-discount').textContent = formatCurrency(orderData.discount);
            document.getElementById('receipt-total').textContent = formatCurrency(orderData.final_amount);

            // Log the values for debugging
            console.log('Receipt Details:', {
                productId,
                orderId,
                formattedOrderId,
                ...orderData
            });
        };

        // Check if the success message exists in the session
        if (@json(session('order_success'))) {
            // Get order data from the form
            const orderForm = document.getElementById('orderForm');
            if (orderForm) {
                const orderData = {
                    product_id: orderForm.querySelector('[name="product_id"]').value,
                    order_id: @json(session('order_id')),
                    product_name: orderForm.querySelector('[name="product_name"]').value,
                    quantity: orderForm.querySelector('[name="quantity"]').value,
                    unit_price: document.getElementById('product-price').textContent.replace(/[^\d.]/g, ''),
                    total_amount: orderForm.querySelector('[name="total_amount"]').value,
                    final_amount: orderForm.querySelector('[name="final_amount"]').value,
                    free_shipping: @json($freeShipping ?? false),
                    discount: @json($discount ?? 0)
                };
                updateReceiptDetails(orderData);
            }
            successModal.classList.remove('hidden');
        }

        // Close the modal when the close button is clicked
        closeSuccessModal.addEventListener('click', function () {
            successModal.classList.add('hidden');
        });

        // Close the modal when clicking outside
        successModal.addEventListener('click', function (e) {
            if (e.target === successModal) {
                successModal.classList.add('hidden');
            }
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const totalAmountInput = document.getElementById('hidden-total-amount');
        const finalAmountInput = document.getElementById('hidden-final-amount');
        const totalPriceElement = document.getElementById('checkout-total-price');
        const discountAmountElement = document.getElementById('discount-amount');
        const shippingFeeElement = document.getElementById('shipping-fee');

        const extractPrice = (priceString) => parseFloat(priceString.replace(/[^\d.]/g, '')) || 0;

        const updateHiddenInputs = () => {
            const merchandiseTotal = extractPrice(totalPriceElement.textContent);
            const discount = extractPrice(discountAmountElement.textContent);
            const shippingFee = extractPrice(shippingFeeElement.textContent);
            const finalAmount = merchandiseTotal - discount + shippingFee;

            totalAmountInput.value = merchandiseTotal.toFixed(2);
            finalAmountInput.value = finalAmount.toFixed(2);
        };

        // Update hidden inputs on page load and whenever prices change
        updateHiddenInputs();
        const observer = new MutationObserver(updateHiddenInputs);
        observer.observe(totalPriceElement, { childList: true, characterData: true, subtree: true });
    });
</script>

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

        // console.log('[Discount Debug] Membership:', membershipLvl);
        // console.log('[Discount Debug] Original Price:', originalPrice);

        let discount = 0;

        // Apply discount based on membership level and price threshold 
        if (membershipLvl.includes('silver') && originalPrice >= 500) {
            discount = Math.min(originalPrice * 0.05, 50); // 5% discount, max ₱50
        } else if (membershipLvl.includes('gold') && originalPrice >= 500) {
            discount = Math.min(originalPrice * 0.10, 100); // 10% discount, max ₱100
        } else if (membershipLvl.includes('platinum') && originalPrice >= 200) {
            discount = originalPrice * 0.15; // 15% discount, no max
        }

        // console.log('[Discount Debug] Calculated Discount:', discount);

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

<script>
document.getElementById('orderForm').addEventListener('submit', function(e) {
    // Get the unit price from the product price element
    const unitPrice = parseFloat(document.getElementById('product-price').textContent.replace(/[^\d.]/g, ''));
    const quantity = parseInt(document.getElementById('order-quantity').value);
    const totalAmount = unitPrice * quantity;
    
    // Calculate final amount (including shipping and discount)
    const shippingFee = {{ $freeShipping ? 0 : 80 }};
    const discount = {{ $discount ?? 0 }};
    const finalAmount = totalAmount + shippingFee - discount;

    // Update hidden input values
    document.getElementById('order-unit-price').value = unitPrice;
    document.getElementById('order-total').value = totalAmount;
    document.getElementById('order-final').value = finalAmount;

    // Log the values for debugging
    console.log('Price Calculation:', {
        unitPrice,
        quantity,
        totalAmount,
        shippingFee,
        discount,
        finalAmount
    });
});
</script>

