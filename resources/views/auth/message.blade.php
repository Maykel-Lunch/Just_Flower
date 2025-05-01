@extends('layouts.app')

@section('content')
<div class="flex min-h-screen">
    @if (isset($users)) <!-- Admin View -->
        <!-- User List -->
        <aside class="w-1/4 bg-white border-r p-4 overflow-y-auto rounded-lg m-4">
            <h2 class="text-lg font-semibold mb-4">Users</h2>
            <ul class="space-y-2">
                @foreach ($users as $user)
                    <li>
                        <a href="{{ route('messages.index', ['user_id' => $user->id]) }}"
                           class="block p-2 rounded-lg {{ isset($selectedUserId) && $selectedUserId == $user->id ? 'bg-gray-200' : '' }}">
                            <div class="flex items-center space-x-3">
                                @if ($user->profile)
                                    <img src="{{ $user->profile }}" class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-pink-400 flex items-center justify-center text-white font-semibold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $user->recent_message ?? 'No messages yet'}}</p>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </aside>
    @endif

    <!-- Chat Area -->
    <main class="flex-1 flex flex-col rounded-lg border border-gray-300 shadow-lg">
        <header class="bg-white border-b p-4">
            <span class="text-lg font-semibold">
                {{ isset($users) ? 'Conversation' : 'Customer Support' }}
            </span>
        </header>

        <div class="flex-1 overflow-y-auto p-6 space-y-6">
            @forelse ($messages as $message)
                <div class="space-y-1 {{ $message->sender_id === Auth::id() ? 'text-right ml-auto' : 'text-left mr-auto' }} max-w-[70%]">
                    <p class="text-sm font-semibold">{{ $message->sender_id === Auth::id() ? 'You' : ($message->sender->name ?? 'Admin') }}</p>
                    <div class="{{ $message->sender_id === Auth::id() ? 'bg-blue-100' : 'bg-gray-200' }} p-3 rounded-lg inline-block">
                        {{ $message->message_content }}
                    </div>
                </div>
            @empty
                <p class="text-gray-500">No messages yet. {{ isset($users) ? 'Select a user to view the conversation.' : 'Start the conversation!' }}</p>
            @endforelse
        </div>

        @if (isset($selectedUserId) || !isset($users)) <!-- Show form if chatting with someone -->
            <form action="{{ route('messages.store') }}" method="POST" class="border-t bg-white p-4 flex items-center space-x-3">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $selectedUserId ?? 1 }}"> <!-- Admin ID fallback -->
                <input type="text" name="message_content" placeholder="Type a message..." class="flex-1 border rounded-full px-4 py-2 focus:outline-none" required />
                <button type="submit" class="text-blue-500 text-xl"><i class="fas fa-paper-plane"></i></button>
            </form>
        @endif
    </main>

    @include('partials.right-sidebar')
</div>
@endsection
