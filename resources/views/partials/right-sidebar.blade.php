<!-- Right Sidebar -->
<aside class="w-1/4 bg-white border-l flex flex-col overflow-y-auto m-2 rounded-lg shadow-sm">
    <div class="p-6 space-y-6">
        <!-- Profile Section -->
        <div class="text-center">
            <div class="relative w-20 h-20 mx-auto">
                <img src="{{ asset('flowershop_db/store_logo/Logo2.png') }}" class="rounded-full w-full h-full object-cover ring-4 ring-pink-100" alt="Profile">
          </div>
            <p class="mt-3 font-bold text-xl text-gray-800">Just Flower</p>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-center space-x-6 text-pink-600">
            <div class="flex flex-col items-center group">
                <button class="p-3 rounded-full bg-pink-50 group-hover:bg-pink-100 transition-colors duration-200">
                    <i class="fas fa-bell text-xl"></i>
                </button>
                <span class="text-xs mt-2 text-gray-600">Mute</span>
          </div>
            <div class="flex flex-col items-center group">
                <button class="p-3 rounded-full bg-pink-50 group-hover:bg-pink-100 transition-colors duration-200">
                    <i class="fas fa-magnifying-glass text-xl"></i>
                </button>
                <span class="text-xs mt-2 text-gray-600">Search</span>
            </div>
            @if (isset($users))
                <div class="flex flex-col items-center group">
                    <a href="{{ route('admin.orders') }}" class="p-3 rounded-full bg-pink-50 group-hover:bg-pink-100 transition-colors duration-200">
                        <i class="fas fa-user-shield text-xl"></i>
                    </a>
                    <span class="text-xs mt-2 text-gray-600">Admin</span>
                </div>
                <div class="flex flex-col items-center group">
                    <a href="{{ route('admin.deliveryboard') }}" class="p-3 rounded-full bg-pink-50 group-hover:bg-pink-100 transition-colors duration-200">
                        <i class="fas fa-truck text-xl"></i>
                    </a>
                    <span class="text-xs mt-2 text-gray-600">Delivery</span>
            </div> 
          @endif
        </div>

        <!-- Accordion -->
        <div class="space-y-4">
            <details class="group">
                <summary class="font-semibold cursor-pointer flex justify-between items-center p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    Chat info
                    <i class="fas fa-chevron-down transform group-open:rotate-180 transition-transform duration-200"></i>
                </summary>
                <div class="p-4 text-gray-600">
                    <!-- Add chat info content here -->
                </div>
          </details>

            <details class="group">
                <summary class="font-semibold cursor-pointer flex justify-between items-center p-3 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    Privacy & support
                    <i class="fas fa-chevron-down transform group-open:rotate-180 transition-transform duration-200"></i>
                </summary>
                <div class="p-4 text-gray-600">
                    <!-- Add privacy & support content here -->
                </div>
          </details>
        </div>
      </div>
</aside>