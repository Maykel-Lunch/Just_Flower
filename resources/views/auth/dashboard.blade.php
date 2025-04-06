@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="flex flex-col items-center min-h-screen space-y-8">
            <div class="flex justify-between items-center mb-4 w-full">
                <h2 class="text-2xl font-bold">All Products</h2>
                <button id="filterBtn" class="bg-white-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-full flex items-center space-x-2 border border-[#F566BC]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="#F566BC">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707v4.586a1 1 0 01-.293.707l-2 2A1 1 0 0110 20v-6.586a1 1 0 00-.293-.707L3.293 6.707A1 1 0 013 6V4z" />
                    </svg>
                    <span class="text-[#F566BC]"><strong>Filter</strong></span>
                </button>
            </div>

            @include('partials.filter') <!-- Include the filter partial here -->

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($products as $product)
                    <div class="bg-white shadow-lg p-5 rounded-lg hover:shadow-xl transition-shadow duration-300 border border-[#F566BC] relative transform hover:scale-105 min-h-[350px] flex flex-col">
                        <a href="{{ route('product.details', $product->product_id) }}" class="flex flex-col flex-grow">
                            <img src="{{ $product->primaryImage ? asset($product->primaryImage->image_url) : 'https://via.placeholder.com/150' }}" 
                            alt="{{ $product->product_name }}" 
                            class="w-full h-full object-cover">
                            <h3 class="text-sm font-medium text-gray-800">{{ $product->product_name }}</h3>
                            <p class="text-gray-600 text-xs truncate">{{ Str::limit($product->description, 50, '...') }}</p>
                        </a>

                        <div class="mt-auto">
                            <div class="flex justify-between items-center mt-3">
                                <span class="text-black font-bold text-sm">₱{{ number_format($product->price, 2) }}</span>
                                <button class="bg-orange-400 hover:bg-orange-500 text-white px-3 py-1 rounded-full flex items-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.4 5.6a1 1 0 001 1.4h12a1 1 0 001-1.4L17 13M7 13H5.4M5.4 5L7 13m0 0h10m-6 8a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                    <span class="text-xs">Add to Cart</span>
                                </button>
                            </div>

                            <div class="mt-2 text-gray-500 text-xs">Stock: {{ $product->stock_quantity }}</div>
                        </div>

                        <button 
                            class="absolute top-2 right-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs px-2 py-1 rounded-full flex items-center justify-center" 
                            onclick="toggleFavorite(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="heart-icon">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                            </svg>
                        </button>
                    </div>

                @endforeach
            </div>
        </div>
    </div>

    <!-- Move this script to resources/js and include it properly -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[onclick="toggleFavorite(this)"]').forEach(button => {
                button.addEventListener('click', () => {
                    const icon = button.querySelector('#heart-icon');
                    if (icon.getAttribute('fill') === 'none') {
                        icon.setAttribute('fill', 'red');
                    } else {
                        icon.setAttribute('fill', 'none');
                    }
                });
            });
        });
    </script>
@endsection
