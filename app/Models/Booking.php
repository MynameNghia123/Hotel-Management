<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'booking_date',
        'checked_in_at',
        'checked_out_at',
        'staff_id',
        'total_service_amount',
        'total_room_amount',
        'surcharge_amount',
        'final_amount',
        'status',
    ];

    protected $casts = [
        'booking_date' => 'datetime',
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
        'total_service_amount' => 'float',
        'total_room_amount' => 'float',
        'surcharge_amount' => 'float',
        'final_amount' => 'float',
    ];

    /**
     * Relationship: Booking belongs to Customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Relationship: Booking has many BookingDetails
     */
    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class);
    }

    /**
     * Relationship: Booking belongs to Staff
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    /**
     * Relationship: Booking has many Payments
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
