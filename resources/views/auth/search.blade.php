@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<!-- Search Results Container -->
<div class="max-w-7xl mx-auto px-6 py-8">
        <h1 class="text-2xl font-bold text-gray-800">Results for "{{ $query }}"</h1>
        
        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-6">
                @foreach($products as $product)
                    <div class="bg-white shadow-lg p-5 rounded-lg hover:shadow-xl transition-shadow duration-300">
                        <img src="{{ asset($product->primaryImage->image_url ?? 'placeholder.jpg') }}" class="w-full h-48 object-cover rounded-md">
                        <h2 class="text-lg font-semibold mt-3 text-gray-900">{{ $product->product_name }}</h2>
                        <p class="text-gray-600 text-sm">₱{{ number_format($product->price, 2) }}</p>
                        <a href="{{ route('product.details', ['product_id' => $product->product_id]) }}" class="text-[#EC59A0] hover:underline block mt-3">View Product</a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600 mt-6">No results found.</p>
        @endif
</div>

@endsection
