<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // Fillable attributes that can be mass-assigned
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'profile_image',
    ];

    // Hidden attributes that will be hidden from arrays or JSON responses
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Accessor to get the profile image URL
    public function getProfileImageUrlAttribute()
    {
        if ($this->profile_image) {
            return asset('storage/' . $this->profile_image);
        }
        return asset('images/default-avatar.png');
    }

    // Relationship with CreditCard model (One-to-Many)
    public function creditCards()
    {
        return $this->hasMany(CreditCard::class);
    }

    // Relationship with Transaction model (One-to-Many)
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
