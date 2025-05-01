@extends('layouts.app')

@section('title', 'My Cart')

@section('content')
    <div class="max-w-4xl mx-auto py-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Your Cart ({{ $cartItems->count() }})</h1>

        @if ($cartItems->isEmpty())
            <p class="text-gray-600">Your cart is empty.</p>
        @else
            <div class="bg-white rounded-lg shadow-md p-6">
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Product</th>
                            <th class="text-center py-2">Quantity</th>
                            <th class="text-right py-2">Price</th>
                            <th class="text-right py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $item)
                            <tr class="border-b">
                                <td class="py-4 flex items-center">
                                    <img src="{{ $item->product && $item->product->primaryImage ? asset($item->product->primaryImage->image_url) : 'https://via.placeholder.com/150' }}" 
                                    alt="{{ $item->product ? $item->product->product_name : 'Product Image' }}" 
                                    class="h-12 w-12 rounded mr-4">

                                    <span class="text-gray-800">{{ $item->product ? $item->product->product_name : 'Product not found' }}</span>
                                </td>
                                <td class="py-4 text-center">
                                    <div class="flex items-center justify-center">
                                        <button type="button" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300 decrement-btn" data-id="{{ $item->id }}">-</button>
                                        <input type="number" id="quantity-{{ $item->id }}" value="{{ $item->quantity }}" min="1" class="w-12 text-center border mx-2 rounded" readonly>
                                        <button type="button" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300 increment-btn" data-id="{{ $item->id }}">+</button>
                                    </div>
                                </td>
                                <td class="py-4 text-right text-gray-800">
                                    ₱<span id="total-{{ $item->id }}" class="item-total">{{ number_format($item->price * $item->quantity, 2) }}</span>
                                </td>
                                <td class="py-4 text-right">
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Subtotal and Total -->
                <div class="mt-6">
                    <div class="flex justify-between text-gray-800">
                        <span>Subtotal</span>
                        <span>₱<span id="cart-total">{{ number_format($cartItems->sum(fn($item) => $item->price * $item->quantity), 2) }}</span></span>
                    </div>
                    <div class="flex justify-between text-gray-800 mt-2">
                        <span>Shipping</span>
                        <span>₱5.99</span>
                    </div>
                    <br>
                    <hr>
                    <div class="flex justify-between font-bold text-gray-800 mt-4">
                        <span>Total</span>
                        <span>₱{{ number_format($cartItems->sum(fn($item) => $item->price * $item->quantity) + 5.99, 2) }}</span>
                    </div>
                </div>

                <!-- Checkout and Clear Cart Buttons -->
                <div class="mt-6 flex justify-between">
                    <button class="bg-[#F566BC] text-white px-6 py-2 rounded-full hover:bg-[#EC59A0]">
                        Checkout
                    </button>
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-gray-700">Clear Cart</button>
                    </form>
                </div>
            </div>
        @endif
    </div>

    @section('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Increment Quantity
        document.querySelectorAll('.increment-btn').forEach(button => {
            button.addEventListener('click', function () {
                const itemId = this.dataset.id;
                const quantityInput = document.getElementById(`quantity-${itemId}`);
                let quantity = parseInt(quantityInput.value) || 0;

                quantity += 1;
                quantityInput.value = quantity;

                updateCartTotal(itemId, quantity);
            });
        });

        // Decrement Quantity
        document.querySelectorAll('.decrement-btn').forEach(button => {
            button.addEventListener('click', function () {
                const itemId = this.dataset.id;
                const quantityInput = document.getElementById(`quantity-${itemId}`);
                let quantity = parseInt(quantityInput.value) || 0;

                if (quantity > 1) {
                    quantity -= 1;
                    quantityInput.value = quantity;

                    updateCartTotal(itemId, quantity);
                }
            });
        });

        // Update Cart Total
        function updateCartTotal(itemId, quantity) {
            const priceElement = document.getElementById(`price-${itemId}`);
            const itemPrice = parseFloat(priceElement?.dataset.price || 0);

            const totalElement = document.getElementById(`total-${itemId}`);
            const itemTotal = itemPrice * quantity;
            totalElement.textContent = itemTotal.toFixed(2);
            totalElement.classList.add('item-total'); // Ensure class exists

            // Recalculate overall cart total
            let cartTotal = 0;
            document.querySelectorAll('.item-total').forEach(item => {
                const val = parseFloat(item.textContent);
                if (!isNaN(val)) {
                    cartTotal += val;
                }
            });

            document.getElementById('cart-total').textContent = cartTotal.toFixed(2);
        }
    });
</script>

    @endsection
@endsection