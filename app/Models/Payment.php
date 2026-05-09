<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'amount',
        'payment_method',
        'note',
        'transaction_code',
        'staff_id',
    ];

    /**
     * Relationship: Payment belongs to Booking
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
