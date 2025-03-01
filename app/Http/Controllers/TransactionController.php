<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\CreditCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'credit_card_id' => 'required|exists:credit_cards,id',
            'amount' => 'required|numeric',
            'type' => 'required|string',
            'description' => 'required|string',
            'merchant_name' => 'nullable|string',
            'category' => 'required|string',
        ]);

        DB::transaction(function () use ($validated) {
            $card = CreditCard::findOrFail($validated['credit_card_id']);
            
            if ($validated['type'] === 'purchase') {
                if ($card->available_balance < $validated['amount']) {
                    throw new \Exception('Insufficient funds');
                }
                $card->available_balance -= $validated['amount'];
            } else {
                $card->available_balance += $validated['amount'];
            }
            
            $card->save();

            $transaction = new Transaction($validated);
            $transaction->user_id = Auth::id();
            $transaction->save();
        });

        return response()->json(['message' => 'Transaction recorded successfully']);
    }

    public function index(Request $request)
    {
        $query = Auth::user()->transactions()->with('creditCard');

        if ($request->has('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        return response()->json($query->latest()->paginate(10));
    }
}