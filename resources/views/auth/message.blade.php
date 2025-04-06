@extends('layouts.app')

@section('title', 'Messages')

@section('content')
<div class="w-full max-w-md bg-white shadow-lg rounded-lg overflow-hidden">
    <!-- Header -->
     <!-- Fix this store -->
    <div class="bg-[#F566BC] text-white p-4 flex items-center">
        @if($messages->isNotEmpty() && $messages->first()->store)
            <img src="{{ $messages->first()->store->store_logo }}" class="w-10 h-10 rounded-full mr-3" alt="Store Logo">
            <h2 class="text-lg font-semibold">{{ $messages->first()->store->store_name }}</h2>
        @endif
    </div>

    
    <!-- Chat Messages -->
    <div class="p-4 h-96 overflow-y-auto space-y-4 flex flex-col">
        @forelse($messages->sortBy('sent_at') as $message)
            @if($message->sender_id == auth()->id())
                <!-- Current User's Sent Message -->
                <div class="flex justify-end">
                    <div class="bg-[#F566BC] text-white p-3 rounded-lg max-w-xs">
                        <p class="text-sm">{{ $message->message_content ?? 'No message content' }}</p>
                        <span class="text-xs text-white block mt-1">
                            @php
                                $now = \Carbon\Carbon::now();
                                $sentAt = \Carbon\Carbon::parse($message->sent_at);
                                
                                if ($sentAt->diffInDays($now) < 1) {
                                    // Today - show time only
                                    echo $sentAt->format('h:i A');
                                } elseif ($sentAt->diffInDays($now) < 7) {
                                    // Within a week - show day and time
                                    echo $sentAt->format('D h:i A');
                                } elseif ($sentAt->diffInMonths($now) < 1) {
                                    // Within a month - show as weeks ago
                                    echo $sentAt->diffInWeeks($now) . ' week' . ($sentAt->diffInWeeks($now) > 1 ? 's' : '') . ' ago';
                                } elseif ($sentAt->diffInYears($now) < 1) {
                                    // Within a year - show as months ago
                                    echo $sentAt->diffInMonths($now) . ' month' . ($sentAt->diffInMonths($now) > 1 ? 's' : '') . ' ago';
                                } else {
                                    // More than a year - show full date
                                    echo $sentAt->format('M j, Y');
                                }
                            @endphp
                        </span>
                    </div>
                </div>
            @else
                <!-- Received Message -->
                <div class="flex items-start">
                    @if($message->sender->profile_image)
                        <img src="{{ $message->sender->profile_image }}" class="w-8 h-8 rounded-full mr-2">
                    @else
                        <div class="w-8 h-8 flex items-center justify-center bg-gray-400 text-white text-sm font-semibold rounded-full mr-2">
                            {{ strtoupper(substr($message->sender->name ?? 'U', 0, 1)) }}
                        </div>
                    @endif
                    <div class="bg-gray-200 p-3 rounded-lg max-w-xs">
                        <p class="text-sm font-semibold">{{ $message->sender->name ?? 'Unknown' }}</p>
                        <p class="text-sm">{{ $message->message_content ?? 'No message content' }}</p>
                        <span class="text-xs text-gray-500 block mt-1">
                        @php
                            $now = \Carbon\Carbon::now();
                            $sentAt = \Carbon\Carbon::parse($message->sent_at);
                            
                            if ($sentAt->diffInMinutes($now) < 60) {
                                // Less than 1 hour - show minutes
                                echo $sentAt->diffInMinutes($now) . ' min' . ($sentAt->diffInMinutes($now) != 1 ? 's' : '') . ' ago';
                            } elseif ($sentAt->diffInHours($now) < 24) {
                                // Less than 24 hours - show hours
                                echo $sentAt->diffInHours($now) . ' hour' . ($sentAt->diffInHours($now) != 1 ? 's' : '') . ' ago';
                            } elseif ($sentAt->diffInDays($now) < 7) {
                                // Less than 1 week - show days and time
                                echo $sentAt->diffInDays($now) . ' day' . ($sentAt->diffInDays($now) != 1 ? 's' : '') . ' ago, ' . $sentAt->format('h:i A');
                            } elseif ($sentAt->diffInWeeks($now) < 4) {
                                // Less than 1 month - show weeks and time
                                echo floor($sentAt->diffInDays($now)/7) . ' week' . (floor($sentAt->diffInDays($now)/7) != 1 ? 's' : '') . ' ago, ' . $sentAt->format('h:i A');
                            } elseif ($sentAt->diffInMonths($now) < 12) {
                                // Less than 1 year - show months
                                echo $sentAt->diffInMonths($now) . ' month' . ($sentAt->diffInMonths($now) != 1 ? 's' : '') . ' ago';
                            } else {
                                // More than 1 year - show full date
                                echo $sentAt->format('M j, Y');
                            }
                        @endphp
                    </span>
                    </div>
                </div>
            @endif
        @empty
            <p class="text-center text-gray-500">No messages yet. Start the conversation!</p>
        @endforelse
    </div>

    <!-- Input Box -->
    @if(Auth::check())
        <div class="border-t border-gray-200 p-3 flex items-center">
            <form action="{{ route('messages.store') }}" method="POST" class="flex w-full">
                @csrf
                <input type="text" name="content" class="flex-1 border rounded-full p-2 focus:outline-none focus:ring-2 focus:ring-[#F566BC]" placeholder="Type a message..." required>
                <button type="submit" class="ml-2 bg-[#F566BC] text-white px-4 py-2 rounded-full hover:bg-[#d34ba0]">Send</button>
            </form>
        </div>
    @else
        <p class="text-center text-gray-500 p-4">
            <a href="{{ route('login') }}" class="text-[#F566BC] font-semibold">Log in</a> to send messages.
        </p>
    @endif
</div>

@endsection