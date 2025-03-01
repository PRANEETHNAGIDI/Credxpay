<section id="features" class="bg-gray-800 py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-white mb-16">Key Features</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach([
                ['icon' => 'fa-shield-alt', 'title' => 'Secure Transactions', 'description' => 'Bank-grade encryption for all your transactions'],
                ['icon' => 'fa-exchange-alt', 'title' => 'Flexible Payments', 'description' => 'Multiple payment options at your fingertips'],
                ['icon' => 'fa-credit-card', 'title' => 'Card Support', 'description' => 'Full support for Visa and MasterCard'],
                ['icon' => 'fa-plug', 'title' => 'Seamless Integration', 'description' => 'Works with Amazon Pay and Samsung Pay']
            ] as $feature)
            <div class="bg-gray-900 p-6 rounded-lg text-center transition-transform transform hover:scale-105">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-teal-500 mb-6 shadow-lg">
                    <i class="fas {{ $feature['icon'] }} text-2xl text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-white mb-2">{{ $feature['title'] }}</h3>
                <p class="text-gray-400">{{ $feature['description'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

