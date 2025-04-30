@extends('layouts.app')

@section('content')

<div class="flex min-h-screen">
    @if (isset($users)) <!-- Admin View -->
        <!-- Sidebar for Admin: List of Users -->
        <aside class="w-1/4 bg-white border-r flex flex-col overflow-y-auto p-4">
            <h2 class="text-lg font-semibold mb-4">Users</h2>
            <ul class="space-y-2">
                @foreach ($users as $user)
                    <li>
                        <a href="{{ route('messages.index', ['user_id' => $user->id]) }}"
                           class="block p-2 rounded-lg {{ isset($selectedUserId) && $selectedUserId == $user->id ? 'bg-gray-200' : '' }}">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $user->profile_picture ?? 'https://via.placeholder.com/40' }}" 
                                     alt="User Profile" 
                                     class="w-10 h-10 rounded-full object-cover">
                                <div>
                                    <p class="font-semibold">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $user->recent_message }}</p>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </aside>

        <!-- Chat Area -->
        <main class="flex flex-col flex-1 pb-6 rounded-lg">
            <!-- Chat Header -->
            <header class="bg-white border-b p-4 flex items-center justify-between">
                <span class="text-lg font-semibold">Conversation</span>
            </header>

            <!-- Messages -->
            <div class="flex-1 overflow-y-auto p-6 space-y-6">
                @if (!empty($messages))
                    @foreach ($messages as $message)
                        <div class="space-y-1 {{ $message->sender_id === Auth::id() ? 'text-right ml-auto' : 'text-left mr-auto' }} max-w-[70%]">
                            <p class="text-sm font-semibold">
                                {{ $message->sender_id === Auth::id() ? 'You' : ($message->sender->name ?? 'Admin') }}
                            </p>
                            <div class="{{ $message->sender_id === Auth::id() ? 'bg-blue-100' : 'bg-gray-200' }} p-3 rounded-lg inline-block">
                                {{ $message->message_content }}
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500">No messages yet. Select a user to view the conversation.</p>
                @endif
            </div>

            <!-- Input Box -->
            @if (isset($selectedUserId))
                <form action="{{ route('messages.store') }}" method="POST" class="border-t bg-white p-4 flex items-center space-x-3">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $selectedUserId }}">
                    <input type="text" name="message_content" placeholder="Type a message..." 
                           class="flex-1 border rounded-full px-4 py-2 focus:outline-none" required />
                    <button type="submit" class="text-blue-500 text-xl"><i class="fas fa-paper-plane"></i></button>
                </form>
            @endif
        </main>

        @include('partials.right-sidebar')
    @else <!-- Regular User View -->
        <!-- Chat Area -->
        <main class="flex flex-col flex-1 pb-6 rounded-lg">
            <!-- Chat Header -->
            <header class="bg-white border-b p-4 flex items-center justify-between">
                <span class="text-lg font-semibold">Chat with Admin</span>
            </header>

            <!-- Messages -->
            <div class="flex-1 overflow-y-auto p-6 space-y-6">
                @forelse ($messages as $message)
                    <div class="space-y-1 {{ $message->sender_id === Auth::id() ? 'text-right ml-auto' : 'text-left mr-auto' }} max-w-[70%]">
                        <p class="text-sm font-semibold">
                            {{ $message->sender_id === Auth::id() ? 'You' : ($message->sender->name ?? 'Admin') }}
                        </p>
                        <div class="{{ $message->sender_id === Auth::id() ? 'bg-blue-100' : 'bg-gray-200' }} p-3 rounded-lg inline-block">
                            {{ $message->message_content }}
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">No messages yet. Start the conversation!</p>
                @endforelse
            </div>

            <!-- Input Box -->
            <form action="{{ route('messages.store') }}" method="POST" class="border-t bg-white p-4 flex items-center space-x-3">
                @csrf
                <input type="text" name="message_content" placeholder="Type a message..." 
                       class="flex-1 border rounded-full px-4 py-2 focus:outline-none" required />
                <button type="submit" class="text-blue-500 text-xl"><i class="fas fa-paper-plane"></i></button>
            </form>
        </main>

        @include('partials.right-sidebar')
    @endif
</div>

@endsection
