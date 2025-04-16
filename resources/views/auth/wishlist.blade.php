{{-- resources/views/auth/wishlist.blade.php --}}
@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">My Wishlist</h2>

    @if($wishlist->isEmpty())
        <p class="text-gray-600">Your wishlist is empty.</p>
    @else
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-blue-100 text-gray-700 uppercase font-medium">
                    <tr>
                        <th class="px-6 py-4">Product</th>
                        <th class="px-6 py-4">Price</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($wishlist as $item)
                        @if($item->product)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 flex items-center space-x-4">
                                    <img 
                                        src="{{ $item->product && $item->product->primaryImage ? asset($item->product->primaryImage->image_url) : 'https://via.placeholder.com/150' }}" 
                                        alt="{{ $item->product->product_name ?? 'Product Image' }}"
                                        class="w-14 h-14 rounded object-cover border">

                                    <span class="text-gray-800 font-medium">
                                        {{ $item->product->product_name ?? 'Product not found' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-700 font-semibold">
                                    ₱{{ number_format($item->product->price, 2) }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('wishlist.remove', $item->product_id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-xl transition" title="Remove">
                                            &times;
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <form action="{{ route('wishlist.clear') }}" method="POST" class="mt-6 text-right">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-2 px-5 rounded-md transition">
                Clear Wishlist
            </button>
        </form>
    @endif
</div>


@endsection
