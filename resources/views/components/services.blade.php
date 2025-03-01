<section id="services" class="bg-gray-800 py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center text-white mb-16">Our Services</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['title' => 'Secure Encryption', 'description' => 'State-of-the-art encryption for all transactions'],
                ['title' => 'Quick Payments', 'description' => 'Lightning-fast payment processing'],
                ['title' => 'User-Friendly Interface', 'description' => 'Intuitive design for seamless experience']
            ] as $service)
            <div class="bg-gray-900 rounded-lg p-8">
                <h3 class="text-xl font-semibold text-white mb-4">{{ $service['title'] }}</h3>
                <p class="text-gray-400 mb-6">{{ $service['description'] }}</p>
            </div>
            @endforeach
        </div>
        <div class="flex justify-center gap-4 mt-12">
            <button class="bg-teal-500 hover:bg-teal-600 text-white px-6 py-3 rounded-lg font-medium">
                Open Account
            </button>
            <button class="border border-teal-500 text-teal-500 hover:bg-teal-500 hover:text-white px-6 py-3 rounded-lg font-medium transition-colors">
                Open User Guide
            </button>
        </div>
    </div>
</section>