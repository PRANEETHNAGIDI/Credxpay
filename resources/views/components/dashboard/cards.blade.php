<!-- Credit Cards Section -->
<div class="bg-gray-800 rounded-xl p-6 mb-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-white">Your Cards</h2>
        <button onclick="openAddCardModal()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
            Add New Card
        </button>
    </div>

    <div id="cardsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Empty state will be shown here when no cards are present -->
    </div>
</div>

<!-- Add Card Modal -->
<div id="addCardModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-gray-800 rounded-lg p-8 w-full max-w-md">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-white">Add New Credit Card</h3>
            <button onclick="closeAddCardModal()" class="text-gray-400 hover:text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="addCardForm" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-300">Card Number</label>
                <input type="text" name="card_number" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" 
                       maxlength="16" pattern="\d{16}" placeholder="1234 5678 9012 3456" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300">Cardholder Name</label>
                <input type="text" name="card_holder_name" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" 
                       placeholder="Name as shown on card" required>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300">Month</label>
                    <input type="text" name="expiration_month" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" 
                           maxlength="2" pattern="\d{2}" placeholder="MM" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300">Year</label>
                    <input type="text" name="expiration_year" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" 
                           maxlength="2" pattern="\d{2}" placeholder="YY" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300">CVV</label>
                    <input type="password" name="cvv" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" 
                           maxlength="3" pattern="\d{3}" placeholder="123" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300">Credit Limit</label>
                <input type="number" name="credit_limit" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white" 
                       min="1000" max="1000000" placeholder="Enter credit limit" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300">Card Type</label>
                    <select name="card_type" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white">
                        <option value="visa">Visa</option>
                        <option value="mastercard">Mastercard</option>
                        <option value="amex">American Express</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300">Card Color</label>
                    <select name="card_color" class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-white">
                        <option value="blue">Blue</option>
                        <option value="purple">Purple</option>
                        <option value="green">Green</option>
                        <option value="red">Red</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-6">
                <button type="button" onclick="closeAddCardModal()" 
                        class="px-4 py-2 text-sm font-medium text-gray-300 hover:text-white">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-md hover:bg-blue-600">
                    Add Card
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Preview Card -->
<div id="previewCard" class="hidden fixed bottom-8 right-8 w-96">
    <!-- Preview card will be dynamically inserted here -->
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadCards();
    setupFormValidation();
});

function loadCards() {
    fetch('/credit-cards')
        .then(response => response.json())
        .then(cards => {
            const container = document.getElementById('cardsContainer');
            
            if (cards.length === 0) {
                container.innerHTML = createEmptyStateHTML();
            } else {
                container.innerHTML = '';
                cards.forEach(card => {
                    container.innerHTML += createCardHTML(card);
                });
            }
        })
        .catch(error => console.error('Error loading cards:', error));
}

function createEmptyStateHTML() {
    return `
        <div class="col-span-full flex flex-col items-center justify-center p-12 border-2 border-dashed border-gray-600 rounded-xl">
            <img src="/images/card-placeholder.svg" alt="No cards" class="w-32 h-32 mb-4 opacity-50">
            <h3 class="text-xl font-medium text-gray-400 mb-2">No Cards Added Yet</h3>
            <p class="text-gray-500 text-center mb-6">Add your first card to start managing your finances</p>
            <button onclick="openAddCardModal()" 
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg text-sm font-medium transition-colors">
                <i class="fas fa-plus-circle mr-2"></i>Add Your First Card
            </button>
        </div>
    `;
}

