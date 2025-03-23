<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Chat UI</title>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">

    <div class="w-full max-w-md bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-[#F566BC] text-white p-4 flex items-center">
            <img src="{{ $store->store_logo }}" class="w-10 h-10 rounded-full mr-3" alt="Store Logo">
            <h2 class="text-lg font-semibold">{{ $store->store_name }}</h2>
        </div>

        

        <!-- Chat Messages -->
        <div class="p-4 h-96 overflow-y-auto space-y-4">
            @forelse($messages as $message)
                @if($message->sender_id == auth()->id())
                    <!-- Current User's Sent Message -->
                    <div class="flex justify-end">
                        <div class="bg-[#F566BC] text-white p-3 rounded-lg max-w-xs">
                            <p class="text-sm">{{ $message->message_content ?? 'No message content' }}</p>
                            <span class="text-xs text-white block mt-1">
                                {{ \Carbon\Carbon::parse($message->sent_at)->format('h:i A') ?? 'N/A' }}
                            </span>
                        </div>
                    </div>
                @else
                    <!-- Received Message -->
                    <div class="flex items-start">
                        @if($message->sender->profile_image)
                            <!-- If user has a profile image -->
                            <img src="{{ $message->sender->profile_image }}" class="w-8 h-8 rounded-full mr-2">
                        @else
                            <!-- If no profile image, show first letter -->
                            <div class="w-8 h-8 flex items-center justify-center bg-gray-400 text-white text-sm font-semibold rounded-full mr-2">
                                {{ strtoupper(substr($message->sender->name ?? 'U', 0, 1)) }}
                            </div>
                        @endif
                        <div class="bg-gray-200 p-3 rounded-lg max-w-xs">
                            <p class="text-sm font-semibold">{{ $message->sender->name ?? 'Unknown' }}</p>
                            <p class="text-sm">{{ $message->message_content ?? 'No message content' }}</p>
                            <span class="text-xs text-gray-500 block mt-1">
                                {{ \Carbon\Carbon::parse($message->sent_at)->format('h:i A') ?? 'N/A' }}
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

</body>
</html>
