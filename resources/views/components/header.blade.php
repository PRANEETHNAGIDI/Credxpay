<nav class="bg-gray-900 border-b border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <img class="h-12 w-auto" src="{{ asset('images/logo.svg') }}" alt="CredXPay">
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="#features" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Features</a>
                        <a href="#services" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Services</a>
                        <a href="#about" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">About Us</a>
                    </div>
                </div>
            </div>
            <div>
                <a href="{{ route('register') }}" class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                    Open Account
                </a>
            </div>
        </div>
    </div>
</nav>