function createCardHTML(card) {
    return `
        <div class="bg-gradient-to-br from-${card.card_color}-600 to-${card.card_color}-800 rounded-xl p-6 relative overflow-hidden transform transition-transform duration-300 hover:scale-105">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full transform translate-x-32 -translate-y-32"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-8">
                    <img src="/images/chip.png" alt="Card Chip" class="w-12">
                    <span class="text-white text-sm uppercase">${card.card_type}</span>
                </div>
                <p class="text-lg text-white mb-4">**** **** **** ${card.card_number}</p>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-300 mb-1">Card Holder</p>
                        <p class="text-white">${card.card_holder_name}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-300 mb-1">Expires</p>
                        <p class="text-white">${card.expiration_month}/${card.expiration_year}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm text-gray-300 mb-1">Available Balance</p>
                    <p class="text-white">₹${card.available_balance.toLocaleString()}</p>
                </div>
                <div class="mt-4">
                    <p class="text-sm text-gray-300 mb-1">Cred ID</p>
                    <p class="text-white font-mono">${card.cred_id}</p>
                </div>
                <button onclick="deleteCard(${card.id})" class="absolute top-4 right-4 text-white opacity-50 hover:opacity-100 transition-opacity">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
}

function setupFormValidation() {
    const form = document.getElementById('addCardForm');
    const inputs = form.querySelectorAll('input');

    inputs.forEach(input => {
        if (input.name === 'card_number') {
            input.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 16) value = value.slice(0, 16);
                e.target.value = value;
                updatePreviewCard();
            });
        }

        if (input.name === 'expiration_month') {
            input.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 0) {
                    value = Math.min(Math.max(parseInt(value), 1), 12).toString().padStart(2, '0');
                }
                if (value.length > 2) value = value.slice(0, 2);
                e.target.value = value;
                updatePreviewCard();
            });
        }

        if (input.name === 'expiration_year') {
            input.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 2) value = value.slice(0, 2);
                e.target.value = value;
                updatePreviewCard();
            });
        }

        input.addEventListener('input', updatePreviewCard);
    });
}

function updatePreviewCard() {
    const form = document.getElementById('addCardForm');
    const formData = new FormData(form);
    const preview = document.getElementById('previewCard');
    const cardColor = formData.get('card_color') || 'blue';
    const cardType = formData.get('card_type') || 'visa';

    const previewHTML = `
        <div class="bg-gradient-to-br from-${cardColor}-600 to-${cardColor}-800 rounded-xl p-6 relative overflow-hidden shadow-lg">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full transform translate-x-32 -translate-y-32"></div>
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-8">
                    <img src="/images/chip.png" alt="Card Chip" class="w-12">
                    <span class="text-white text-sm uppercase">${cardType}</span>
                </div>
                <p class="text-lg text-white mb-4">
                    ${formData.get('card_number')?.replace(/(\d{4})/g, '$1 ').trim() || '**** **** **** ****'}
                </p>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-300 mb-1">Card Holder</p>
                        <p class="text-white">${formData.get('card_holder_name') || 'YOUR NAME'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-300 mb-1">Expires</p>
                        <p class="text-white">
                            ${formData.get('expiration_month') || 'MM'}/${formData.get('expiration_year') || 'YY'}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    `;

    preview.innerHTML = previewHTML;
    preview.classList.remove('hidden');
}

function openAddCardModal() {
    document.getElementById('addCardModal').classList.remove('hidden');
    document.getElementById('previewCard').classList.remove('hidden');
}

function closeAddCardModal() {
    document.getElementById('addCardModal').classList.add('hidden');
    document.getElementById('previewCard').classList.add('hidden');
    document.getElementById('addCardForm').reset();
}

document.getElementById('addCardForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData);
    
    try {
        const response = await fetch('/credit-cards', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        });

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || 'Failed to add card');
        }

        await response.json();
        closeAddCardModal();
        loadCards();
    } catch (error) {
        console.error('Error:', error);
        alert(error.message || 'Failed to add card. Please try again.');
    }
});

async function deleteCard(cardId) {
    if (!confirm('Are you sure you want to remove this card?')) return;

    try {
        const response = await fetch(`/credit-cards/${cardId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        if (!response.ok) throw new Error('Failed to remove card');

        loadCards();
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to remove card. Please try again.');
    }
}
</script>