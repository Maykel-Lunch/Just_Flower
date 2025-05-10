@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row min-h-screen">
    @if (isset($users)) <!-- Admin View -->
        <!-- User List -->
        <aside class="w-full md:w-1/4 bg-white border-r p-4 overflow-y-auto rounded-lg m-4 h-[calc(100vh-2rem)]">
            <h2 class="text-xl font-bold mb-4">Users</h2>
            <ul class="space-y-2" id="userList">
                @foreach ($users as $user)
                    <li>
                        <a href="#" data-user-id="{{ $user->id }}"
                           class="user-link flex items-center space-x-3 p-3 rounded-lg transition hover:bg-gray-100 {{ isset($selectedUserId) && $selectedUserId == $user->id ? 'bg-gray-200' : '' }}">
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
        <div class="flex-1 overflow-y-auto p-6 space-y-6" id="messageArea">
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
        <div class="border-t bg-white p-4">
            <form id="messageForm" class="flex items-center gap-3 relative">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $selectedUserId ?? 1 }}" id="receiverId">
                
                <!-- Message Input Box -->
                <div class="flex-1 relative">
                    <textarea 
                        name="message_content"
                        rows="1"
                        placeholder="Type a message..."
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 overflow-hidden resize-none"
                        style="min-height: 44px; max-height: 120px;"
                        required
                        id="messageInput"
                    ></textarea>
                </div>
                
                <!-- Send Button -->
                <button type="submit" class="text-blue-500 text-xl hover:text-blue-700 transition" id="sendButton">
                    <i class="fas fa-paper-plane"></i>
                </button>
                
                <!-- Loading Indicator -->
                <div id="loadingIndicator" class="absolute bottom-16 left-1/2 transform -translate-x-1/2 hidden">
                    <div class="flex space-x-2">
                        <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                        <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    @include('partials.right-sidebar')
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Auto-resize textarea functionality
    const textarea = document.getElementById('messageInput');
    const form = document.getElementById('messageForm');
    const sendButton = document.getElementById('sendButton');
    const loadingIndicator = document.getElementById('loadingIndicator');
    const minHeight = 44;
    const maxHeight = 120;

    // Message handling functionality
    const messageArea = document.getElementById('messageArea');
    const isAdminView = @json(isset($users));
    const currentUserId = {{ Auth::id() }};
    let selectedUserId = "{{ $selectedUserId ?? '' }}";
    let messagePolling = null; // Declare at higher scope

    function autoResize() {
        if (!textarea) return;
        
        // Reset height to get correct scrollHeight
        textarea.style.height = 'auto';
        
        // Calculate new height
        let newHeight = textarea.scrollHeight;
        newHeight = Math.max(minHeight, Math.min(newHeight, maxHeight));
        
        // Apply new height
        textarea.style.height = newHeight + 'px';
        textarea.style.overflowY = textarea.scrollHeight > maxHeight ? 'auto' : 'hidden';
    }

    if (textarea) {
        textarea.addEventListener('input', autoResize);

        textarea.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                if (e.shiftKey) return;
                e.preventDefault();
                if (form) form.dispatchEvent(new Event('submit'));
            }
        });

        // Initialize with proper height
        autoResize();
    }

    // Update the receiver ID when a user is selected (admin view)
    if (isAdminView) {
        document.querySelectorAll('.user-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const userId = this.getAttribute('data-user-id');
                
                // Don't do anything if clicking the same user
                if (selectedUserId === userId) return;
                
                // Update selected user UI
                document.querySelectorAll('.user-link').forEach(el => {
                    el.classList.remove('bg-gray-200');
                });
                this.classList.add('bg-gray-200');
                
                // Update receiver ID
                selectedUserId = userId;
                document.getElementById('receiverId').value = userId;
                
                // Clear existing polling
                if (messagePolling) {
                    clearInterval(messagePolling);
                    messagePolling = null;
                }
                
                // Fetch messages immediately and start new polling
                fetchMessages();
                messagePolling = setInterval(fetchMessages, 3000);
            });
        });
    }

    // Handle form submission via AJAX
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const messageContent = formData.get('message_content');
            
            if (!messageContent.trim()) return;
            
            // Disable send button and show loading
            sendButton.disabled = true;
            sendButton.classList.add('opacity-50');
            loadingIndicator.classList.remove('hidden');
            
            // Clear input immediately for better UX
            textarea.value = '';
            autoResize();
            
            $.ajax({
                url: "{{ route('messages.store') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Fetch updated messages
                    fetchMessages();
                },
                error: function(error) {
                    console.error('Error sending message:', error);
                },
                complete: function() {
                    // Re-enable send button and hide loading
                    sendButton.disabled = false;
                    sendButton.classList.remove('opacity-50');
                    loadingIndicator.classList.add('hidden');
                }
            });
        });
    }

    function fetchMessages() {
        if (!messageArea || !selectedUserId) return;

        // Store scroll position and height before fetching new messages
        const wasAtBottom = isScrolledToBottom(messageArea);
        const previousScrollHeight = messageArea.scrollHeight;
        const previousScrollTop = messageArea.scrollTop;

        const requestData = isAdminView ? { user_id: selectedUserId } : {};

        $.ajax({
            url: "{{ route('messages.fetch') }}",
            method: "GET",
            data: requestData,
            success: function (messages) {
                let html = '';
                if (messages.length === 0) {
                    html = `<p class="text-gray-500">No messages yet. ${isAdminView ? 'Select a user to view the conversation.' : 'Start the conversation!'}</p>`;
                } else {
                    messages.forEach(message => {
                        const isCurrentUser = message.sender_id === currentUserId;
                        const senderName = isCurrentUser ? 'You' : 
                                        (message.sender && message.sender.name ? message.sender.name : 'Admin');
                        
                        html += `
                            <div class="flex flex-col max-w-[75%] ${isCurrentUser ? 'ml-auto text-right' : 'mr-auto text-left'}">
                                <p class="text-sm font-semibold">${senderName}</p>
                                <div class="${isCurrentUser ? 'bg-blue-100' : 'bg-gray-200'} p-3 rounded-lg">
                                    ${message.message_content.replace(/\n/g, '<br>')}
                                </div>
                                <p class="text-xs text-gray-500 mt-1">
                                    ${new Date(message.sent_at).toLocaleString('en-US', {
                                        month: 'long', 
                                        day: 'numeric', 
                                        year: 'numeric',
                                        hour: '2-digit', 
                                        minute: '2-digit'
                                    })}
                                </p>
                            </div>
                        `;
                    });
                }
                
                // Only update if messages actually changed
                if (messageArea.innerHTML !== html) {
                    messageArea.innerHTML = html;
                    
                    // Calculate if new messages were added to the bottom
                    const newMessagesAtBottom = messageArea.scrollHeight > previousScrollHeight;
                    
                    // Maintain scroll position if user was looking at older messages
                    if (!wasAtBottom && newMessagesAtBottom) {
                        // User was not at bottom, maintain their scroll position relative to the old messages
                        messageArea.scrollTop = previousScrollTop + (messageArea.scrollHeight - previousScrollHeight);
                    } else if (wasAtBottom) {
                        // User was at bottom, scroll to new bottom
                        messageArea.scrollTop = messageArea.scrollHeight;
                    }
                }
            },
            error: function (error) {
                console.error('Error fetching messages:', error);
            }
        });
    }

    // Helper function to check if scroll is at bottom
    function isScrolledToBottom(element) {
        return element.scrollHeight - element.scrollTop - element.clientHeight < 50; // 50px threshold
    }

    // Start initial polling only if we have a selected user
    if (selectedUserId) {
        fetchMessages();
        messagePolling = setInterval(fetchMessages, 3000);
    }
    
    // Clean up interval when leaving page
    window.addEventListener('beforeunload', function() {
        if (messagePolling) {
            clearInterval(messagePolling);
        }
    });
});
</script>
@endpush

@stack('scripts')