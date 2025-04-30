@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 flex space-x-4">
    <!-- Sidebar: List of Users -->
    <div class="w-1/4 bg-white shadow-md rounded-lg p-4">
        <h2 class="text-lg font-bold mb-4">Chats</h2>
        <ul class="space-y-4">
            @foreach ($users as $user)
                <li>
                    <a href="{{ route('messages.index', ['user_id' => $user->id]) }}"
                       class="flex items-center space-x-4 p-2 rounded-lg hover:bg-gray-100 {{ $selectedUserId == $user->id ? 'bg-gray-200' : '' }}">
                        <div class="flex-shrink-0">
                            <img src="{{ $user->profile_picture ?? asset('default-avatar.png') }}" alt="Avatar" class="h-10 w-10 rounded-full">
                        </div>
                        <div>
                            <p class="font-bold text-gray-800">{{ $user->name }}</p>
                            <p class="text-sm text-gray-500">Last message...</p>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Chat Area -->
    <div class="w-3/4 bg-white shadow-md rounded-lg p-6">
        @if ($selectedUserId)
            <div class="h-96 overflow-y-auto border-b pb-4 mb-4">
                @foreach ($messages as $message)
                    <div class="mb-4">
                        @if ($message->sender_id === Auth::id())
                            <!-- Admin's Message -->
                            <div class="text-right">
                                <p class="inline-block bg-[#F566BC] text-white px-4 py-2 rounded-lg">
                                    {{ $message->message_content }}
                                </p>
                                <p class="text-sm text-gray-500 mt-1">{{ \Carbon\Carbon::parse($message->sent_at)->format('F j, Y, g:i a') }}</p>
                            </div>
                        @else
                            <!-- User's Message -->
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
                <input type="hidden" name="receiver_id" value="{{ $selectedUserId }}">
                <button type="submit" class="bg-[#F566BC] text-white px-6 py-2 rounded-full hover:bg-[#EC59A0]">
                    Send
                </button>
            </form>
        @else
            <p class="text-gray-600">Select a user to view the conversation.</p>
        @endif
    </div>
</div>
@endsection