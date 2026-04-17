<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
       'id',
       'first_name',
       'last_name',
       'phone_number',
       'country',
       'email'
    ];

    /**
     * Relationship: Customer has many Bookings
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
