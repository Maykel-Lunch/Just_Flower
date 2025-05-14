@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">My Orders</h1>
    
    <div class="max-w-3xl mx-auto">
        @forelse($orders as $order)
            <div class="flex mb-8">
                <div class="flex flex-col items-center mr-6">
                    <div class="w-12 h-12 rounded-full {{ $order->delivery_status === 'order received' ? 'bg-green-100' : ($order->delivery_status === 'processing' ? 'bg-yellow-100' : 'bg-blue-100') }} flex items-center justify-center">
                        @if($order->delivery_status === 'order received')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        @elseif($order->delivery_status === 'processing')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @endif
                    </div>
                    @if(!$loop->last)
                        <div class="w-px h-full bg-gray-300"></div>
                    @endif
                </div>
                <div class="flex-1 pb-8">
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Order #ORD-{{ str_pad($order->order_id, 3, '0', STR_PAD_LEFT) }}</h3>
                            <span class="text-sm font-medium {{ $order->delivery_status === 'order received' ? 'text-green-600 bg-green-50' : ($order->delivery_status === 'processing' ? 'text-yellow-600 bg-yellow-50' : 'text-blue-600 bg-blue-50') }} px-3 py-1 rounded-full">
                                {{ ucfirst($order->delivery_status) }}
                            </span>
                        </div>
                        <p class="text-gray-600 mb-4">
                            {{ $order->created_at->format('M d, Y') }} • 
                            {{ $order->orderItems->count() }} {{ Str::plural('item', $order->orderItems->count()) }} • 
                            ₱{{ number_format($order->final_amount, 2) }}
                        </p>
                        
                        <div class="flex space-x-4 mb-4">
                            @foreach($order->orderItems as $item)
                                <img class="w-16 h-16 object-cover rounded-md" 
                                     src="{{ $item->product->primaryImage ? asset($item->product->primaryImage->image_url) : 'https://via.placeholder.com/100' }}" 
                                     alt="{{ $item->product->product_name }}">
                            @endforeach
                        </div>
                        
                        <div class="flex justify-between items-center">
                            @if($order->delivery_status === 'order received')
                                <button class="text-blue-600 hover:text-blue-800 font-medium">View Details</button>
                                <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 text-sm">Reorder</button>
                            @elseif($order->delivery_status === 'processing')
                                <button class="text-blue-600 hover:text-blue-800 font-medium">View Details</button>
                                <button class="px-4 py-2 bg-red-100 text-red-700 rounded-md hover:bg-red-200 text-sm">Cancel Order</button>
                            @else
                                <button class="text-blue-600 hover:text-blue-800 font-medium">Track Order</button>
                                <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 text-sm">Reorder</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-8">
                <p class="text-gray-600">You haven't placed any orders yet.</p>
            </div>
        @endforelse
        
        @if($orders->hasPages())
            <nav class="flex justify-center mt-6">
                <ul class="inline-flex items-center -space-x-px">
                    <li>
                        <a href="{{ $orders->previousPageUrl() }}" class="px-3 py-2 ml-0 leading-tight text-[#F566BC] bg-white border border-[#F566BC] rounded-l-lg hover:bg-[#F566BC] hover:text-white">
                            Prev
                        </a>
                    </li>
                    @foreach ($orders->links()->elements as $element)
                        @foreach ($element as $page => $url)
                            <li>
                                <a href="{{ $url }}" class="px-3 py-2 leading-tight text-black border border-[#F566BC] hover:bg-[#F566BC] hover:text-white {{ $page == $orders->currentPage() ? 'bg-[#F566BC] text-white' : 'bg-white' }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @endforeach
                    @endforeach
                    <li>
                        <a href="{{ $orders->nextPageUrl() }}" class="px-3 py-2 leading-tight text-[#F566BC] bg-white border border-[#F566BC] rounded-r-lg hover:bg-[#F566BC] hover:text-white">
                            Next
                        </a>
                    </li>
                </ul>
            </nav>
        @endif
    </div>
</div>
@endsection