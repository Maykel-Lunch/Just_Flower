



{{-- filepath: c:\xampp\htdocs\Just_Flower\resources\views\gift-cards\index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6">Gift Cards</h1>

    {{-- Section: Gift Cards Owned by the User --}}
    <div class="mb-12">
        <h2 class="text-2xl font-semibold mb-4">My Gift Cards</h2>
        @if($giftCards->isEmpty())
            <p class="text-gray-600">You don't own any gift cards yet.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($giftCards as $giftCard)
                    <div class="relative h-64 w-full rounded-2xl overflow-hidden shadow-lg bg-gradient-to-br from-green-400 to-blue-500">
                        <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>
                        <div class="relative p-6 h-full flex flex-col">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="text-2xl font-bold text-white">{{ strtoupper($giftCard->membership_lvl) }} MEMBER</h2>
                                    <p class="text-white/80 mt-1">Member ID: {{ $giftCard->member_id }}</p>
                                </div>
                            </div>
                            <div class="mt-6 space-y-3">
                                <p class="text-white font-medium">Birthday Discount: {{ $giftCard->birthday_discount }}%</p>
                                <p class="text-white/90 text-sm">Member Code: {{ $giftCard->member_code }}</p>
                            </div>
                            <div class="mt-auto">
                                <p class="text-white/80 text-xs">Member since: <span class="font-medium">{{ $giftCard->member_since }}</span></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Section: Predefined Gift Card Templates --}}
    <div>
        <h2 class="text-2xl font-semibold mb-4">Available Gift Cards</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Welcome Voucher Card -->
            <div class="relative h-64 w-full rounded-2xl overflow-hidden shadow-lg bg-gradient-to-br from-yellow-400 to-pink-500">
                <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>
                <div class="relative p-6 h-full flex flex-col">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-2xl font-bold text-white">WELCOME VOUCHER</h2>
                            <p class="text-white/80 mt-1">New Member</p>
                        </div>
                    </div>
                    <div class="mt-6">
                        <div class="bg-white/20 p-4 rounded-lg backdrop-blur">
                            <p class="text-white font-medium">Free Shipping Discount</p>
                            <p class="text-white/90 text-sm mt-1">for the first purchase</p>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <p class="text-white/80 text-xs">Member since: <span class="font-medium">New</span></p>
                    </div>
                </div>
            </div>

            <!-- Silver Member Card -->
            <div class="relative h-64 w-full rounded-2xl overflow-hidden shadow-lg bg-gradient-to-br from-gray-400 to-gray-600">
                <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>
                <div class="relative p-6 h-full flex flex-col">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-2xl font-bold text-white">SILVER MEMBER</h2>
                            <p class="text-white/80 mt-1">Member ID: XF-7890-2023</p>
                        </div>
                    </div>
                    <div class="mt-6 space-y-3">
                        <div class="bg-white/20 p-4 rounded-lg backdrop-blur">
                            <p class="text-white font-medium">Free Shipping Discount</p>
                        </div>
                        <p class="text-white font-medium">5% Birthday discount</p>
                        <p class="text-white/90 text-sm">Capped at 50₱, min. spend 500₱</p>
                    </div>
                    <div class="mt-auto">
                        <p class="text-white/80 text-xs">Member since: <span class="font-medium">Jan 2020</span></p>
                    </div>
                </div>
            </div>

            <!-- Gold Member Card -->
            <div class="relative h-64 w-full rounded-2xl overflow-hidden shadow-lg bg-gradient-to-br from-yellow-500 to-yellow-700">
                <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>
                <div class="relative p-6 h-full flex flex-col">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-2xl font-bold text-white">GOLD MEMBER</h2>
                            <p class="text-white/80 mt-1">Member ID: XF-7890-2023</p>
                        </div>
                    </div>
                    <div class="mt-6 space-y-3">
                        <div class="bg-white/20 p-4 rounded-lg backdrop-blur">
                            <p class="text-white font-medium">Free Shipping Discount</p>
                        </div>
                        <p class="text-white font-medium">10% Birthday discount</p>
                        <p class="text-white/90 text-sm">Capped at 100₱, min. spend 500₱</p>
                    </div>
                    <div class="mt-auto">
                        <p class="text-white/80 text-xs">Member since: <span class="font-medium">Jan 2020</span></p>
                    </div>
                </div>
            </div>

            <!-- Platinum Member Card -->
            <div class="relative h-64 w-full rounded-2xl overflow-hidden shadow-lg bg-gradient-to-br from-teal-400 to-blue-700">
                <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>
                <div class="relative p-6 h-full flex flex-col">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-2xl font-bold text-white">PLATINUM MEMBER</h2>
                            <p class="text-white/80 mt-1">Member ID: XF-7890-2023</p>
                        </div>
                    </div>
                    <div class="mt-6 space-y-3">
                        <div class="bg-white/20 p-4 rounded-lg backdrop-blur">
                            <p class="text-white font-medium">Free Shipping Discount</p>
                        </div>
                        <p class="text-white font-medium">15% Birthday discount</p>
                        <p class="text-white/90 text-sm">Capped at 200₱</p>
                    </div>
                    <div class="mt-auto">
                        <p class="text-white/80 text-xs">Member since: <span class="font-medium">Jan 2020</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection