<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Just Flowers</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <nav class="bg-gradient-to-r from-[#EBC980] to-[#EC59A0] shadow-md w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <img src="{{ asset('flowershop_db/store_logo/Logo2.png') }}" alt="Logo" class="h-10 w-10 mr-2">
                    <a href="/" class="text-white font-bold text-xl">just_flowers</a>
                </div>
            </div>
        </div>
    </nav>
    
    <div class="flex items-center justify-center flex-grow">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h1 class="text-2xl font-bold mb-6 text-center text-gray-700">Login to Your Account</h1>
            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                    <input type="email" name="email" id="email" required 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#F566BC] focus:border-[#F566BC]">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
                    <input type="password" name="password" id="password" required 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#F566BC] focus:border-[#F566BC]">
                </div>
                <button type="submit" 
                    class="w-full bg-[#EC59A0] text-white py-2 px-4 rounded-md hover:bg-[#EBC980] focus:outline-none focus:ring-2 focus:ring-[#F566BC] focus:ring-offset-2">
                    Login
                </button>
            </form>
            <p class="mt-4 text-center text-sm text-gray-600">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-[#F566BC] hover:underline">Register here</a>.
            </p>
        </div>
    </div>
</body>
</html>
