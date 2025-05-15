@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row min-h-screen bg-gray-50">
    @if (isset($users)) <!-- Admin View -->
        <!-- User List -->
        <aside class="w-full md:w-1/4 bg-white border-r p-6 overflow-y-auto rounded-lg m-4 h-[calc(100vh-2rem)] shadow-sm">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Users</h2>
            <ul class="space-y-3" id="userList">
                @foreach ($users as $user)
                    <li>
                        <a href="#" data-user-id="{{ $user->id }}"
                           class="user-link flex items-center space-x-4 p-4 rounded-xl transition hover:bg-gray-50 {{ isset($selectedUserId) && $selectedUserId == $user->id ? 'bg-pink-50 border border-pink-100' : '' }}">
                            @if ($user->profile)
                                <img src="{{ $user->profile }}" class="w-12 h-12 rounded-full object-cover ring-2 ring-pink-100">
                            @else
                                <div class="w-12 h-12 rounded-full bg-pink-500 flex items-center justify-center text-white font-semibold text-lg">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <p class="font-semibold text-gray-900 truncate">{{ $user->name }}</p>
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
        <header class="bg-white border-b p-6">
            <h1 class="text-2xl font-semibold text-gray-800">
                {{ isset($users) ? 'Conversation' : 'Customer Support' }}
            </h1>
        </header>

        <!-- Scrollable message area -->
        <div class="flex-1 overflow-y-auto p-8 space-y-6" id="messageArea">
            @forelse ($messages as $message)
                <div class="flex flex-col max-w-[75%] {{ $message->sender_id === Auth::id() ? 'ml-auto text-right' : 'mr-auto text-left' }}">
                    <p class="text-sm font-semibold mb-1 text-gray-700">
                        {{ $message->sender_id === Auth::id() ? 'You' : ($message->sender->name ?? 'Admin') }}
                    </p>
                    <div class="{{ $message->sender_id === Auth::id() ? 'bg-pink-100 text-pink-900' : 'bg-gray-100 text-gray-900' }} p-4 rounded-2xl shadow-sm">
                        {!! nl2br(e(str_replace('\n', "\n", $message->message_content))) !!}
                    </div>
                    <p class="text-xs text-gray-500 mt-2">
                        {{ $message->sent_at->format('F j, Y g:i A') }}
                    </p>
                </div>
            @empty
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg">
                    No messages yet. {{ isset($users) ? 'Select a user to view the conversation.' : 'Start the conversation!' }}
                </p>
                </div>
            @endforelse
        </div>

        <!-- Message Form - Fixed at bottom -->
        <div class="border-t bg-white p-6 sticky bottom-0">
            <form id="messageForm" class="flex items-center gap-4 relative">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $selectedUserId ?? 1 }}" id="receiverId">
                
                <!-- Message Input Box -->
                <div class="flex-1 relative">
                    <textarea 
                        name="message_content"
                        rows="1"
                        placeholder="Type a message..."
                        class="w-full border border-gray-200 rounded-2xl px-6 py-4 focus:outline-none focus:ring-2 focus:ring-pink-200 focus:border-pink-200 overflow-hidden resize-none bg-gray-50"
                        style="min-height: 48px; max-height: 120px;"
                        required
                        id="messageInput"
                    ></textarea>
                </div>
                
                <!-- Send Button -->
                <button type="submit" class="bg-pink-500 text-white p-4 rounded-full hover:bg-pink-600 transition-colors duration-200" id="sendButton">
                    <i class="fas fa-paper-plane"></i>
                </button>
                
                <!-- Loading Indicator -->
                <div id="loadingIndicator" class="absolute bottom-20 left-1/2 transform -translate-x-1/2 hidden">
                    <div class="flex space-x-2">
                        <div class="w-3 h-3 bg-pink-500 rounded-full animate-bounce"></div>
                        <div class="w-3 h-3 bg-pink-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                        <div class="w-3 h-3 bg-pink-500 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
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
                                <div class="${isCurrentUser ? 'bg-pink-100 text-pink-900' : 'bg-gray-100 text-gray-900'} p-4 rounded-2xl shadow-sm">
                                    ${message.message_content.replace(/\n/g, '<br>')}
                                </div>
                                <p class="text-xs text-gray-500 mt-2">
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