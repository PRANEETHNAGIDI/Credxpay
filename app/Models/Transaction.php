<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'amount',
        'type',
        'description',
        'merchant_name',
        'category',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creditCard()
    {
        return $this->belongsTo(CreditCard::class);
    }
}