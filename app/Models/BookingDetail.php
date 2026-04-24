<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    use HasFactory;

    protected $table = 'booking_details';

    public $timestamps = false;

    protected $fillable = [
        'room_id',
        'booking_id',
        'checkin_date',
        'checkout_date',
        'hourly_price',
        'daily_price',
        'service_amount',
        'surcharge_amount',
    ];

    protected $casts = [
        'checkin_date' => 'datetime',
        'checkout_date' => 'datetime',
        'hourly_price' => 'float',
        'daily_price' => 'float',
        'service_amount' => 'float',
        'surcharge_amount' => 'float',
    ];

    /**
     * Relationship: BookingDetail belongs to Booking
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Relationship: BookingDetail belongs to Room
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
