<?php

namespace App\Http\Controllers;

use App\Models\CreditCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CreditCardController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_number' => 'required|string|size:16',
            'card_holder_name' => 'required|string|max:255',
            'expiration_month' => 'required|string|size:2',
            'expiration_year' => 'required|string|size:2',
            'cvv' => 'required|string|size:3',
            'credit_limit' => 'required|numeric|min:1000|max:1000000',
            'card_type' => 'required|in:visa,mastercard,amex',
            'card_color' => 'required|in:blue,purple,green,red'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create the credit card with masked number
        $card = new CreditCard([
            'card_holder_name' => $request->card_holder_name,
            'card_number' => substr($request->card_number, -4), // Only store last 4 digits
            'expiration_month' => $request->expiration_month,
            'expiration_year' => $request->expiration_year,
            'credit_limit' => $request->credit_limit,
            'available_balance' => $request->credit_limit,
            'card_type' => $request->card_type,
            'card_color' => $request->card_color
        ]);

        $card->user_id = Auth::id();
        $card->save();

        return response()->json([
            'message' => 'Card added successfully',
            'card' => $card
        ]);
    }

    public function index()
    {
        $cards = Auth::user()->creditCards()
            ->select('id', 'card_number', 'card_holder_name', 'expiration_month', 
                    'expiration_year', 'credit_limit', 'available_balance', 
                    'card_type', 'card_color', 'cred_id')
            ->get();

        return response()->json($cards);
    }

    public function destroy($id)
    {
        $card = Auth::user()->creditCards()->findOrFail($id);
        $card->delete();
        
        return response()->json(['message' => 'Card removed successfully']);
    }
}