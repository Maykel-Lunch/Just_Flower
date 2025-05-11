<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 w-64 bg-gradient-to-b from-purple-50 to-white text-gray-800 p-4 border-r border-gray-200">
            <h1 class="text-2xl font-bold mb-8 text-green-700">just_flowers</h1>
            <nav>
                <ul class="space-y-2">
                    <li>
                        <a href="#" class="flex items-center p-2 rounded hover:bg-green-50 bg-green-50 text-green-700 border-l-4 border-green-500">
                            <i class="fas fa-shopping-cart mr-3 text-green-600"></i>
                            Orders
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-2 rounded hover:bg-green-50 text-gray-700 hover:text-green-700">
                            <i class="fas fa-users mr-3 text-gray-500"></i>
                            Customers
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-2 rounded hover:bg-green-50 text-gray-700 hover:text-green-700">
                            <i class="fas fa-chart-bar mr-3 text-gray-500"></i>
                            Analytics
                        </a>
                    </li>
                    <li>
                        <a href="/admin/delivery" class="flex items-center p-2 rounded hover:bg-green-50 text-gray-700 hover:text-green-700">
                            <i class="fas fa-truck mr-3 text-gray-500"></i>
                            Delivery
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-2 rounded hover:bg-green-50 text-gray-700 hover:text-green-700">
                            <i class="fas fa-cog mr-3 text-gray-500"></i>
                            Settings
                        </a>
                    </li>
                </ul>
            </nav>
            
            <!-- Additional floral-themed elements -->
            <div class="mt-8 pt-4 border-t border-gray-100">
                <a href="/dashboard" class="flex items-center p-2 rounded hover:bg-green-50 text-gray-700 hover:text-green-700 cursor-pointer">
                    <i class="fas fa-store mr-3 text-gray-500"></i>
                    <span>Website</span>
                </a>

            </div>
        </div>
        <!-- Main Content -->
        <div class="ml-64 p-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Order Management</h2>
                <div class="flex space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Search orders..." class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Add Order
                    </button>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-lg shadow p-4 mb-6">
                <div class="flex items-center space-x-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select class="border border-gray-300 rounded-md px-3 py-2 w-48">
                            <option value="">All Statuses</option>
                            <option value="processing">Processing</option>
                            <option value="ordered pickup">Ordered Pickup</option>
                            <option value="in transit">In Transit</option>
                            <option value="out for delivery">Out for Delivery</option>
                            <option value="order received">Order Received</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                        <div class="flex space-x-2">
                            <input type="date" class="border border-gray-300 rounded-md px-3 py-2">
                            <span class="self-center">to</span>
                            <input type="date" class="border border-gray-300 rounded-md px-3 py-2">
                        </div>
                    </div>
                    <button class="self-end bg-gray-200 px-4 py-2 rounded-md hover:bg-gray-300">
                        <i class="fas fa-filter mr-2"></i>
                        Apply Filters
                    </button>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Order Number
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customer Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date Purchased
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date Received
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Photo Confirmation
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($orders as $order)
                                <tr class="hover:bg-gray-50" data-order-id="{{ $order->order_id }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $order->order_id }}
                                    </td>
                                    <td class="customer-name-cellpx-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $order->user->name }} <!-- Replace with customer name if available -->
                                    </td>
                                    <td class="status-cell px-6 py-4 whitespace-nowrap">
                                        <form method="POST" action="{{ route('admin.updateStatus', $order->order_id) }}">
                                            @csrf
                                            @method('PUT')
                                            <select name="delivery_status" onchange="this.form.submit()" class="border rounded-md px-2 py-1 text-xs font-medium
                                                {{ $order->delivery_status == 'processing' ? 'bg-yellow-100 text-yellow-800 border-yellow-200' : '' }}
                                                {{ $order->delivery_status == 'ordered pickup' ? 'bg-blue-100 text-blue-800 border-blue-200' : '' }}
                                                {{ $order->delivery_status == 'in transit' ? 'bg-purple-100 text-purple-800 border-purple-200' : '' }}
                                                {{ $order->delivery_status == 'out for delivery' ? 'bg-orange-100 text-orange-800 border-orange-200' : '' }}
                                                {{ $order->delivery_status == 'order received' ? 'bg-green-100 text-green-800 border-green-200' : '' }}"
                                                {{ $order->delivery_status == 'Out for Delivery' && !$order->confirmation_photo ? 'disabled' : '' }}>
                                                
                                                @php
                                                    $currentStatus = strtolower($order->delivery_status);
                                                    $statusOrder = [
                                                        'processing' => 1,
                                                        'ordered pickup' => 2,
                                                        'in transit' => 3,
                                                        'out for delivery' => 4,
                                                        'order received' => 5
                                                    ];
                                                    $currentLevel = $statusOrder[$currentStatus] ?? 0;
                                                @endphp
                                                
                                                <option value="processing" 
                                                    {{ $currentStatus == 'processing' ? 'selected' : '' }}
                                                    {{ $currentLevel > 1 ? 'disabled' : '' }}>
                                                    Processing
                                                </option>
                                                
                                                <option value="ordered pickup" 
                                                    {{ $currentStatus == 'ordered pickup' ? 'selected' : '' }}
                                                    {{ $currentLevel > 2 ? 'disabled' : '' }}>
                                                    Ordered Pickup
                                                </option>
                                                
                                                <option value="in transit" 
                                                    {{ $currentStatus == 'in transit' ? 'selected' : '' }}
                                                    {{ $currentLevel > 3 ? 'disabled' : '' }}>
                                                    In Transit
                                                </option>
                                                
                                                <option value="out for delivery" 
                                                    {{ $currentStatus == 'out for delivery' ? 'selected' : '' }}
                                                    {{ $currentLevel > 4 ? 'disabled' : '' }}>
                                                    Out for Delivery
                                                </option>
                                                
                                                <option value="order received" 
                                                    {{ $currentStatus == 'order received' ? 'selected' : '' }}>
                                                    Order Received
                                                </option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="order-date-cell px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('M d, Y h:i A') : '-' }}
                                    </td>
                                    <td class="received-date-cell px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $order->received_date ? \Carbon\Carbon::parse($order->received_date)->format('M d, Y h:i A') : '-' }}
                                    </td>
                                    <td class="confimation-photo px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if ($order->confirmation_photo)
                                            <a href="{{ asset( $order->confirmation_photo) }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-eye"></i> View Photo
                                            </a>
                                        @else
                                            <span class="text-gray-400">No Photo</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Color Legend -->
    <div class="fixed bottom-4 right-4 bg-white p-4 rounded-lg shadow-lg border border-gray-200">
        <h4 class="font-bold mb-2">Status Legend</h4>
        <div class="space-y-2">
            <div class="flex items-center">
                <span class="w-3 h-3 rounded-full bg-yellow-100 border border-yellow-800 mr-2"></span>
                <span class="text-sm">Processing</span>
            </div>
            <div class="flex items-center">
                <span class="w-3 h-3 rounded-full bg-blue-100 border border-blue-800 mr-2"></span>
                <span class="text-sm">Ordered Pickup</span>
            </div>
            <div class="flex items-center">
                <span class="w-3 h-3 rounded-full bg-purple-100 border border-purple-800 mr-2"></span>
                <span class="text-sm">In Transit</span>
            </div>
            <div class="flex items-center">
                <span class="w-3 h-3 rounded-full bg-orange-100 border border-orange-800 mr-2"></span>
                <span class="text-sm">Out for Delivery</span>
            </div>
            <div class="flex items-center">
                <span class="w-3 h-3 rounded-full bg-green-100 border border-green-800 mr-2"></span>
                <span class="text-sm">Order Received</span>
            </div>
        </div>
    </div>

    <script>
        import Carbon from 'carbon.js'
        
        function updateOrders() {
            fetch('{{ route('api.orders') }}')
                .then(response => response.json())
                .then(orders => {
                    orders.forEach(order => {
                        const orderRow = document.querySelector(`[data-order-id="${order.order_id}"]`);
                        if (orderRow) {
                            // Update status select
                            const statusSelect = orderRow.querySelector('select[name="delivery_status"]');
                            if (statusSelect) {
                                statusSelect.value = order.delivery_status.toLowerCase();
                                
                                const currentStatus = order.delivery_status.toLowerCase();
                                const statusOrder = {
                                    'processing': 1,
                                    'ordered pickup': 2,
                                    'in transit': 3,
                                    'out for delivery': 4,
                                    'order received': 5
                                };
                                const currentLevel = statusOrder[currentStatus] || 0;
                                
                                statusSelect.querySelectorAll('option').forEach(option => {
                                    const optionLevel = statusOrder[option.value] || 0;
                                    option.disabled = optionLevel < currentLevel;
                                });
                                
                                statusSelect.className = `border rounded-md px-2 py-1 text-xs font-medium ${
                                    currentStatus === 'processing' ? 'bg-yellow-100 text-yellow-800 border-yellow-200' :
                                    currentStatus === 'ordered pickup' ? 'bg-blue-100 text-blue-800 border-blue-200' :
                                    currentStatus === 'in transit' ? 'bg-purple-100 text-purple-800 border-purple-200' :
                                    currentStatus === 'out for delivery' ? 'bg-orange-100 text-orange-800 border-orange-200' :
                                    currentStatus === 'order received' ? 'bg-green-100 text-green-800 border-green-200' : ''
                                }`;
                            }

                            // Update customer name - use more specific selector
                            const customerNameCell = orderRow.querySelector('.customer-name-cell');
                            if (customerNameCell) {
                                customerNameCell.textContent = order.user?.name || '-';
                            }

                            // Update dates - use more specific selectors
                            const orderDateCell = orderRow.querySelector('.order-date-cell');
                            if (orderDateCell) {
                                orderDateCell.textContent = order.order_date ? formatDate(order.order_date) : '-';
                            }

                            const receivedDateCell = orderRow.querySelector('.received-date-cell');
                            if (receivedDateCell) {
                                receivedDateCell.textContent = order.received_date ? formatDate(order.received_date) : '-';
                            }

                            // Update confirmation photo - fix typo in class name
                            const photoCell = orderRow.querySelector('.confirmation-photo');
                            if (photoCell) {
                                if (order.confirmation_photo) {
                                    photoCell.innerHTML = `<a href="${order.confirmation_photo}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-eye"></i> View Photo
                                    </a>`;
                                } else {
                                    photoCell.innerHTML = `<span class="text-gray-400">No Photo</span>`;
                                }
                            }
                        }
                    });
                });
        }

        // Poll every 5 seconds
        setInterval(updateOrders, 5000);
    </script>
</body>
</html>