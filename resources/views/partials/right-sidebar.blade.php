<!-- Right Sidebar -->
<aside class="w-1/4 bg-white border-l flex flex-col overflow-y-auto m-2 rounded-lg">
      <div class="p-4 space-y-4">
        <div class="text-center">
          <div class="relative w-14 h-14 mx-auto">
            <img src="{{ asset('flowershop_db/store_logo/Logo2.png') }}" class="rounded-full w-full h-full object-cover" alt="Profile">
          </div>
            <p class="mt-2 font-semibold text-lg">Just Flower </p>
        </div>

        <div class="flex justify-center space-x-4 text-purple-600 text-lg">
          <div class="flex flex-col items-center">
            <button><i class="fas fa-bell"></i></button>
            <span class="text-xs">Mute</span>
          </div>
          <div class="flex flex-col items-center">
            <button><i class="fas fa-magnifying-glass"></i></button>
            <span class="text-xs">Search</span>
          </div>
          <!-- Add Admin Button -->
          @if (isset($users))
            <div class="flex flex-col items-center">
              <a href="{{ route('admin.orders') }}" class="text-purple-600"><i class="fas fa-user-shield"></i></a>
              <span class="text-xs">Admin</span>
            </div>
            <div class="flex flex-col items-center">
              <a href="{{ route('admin.deliveryboard') }}" class="text-purple-600"><i class="fas fa-truck"></i></a>
              <span class="text-xs">Delivery</span>
            </div> 
          @endif
        </div>

        <!-- Accordion -->
        <div class="space-y-2">
          <details class="text-base font-sans">
            <summary class="font-bold cursor-pointer flex justify-between items-center">Chat info <i class="fas fa-chevron-down"></i></summary>
          </details>

          <details class="text-base font-sans">
            <summary class="font-bold cursor-pointer flex justify-between items-center">Privacy & support <i class="fas fa-chevron-down"></i></summary>
          </details>
        </div>
      </div>