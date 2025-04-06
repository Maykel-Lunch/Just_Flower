<!-- Change the questions based on the true FAQs -->

@php
    $faqs = [
        ['question' => 'How do I place an order?', 'answer' => 'Simply browse our collection, add flowers to your cart, and proceed to checkout.'],
        ['question' => 'Can I customize my flower arrangement?', 'answer' => 'Yes! You can select colors, types of flowers, and arrangement styles.'],
        ['question' => 'Do you offer same-day delivery?', 'answer' => 'Yes, for orders placed before 12 PM, same-day delivery is available in selected areas.'],
        ['question' => 'How can I track my order?', 'answer' => 'You can track your order in the "Order Status" section using your order number.'],
    ];
@endphp


<!-- Change the design its too pink -->
<div class="max-w-7xl mx-auto px-6 py-4 bg-white shadow-lg rounded-2xl">

    <h2 class="text-2xl font-semibold text-pink-600 mb-4">Frequently Asked Questions</h2>
    <div class="space-y-4">
        @foreach ($faqs as $faq)
            <div class="border-b border-pink-400 pb-2" x-data="{ open: false }">
                <button class="w-full text-left text-lg font-medium text-pink-500 focus:outline-none flex justify-between items-center" 
                    @click="open = !open">
                    <span>{{ $faq['question'] }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pink-500 transform transition-transform duration-300" 
                        :class="{ 'rotate-180': open }" 
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                <p class="text-pink-400 mt-2 text-sm" 
                   x-show="open" 
                   x-transition:enter="transition ease-out duration-300"
                   x-transition:enter-start="opacity-0" 
                   x-transition:enter-end="opacity-100" 
                   x-transition:leave="transition ease-in duration-200"
                   x-transition:leave-start="opacity-100" 
                   x-transition:leave-end="opacity-0">
                    {{ $faq['answer'] }}
                </p>
            </div>
        @endforeach
    </div>
</div>


