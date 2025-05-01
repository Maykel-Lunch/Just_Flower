<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Navigation Bar -->
    <nav class="bg-gradient-to-r from-[#EBC980] to-[#EC59A0] shadow-md w-full font-poppins">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <img src="{{ asset('flowershop_db/store_logo/Logo2.png') }}" alt="Logo" class="h-10 w-10 mr-2">
                    <a href="/" class="flex-shrink-0 flex items-center text-white font-bold text-xl">
                        just_flowers
                    </a>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:items-center space-x-4">
                    <a href="{{ route('products.index') }}" class="text-white hover:text-gray-300 text-sm font-medium">Manage Products</a>
                    <a href="/logout" class="text-white hover:text-gray-300 text-sm font-medium">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Admin Dashboard</h1>

        <!-- Dashboard Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <a href="{{ route('messages.index') }}" class="text-2xl font-bold text-[#F566BC] mt-2">Messaging System</a>
            </div>
            <div class="bg-white shadow-md rounded-lg p-6 cursor-pointer" onclick="showProducts()">
                <a class="text-2xl font-bold text-[#F566BC] mt-2">Products</a>
            </div>
        </div>

        <!-- Product Management Table -->
        <div id="product-management" class="bg-white shadow-md rounded-lg p-6 hidden">
            <h2 class="text-lg font-bold text-gray-700 mb-4">Manage Products</h2>
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">Product Name</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">Price</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">Stock</th>
                        <th class="px-4 py-2 border-b text-left text-sm font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $product->product_name }}</td>
                            <td class="px-4 py-2 border-b text-sm text-gray-700">₱{{ number_format($product->price, 2) }}</td>
                            <td class="px-4 py-2 border-b text-sm text-gray-700">{{ $product->stock_quantity }}</td>
                            <td class="px-4 py-2 border-b text-sm text-gray-700">
                                <a href="/admin/products/{{ $product->id }}/edit" class="text-blue-500 hover:underline">Edit</a>
                                <form action="/admin/products/{{ $product->id }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function showProducts() {
            const productManagement = document.getElementById('product-management');
            productManagement.classList.toggle('hidden');
        }
    </script>
</body>
</html>