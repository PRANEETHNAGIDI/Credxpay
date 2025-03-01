<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CreditCard extends Model
{
    protected $fillable = [
        'card_number',
        'card_holder_name',
        'expiration_month',
        'expiration_year',
        'credit_limit',
        'available_balance',
        'card_type',
        'card_color',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($card) {
            $card->cred_id = 'CRED-' . strtoupper(Str::random(8));
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getMaskedNumberAttribute()
    {
        return '**** **** **** ' . substr($this->card_number, -4);
    }

    public function getSpendingProgressAttribute()
    {
        $spent = $this->credit_limit - $this->available_balance;
        return ($spent / $this->credit_limit) * 100;
    }
}