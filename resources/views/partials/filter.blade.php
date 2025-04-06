<!-- Filter Panel : Adjust the design based on the prototype-->
<div id="filterPanel" class="hidden bg-white border border-gray-300 rounded-lg p-4 mb-4">
    <form id="filterForm" class="flex flex-wrap items-end gap-4" method="GET" action="{{ route('dashboard') }}">
        <!-- Category -->
        <div class="flex flex-col">
            <label class="text-sm font-medium mb-1">Category</label>
            <select name="category" class="border border-gray-300 rounded p-2 w-40">
                <option value="">All</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
        </div>

        <!-- Size -->
        <div class="flex flex-col">
            <label class="text-sm font-medium mb-1">Size</label>
            <select name="size" class="border border-gray-300 rounded p-2 w-32">
                <option value="">Any</option>
                @foreach ($sizes as $sz)
                    <option value="{{ $sz }}" {{ request('size') == $sz ? 'selected' : '' }}>{{ $sz }}</option>
                @endforeach
            </select>
        </div>

        <!-- Flower Type -->
        <div class="flex flex-col">
            <label class="text-sm font-medium mb-1">Flower Type</label>
            <select name="flower_type" class="border border-gray-300 rounded p-2 w-40">
                <option value="">Any</option>
                @foreach ($flowerTypes as $type)
                    <option value="{{ $type }}" {{ request('flower_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
        </div>

        <!-- Occasion -->
        <div class="flex flex-col">
            <label class="text-sm font-medium mb-1">Occasion</label>
            <select name="occasion" class="border border-gray-300 rounded p-2 w-44">
                <option value="">All</option>
                @foreach ($occasions as $oc)
                    <option value="{{ $oc }}" {{ request('occasion') == $oc ? 'selected' : '' }}>{{ $oc }}</option>
                @endforeach
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