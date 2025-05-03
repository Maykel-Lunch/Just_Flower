@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row min-h-screen">
    @if (isset($users)) <!-- Admin View -->
        <!-- User List -->
        <aside class="w-full md:w-1/4 bg-white border-r p-4 overflow-y-auto rounded-lg m-4 h-[calc(100vh-2rem)]">
            <h2 class="text-xl font-bold mb-4">Users</h2>
            <ul class="space-y-2">
                @foreach ($users as $user)
                    <li>
                        <a href="{{ route('messages.index', ['user_id' => $user->id]) }}"
                           class="flex items-center space-x-3 p-3 rounded-lg transition hover:bg-gray-100 {{ isset($selectedUserId) && $selectedUserId == $user->id ? 'bg-gray-200' : '' }}">
                            @if ($user->profile)
                                <img src="{{ $user->profile }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 rounded-full bg-pink-500 flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="min-w-0">
                                <p class="font-semibold truncate">{{ $user->name }}</p>
                                <p class="text-sm text-gray-500 truncate">{{ $user->recent_message ?? 'No messages yet'}}</p>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </aside>
    @endif

    <!-- Chat Area -->
    <main class="flex-1 flex flex-col rounded-lg m-4 bg-white border shadow-lg max-h-[calc(100vh-2rem)]">
    <!-- Header -->
    <header class="bg-white border-b p-4">
        <h1 class="text-xl font-semibold">
            {{ isset($users) ? 'Conversation' : 'Customer Support' }}
        </h1>
    </header>

    <!-- Scrollable message area -->
    <div class="flex-1 overflow-y-auto p-6 space-y-6">
        @forelse ($messages as $message)
            <div class="flex flex-col max-w-[75%] {{ $message->sender_id === Auth::id() ? 'ml-auto text-right' : 'mr-auto text-left' }}">
                <p class="text-sm font-semibold">
                    {{ $message->sender_id === Auth::id() ? 'You' : ($message->sender->name ?? 'Admin') }}
                </p>
                <div class="{{ $message->sender_id === Auth::id() ? 'bg-blue-100' : 'bg-gray-200' }} p-3 rounded-lg">
                    {!! nl2br(e(str_replace('\n', "\n", $message->message_content))) !!}
                </div>
                <p class="text-xs text-gray-500 mt-1">
                    {{ $message->sent_at->format('F j, Y g:i A') }}
                </p>
            </div>
        @empty
            <p class="text-gray-500">
                No messages yet. {{ isset($users) ? 'Select a user to view the conversation.' : 'Start the conversation!' }}
            </p>
        @endforelse
    </div>

    <!-- Message Form -->
    @if (isset($selectedUserId) || !isset($users))
        <form action="{{ route('messages.store') }}" method="POST" class="border-t bg-white p-4 flex items-center gap-3">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $selectedUserId ?? 1 }}">
            <textarea 
                name="message_content"
                rows="1"
                placeholder="Type a message..."
                class="flex-1 border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 overflow-hidden resize-none"
                style="height: auto;" 
                required
            ></textarea>
            
            <button type="submit" class="text-blue-500 text-xl hover:text-blue-700 transition">
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    @endif
</main>

    @include('partials.right-sidebar')
</div>
@endsection


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const textarea = document.querySelector('textarea[name="message_content"]');
        const form = textarea.closest('form');
        const submitButton = form.querySelector('button[type="submit"]');
        const maxHeight = 160; // 10rem = max-h-40

        function autoResize() {
            textarea.style.height = 'auto';
            // Force reflow to apply height correctly
            textarea.offsetHeight; 
            const newHeight = Math.min(textarea.scrollHeight, maxHeight);
            textarea.style.height = newHeight + 'px';
            textarea.style.overflowY = textarea.scrollHeight > maxHeight ? 'auto' : 'hidden';
        }

        if (textarea) {
            textarea.addEventListener('input', autoResize);

            textarea.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    if (e.shiftKey) {
                        return; // newline
                    } else if (e.ctrlKey || e.metaKey) {
                        e.preventDefault();
                        submitButton.click();
                    } else {
                        e.preventDefault(); // block normal Enter
                    }
                }
            });

            autoResize(); // initial call
        }
    });
</script>
@endpush


@stack('scripts')




