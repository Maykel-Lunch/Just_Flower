<!-- Filter Panel : Adjust the design based on the prototype-->
<div id="filterPanel" class="hidden bg-white border border-gray-300 rounded-lg p-4 mb-4">
    <form id="filterForm" class="flex flex-wrap items-end gap-4" method="GET" action="{{ route('dashboard') }}">
        <!-- Category -->
        <div class="flex flex-col">
            <label class="text-sm font-medium mb-1">Category</label>
            <select class="border border-gray-300 rounded p-2 w-40">
                <option value="">All</option>
                <option>Roses</option>
                <option>Tulips</option>
                <option>Orchids</option>
            </select>
        </div>

        <!-- Size -->
        <div class="flex flex-col">
            <label class="text-sm font-medium mb-1">Size</label>
            <select class="border border-gray-300 rounded p-2 w-32">
                <option value="">Any</option>
                <option>Small</option>
                <option>Medium</option>
                <option>Large</option>
            </select>
        </div>

        <!-- Flower Type -->
        <div class="flex flex-col">
            <label class="text-sm font-medium mb-1">Flower Type</label>
            <select class="border border-gray-300 rounded p-2 w-40">
                <option value="">Any</option>
                <option>Fresh</option>
                <option>Artificial</option>
                <option>Dried</option>
            </select>
        </div>

        <!-- Occasion -->
        <div class="flex flex-col">
            <label class="text-sm font-medium mb-1">Occasion</label>
            <select class="border border-gray-300 rounded p-2 w-44">
                <option value="">All</option>
                <option>Birthday</option>
                <option>Anniversary</option>
                <option>Wedding</option>
                <option>Valentine's Day</option>
            </select>
        </div>

        <!-- Price Range -->
        <div class="flex flex-col">
            <label class="text-sm font-medium mb-1">Price Range</label>
            <select name="price" class="border border-gray-300 rounded p-2 w-40">
                <option value="">Any</option>
                <option value="lt100" {{ request('price') == 'lt100' ? 'selected' : '' }}>Less than ₱100</option>
                <option value="100-500" {{ request('price') == '100-500' ? 'selected' : '' }}>₱100 - ₱500</option>
                <option value="gt500" {{ request('price') == 'gt500' ? 'selected' : '' }}>More than ₱500</option>
            </select>
        </div>



        <!-- Apply Button -->
        <div class="flex">
            <button type="submit" class="bg-[#F566BC] text-white px-4 py-2 rounded-full hover:bg-pink-600 transition mt-6">
                Apply
            </button>
        </div>
        

    </form>
</div>


<!-- Toggle Script -->
<script>
    const filterBtn = document.getElementById('filterBtn');
    const filterPanel = document.getElementById('filterPanel');

    filterBtn.addEventListener('click', () => {
        filterPanel.classList.toggle('hidden');
    });
</script>