@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Message the Admin</h1>

    <!-- Chat Box -->
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="h-96 overflow-y-auto border-b pb-4 mb-4">
            @foreach ($messages as $message)
                <div class="mb-4">
                    @if ($message->sender_id === Auth::id())
                        <!-- User's Message -->
                        <div class="text-right">
                            <p class="inline-block bg-[#F566BC] text-white px-4 py-2 rounded-lg">
                                {{ $message->message_content }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">{{ \Carbon\Carbon::parse($message->sent_at)->format('F j, Y, g:i a') }}</p>
                        </div>
                    @else
                        <!-- Admin's Message -->
                        <div class="text-left">
                            <p class="inline-block bg-gray-200 text-gray-800 px-4 py-2 rounded-lg">
                                {{ $message->message_content }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">{{ \Carbon\Carbon::parse($message->sent_at)->format('F j, Y, g:i a') }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Message Form -->
        <form action="{{ route('messages.store') }}" method="POST" class="flex items-center space-x-4">
            @csrf
            <input 
                type="text" 
                name="message_content" 
                id="message_content"
                placeholder="Type your message..." 
                class="flex-grow border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#F566BC]"
                required
            >
            <input type="hidden" name="receiver_id" value="{{ $adminId }}">
            <button type="submit" class="bg-[#F566BC] text-white px-6 py-2 rounded-full hover:bg-[#EC59A0]">
                Send
            </button>
        </form>
    </div>
</div>
@endsection