@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-900">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 w-64 bg-gray-800">
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-center h-16 px-4 bg-gray-900">
                <img src="{{ asset('images/logo.svg') }}" alt="CredXPay" class="h-8">
            </div>
            <nav class="flex-1 px-2 py-4 space-y-1">
                <a href="#overview" class="nav-link flex items-center px-4 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-home w-6"></i>
                    Overview
                </a>
                <a href="#cards" class="nav-link flex items-center px-4 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-credit-card w-6"></i>
                    Cards
                </a>
                <a href="#transactions" class="nav-link flex items-center px-4 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-exchange-alt w-6"></i>
                    Transactions
                </a>
                <a href="#savings" class="nav-link flex items-center px-4 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-piggy-bank w-6"></i>
                    Savings
                </a>
                <a href="#investments" class="nav-link flex items-center px-4 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-chart-line w-6"></i>
                    Investments
                </a>
                <a href="#settings" class="nav-link flex items-center px-4 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg">
                    <i class="fas fa-cog w-6"></i>
                    Settings
                </a>
            </nav>
            <div class="p-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700 rounded-lg">
                        <i class="fas fa-sign-out-alt w-6"></i>
                        Log out
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="ml-64 p-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-bold text-white">Hello {{ Auth::user()->first_name }}!</h1>
                <p class="text-gray-400">{{ now()->format('l, F j, Y') }}</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Search transactions..." class="w-64 px-4 py-2 bg-gray-800 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                </div>
                <div class="relative">
                    <button class="relative p-2 text-gray-400 hover:text-white">
                        <i class="fas fa-bell"></i>
                        <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                </div>
                <div class="flex items-center space-x-3">
                <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile" class="w-10 h-10 rounded-full object-cover">
                <div class="text-left">
                        <p class="text-sm font-medium text-white">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                        <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dynamic Content Sections -->
        <div id="overview-section" class="section">
            @include('components.dashboard.content')
        </div>

        <div id="cards-section" class="section hidden">
            @include('components.dashboard.cards')
        </div>

        <div id="transactions-section" class="section hidden">
            @include('components.dashboard.transactions')
        </div>

        <div id="savings-section" class="section hidden">
            <div class="bg-gray-800 rounded-xl p-6">
                <h2 class="text-xl font-semibold text-white mb-6">Savings</h2>
                <p class="text-gray-400">Savings section </p>
            </div>
        </div>

        <div id="investments-section" class="section hidden">
            <div class="bg-gray-800 rounded-xl p-6">
                <h2 class="text-xl font-semibold text-white mb-6">Investments</h2>
                <p class="text-gray-400">Investments section </p>
            </div>
        </div>

        <div id="settings-section" class="section hidden">
            <div class="bg-gray-800 rounded-xl p-6">
                <h2 class="text-xl font-semibold text-white mb-6">Settings</h2>
                <p class="text-gray-400">Settings section </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize navigation
    initializeNavigation();
    
    // Initialize Chart.js
    initializeChart();
});

function initializeNavigation() {
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const sectionId = this.getAttribute('href').substring(1);
            showSection(sectionId);
        });
    });

    const initialSection = window.location.hash.substring(1) || 'overview';
    showSection(initialSection);

    window.addEventListener('hashchange', () => {
        const section = window.location.hash.substring(1) || 'overview';
        showSection(section);
    });
}

function showSection(sectionName) {
    document.querySelectorAll('.section').forEach(section => section.classList.add('hidden'));
    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('text-white', 'bg-gray-700');
        link.classList.add('text-gray-300');
    });

    const selectedSection = document.getElementById(`${sectionName}-section`);
    if (selectedSection) {
        selectedSection.classList.remove('hidden');
    }

    const activeLink = document.querySelector(`a[href="#${sectionName}"]`);
    if (activeLink) {
        activeLink.classList.remove('text-gray-300');
        activeLink.classList.add('text-white', 'bg-gray-700');
    }

    history.pushState(null, null, `#${sectionName}`);
}

function initializeChart() {
    const ctx = document.getElementById('balanceChart');
    if (ctx) {
        new Chart(ctx.getContext('2d'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Income',
                    data: [30000, 35000, 32000, 38000, 42000, 45000],
                    borderColor: '#10B981',
                    tension: 0.4,
                    fill: false
                }, {
                    label: 'Expenses',
                    data: [25000, 28000, 27000, 30000, 32000, 35000],
                    borderColor: '#EF4444',
                    tension: 0.4,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#9CA3AF'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#374151'
                        },
                        ticks: {
                            color: '#9CA3AF'
                        }
                    },
                    x: {
                        grid: {
                            color: '#374151'
                        },
                        ticks: {
                            color: '#9CA3AF'
                        }
                    }
                }
            }
        });
    }
}
</script>
@endpush
@endsection
