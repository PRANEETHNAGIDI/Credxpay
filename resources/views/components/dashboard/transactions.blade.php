<!-- Transactions Section -->
<div class="bg-gray-800 rounded-xl p-6 mb-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-white">Recent Transactions</h2>
        <div class="flex space-x-4">
            <select id="transactionType" class="bg-gray-700 text-white rounded-lg px-4 py-2 text-sm">
                <option value="all">All Types</option>
                <option value="purchase">Purchases</option>
                <option value="payment">Payments</option>
                <option value="refund">Refunds</option>
            </select>
            <button onclick="openAddTransactionModal()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                New Transaction
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="text-left text-gray-400 text-sm">
                    <th class="pb-4">Date</th>
                    <th class="pb-4">Description</th>
                    <th class="pb-4">Category</th>
                    <th class="pb-4">Card</th>
                    <th class="pb-4 text-right">Amount</th>
                    <th class="pb-4 text-right">Status</th>
                </tr>
            </thead>
            <tbody id="transactionsTable" class="text-gray-300">
                <!-- Transactions will be dynamically loaded here -->
            </tbody>
        </table>
    </div>

    <!-- Empty State -->
    <div id="emptyTransactions" class="hidden text-center py-12">
        <i class="fas fa-receipt text-gray-600 text-4xl mb-4"></i>
        <h3 class="text-xl font-medium text-gray-400 mb-2">No Transactions Yet</h3>
        <p class="text-gray-500">Start using your card to see transactions here</p>
    </div>
</div>

<!-- Add Transaction Modal -->
<div id="addTransactionModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-gray-800 rounded-lg p-8 w-full max-w-md">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-white">Add New Transaction</h3>
            <button onclick="closeAddTransactionModal()" class="text-gray-400 hover:text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="addTransactionForm" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-300">Card</label>
                <select name="credit_card_id" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" required>
                    <!-- Cards will be loaded dynamically -->
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300">Amount</label>
                <input type="number" name="amount" step="0.01" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300">Type</label>
                <select name="type" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white">
                    <option value="purchase">Purchase</option>
                    <option value="payment">Payment</option>
                    <option value="refund">Refund</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300">Description</label>
                <input type="text" name="description" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300">Merchant Name</label>
                <input type="text" name="merchant_name" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300">Category</label>
                <select name="category" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white">
                    <option value="shopping">Shopping</option>
                    <option value="food">Food & Dining</option>
                    <option value="entertainment">Entertainment</option>
                    <option value="travel">Travel</option>
                    <option value="utilities">Utilities</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="flex justify-end space-x-4 mt-6">
                <button type="button" onclick="closeAddTransactionModal()" 
                        class="px-4 py-2 text-sm font-medium text-gray-300 hover:text-white">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-600">
                    Add Transaction
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadTransactions();
    loadCardsForTransaction();
});

function loadTransactions() {
    fetch('/transactions')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('transactionsTable');
            const emptyState = document.getElementById('emptyTransactions');
            
            if (data.data.length === 0) {
                tbody.innerHTML = '';
                emptyState.classList.remove('hidden');
                return;
            }

            emptyState.classList.add('hidden');
            tbody.innerHTML = data.data.map(transaction => `
                <tr class="border-t border-gray-700">
                    <td class="py-4">${new Date(transaction.created_at).toLocaleDateString()}</td>
                    <td class="py-4">
                        <div class="font-medium">${transaction.description}</div>
                        <div class="text-sm text-gray-500">${transaction.merchant_name || ''}</div>
                    </td>
                    <td class="py-4">
                        <span class="px-2 py-1 bg-gray-700 rounded-full text-xs">
                            ${transaction.category}
                        </span>
                    </td>
                    <td class="py-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-${transaction.credit_card.card_color}-600 rounded-full flex items-center justify-center mr-2">
                                <i class="fas fa-credit-card text-white"></i>
                            </div>
                            <span>****${transaction.credit_card.card_number}</span>
                        </div>
                    </td>
                    <td class="py-4 text-right ${transaction.type === 'purchase' ? 'text-red-500' : 'text-green-500'}">
                        ${transaction.type === 'purchase' ? '-' : '+'}₹${transaction.amount.toLocaleString()}
                    </td>
                    <td class="py-4 text-right">
                        <span class="px-2 py-1 bg-green-500 bg-opacity-20 text-green-500 rounded-full text-xs">
                            ${transaction.status}
                        </span>
                    </td>
                </tr>
            `).join('');
        })
        .catch(error => console.error('Error loading transactions:', error));
}

function loadCardsForTransaction() {
    fetch('/credit-cards')
        .then(response => response.json())
        .then(cards => {
            const select = document.querySelector('[name="credit_card_id"]');
            select.innerHTML = cards.map(card => `
                <option value="${card.id}">****${card.card_number} - ${card.card_type}</option>
            `).join('');
        })
        .catch(error => console.error('Error loading cards:', error));
}

function openAddTransactionModal() {
    document.getElementById('addTransactionModal').classList.remove('hidden');
}

function closeAddTransactionModal() {
    document.getElementById('addTransactionModal').classList.add('hidden');
    document.getElementById('addTransactionForm').reset();
}

document.getElementById('addTransactionForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData);
    
    try {
        const response = await fetch('/transactions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        });

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || 'Failed to add transaction');
        }

        await response.json();
        closeAddTransactionModal();
        loadTransactions();
    } catch (error) {
        console.error('Error:', error);
        alert(error.message || 'Failed to add transaction. Please try again.');
    }
});

document.getElementById('transactionType').addEventListener('change', function(e) {
    const type = e.target.value;
    const url = type === 'all' ? '/transactions' : `/transactions?type=${type}`;
    
    fetch(url)
        .then(response => response.json())
        .then(data => loadTransactions(data))
        .catch(error => console.error('Error filtering transactions:', error));
});
</script>