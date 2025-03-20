<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-white shadow-md w-full p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Dashboard</h1>
            <div class="flex items-center space-x-4">
                @if(auth()->check() && auth()->user()->profile_picture)
                    <img src="{{ auth()->user()->profile_picture }}" alt="Profile Picture" class="w-10 h-10 rounded-full">
                @elseif(auth()->check())
                    <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center">
                        <span class="text-gray-600 text-sm font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                    </div>
                @endif
                @if(auth()->check())
                    <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                @endif
                <a href="{{ route('logout') }}" class="text-white bg-red-500 hover:bg-red-600 px-3 py-1 rounded-lg">
                    Logout
                </a>
            </div>
        </div>
    </nav>
    <div class="flex items-center justify-center min-h-screen">
        
    </div>
</body>
</html>