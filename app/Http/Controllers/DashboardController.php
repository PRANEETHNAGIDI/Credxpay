<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CreditCard;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $cards = $user->creditCards;
        $transactions = $user->transactions()
            ->with('creditCard')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('user', 'cards', 'transactions'));
    }
}