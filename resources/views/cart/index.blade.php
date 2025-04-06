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
                                        <button type="button" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300" onclick="decrementQuantity({{ $item->id }})">-</button>
                                        <input type="number" value="{{ $item->quantity }}" min="1" class="w-12 text-center border mx-2 rounded" readonly>
                                        <button type="button" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300" onclick="incrementQuantity({{ $item->id }})">+</button>
                                    </div>
                                </td>
                                <td class="py-4 text-right text-gray-800">
                                    ₱{{ number_format($item->price * $item->quantity, 2) }}
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
                        <span>₱{{ number_format($cartItems->sum(fn($item) => $item->price * $item->quantity), 2) }}</span>
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

    <script>
        function decrementQuantity(cartItemId) {
            // Implement decrement functionality (e.g., send an AJAX request to update the quantity)
        }

        function incrementQuantity(cartItemId) {
            // Implement increment functionality (e.g., send an AJAX request to update the quantity)
        }
    </script>

@endsection