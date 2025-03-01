<!-- Balance and Card Section -->
<div class="grid grid-cols-3 gap-8 mb-8">
    <!-- Available Balance -->
    <div class="col-span-2 bg-gray-800 rounded-xl p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-white">Available Balance</h2>
            <a href="#" class="text-blue-500 hover:text-blue-400">View Report</a>
        </div>
        <div class="mb-6">
            <p class="text-4xl font-bold text-white">₹45,345.00</p>
            <div class="flex space-x-4 mt-2">
                <div class="flex items-center text-green-500">
                    <i class="fas fa-arrow-up mr-1"></i>
                    <span>32.5% this month</span>
                </div>
            </div>
        </div>
        <canvas id="balanceChart" class="w-full h-48"></canvas>
    </div>

    <!-- Debit Card -->
  <!-- Debit Card (Smaller Height) -->
<div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl p-4 relative overflow-hidden h-56"> <!-- Reduced height -->
    <div class="absolute top-0 right-0 w-48 h-48 bg-white opacity-5 rounded-full transform translate-x-20 -translate-y-20"></div>
    <div class="relative z-10">
        <img src="{{ asset('images/chip.png') }}" alt="Card Chip" class="w-8 mb-4"> <!-- Smaller chip image -->
        <p class="text-lg text-white mb-2">**** **** **** 4589</p>
        <div class="flex justify-between items-end">
            <div>
                <p class="text-xs text-gray-300 mb-1">Card Holder</p>
                <p class="text-white text-sm">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-300 mb-1">Expires</p>
                <p class="text-white text-sm">09/24</p>
            </div>
        </div>
    </div>
    <div class="mt-4 grid grid-cols-3 gap-2">
        <button class="bg-blue-700 hover:bg-blue-600 text-white py-1 px-3 rounded-lg text-xs">Transfer</button>
        <button class="bg-blue-700 hover:bg-blue-600 text-white py-1 px-3 rounded-lg text-xs">Pay Bill</button>
        <button class="bg-blue-700 hover:bg-blue-600 text-white py-1 px-3 rounded-lg text-xs">Top-up</button>
    </div>
</div>

</div>

<!-- Savings and Transactions -->
<div class="grid grid-cols-3 gap-8">
    <!-- Savings Overview -->
    <div class="col-span-2 bg-gray-800 rounded-xl p-6">
        <h2 class="text-xl font-semibold text-white mb-6">Savings Overview</h2>
        <div class="space-y-4">
            @foreach([
                ['name' => 'Emergency Fund', 'current' => 8500, 'target' => 10000, 'color' => 'bg-blue-500'],
                ['name' => 'Car Purchase', 'current' => 15000, 'target' => 25000, 'color' => 'bg-green-500'],
                ['name' => 'Home Down Payment', 'current' => 45000, 'target' => 100000, 'color' => 'bg-purple-500']
            ] as $saving)
            <div>
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-white">{{ $saving['name'] }}</span>
                    <span class="text-gray-400">₹{{ number_format($saving['current']) }} / ₹{{ number_format($saving['target']) }}</span>
                </div>
                <div class="h-2 bg-gray-700 rounded-full">
                    <div class="{{ $saving['color'] }} h-full rounded-full" style="width: {{ ($saving['current'] / $saving['target']) * 100 }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-gray-800 rounded-xl p-6">
        <h2 class="text-xl font-semibold text-white mb-6">Recent Transactions</h2>
        <div class="space-y-4">
            @foreach([
                ['name' => 'Netflix Subscription', 'type' => 'Entertainment', 'amount' => -14.99, 'icon' => 'fa-film'],
                ['name' => 'Salary Deposit', 'type' => 'Income', 'amount' => 5000.00, 'icon' => 'fa-briefcase'],
                ['name' => 'Grocery Store', 'type' => 'Shopping', 'amount' => -125.30, 'icon' => 'fa-shopping-cart']
            ] as $transaction)
            <div class="flex items-center justify-between p-3 bg-gray-700 rounded-lg">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center">
                        <i class="fas {{ $transaction['icon'] }} text-gray-300"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white">{{ $transaction['name'] }}</p>
                        <p class="text-xs text-gray-400">{{ $transaction['type'] }}</p>
                    </div>
                </div>
                <span class="text-sm font-medium {{ $transaction['amount'] > 0 ? 'text-green-500' : 'text-red-500' }}">
                    {{ $transaction['amount'] > 0 ? '+' : '' }}₹{{ number_format(abs($transaction['amount']), 2) }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
</div>