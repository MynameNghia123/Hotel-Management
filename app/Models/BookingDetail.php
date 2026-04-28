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
        'room_amount',
        'service_amount',
        'surcharge_amount',
        'payment_status',
        'paid_at',
    ];

    protected $casts = [
        'checkin_date' => 'datetime',
        'checkout_date' => 'datetime',
        'hourly_price' => 'float',
        'daily_price' => 'float',
        'room_amount' => 'float',
        'service_amount' => 'float',
        'surcharge_amount' => 'float',
        'paid_at' => 'datetime',
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

    /**
     * Relationship: BookingDetail has many ServiceUsages
     */
    public function serviceUsages()
    {
        return $this->hasMany(ServiceUsage::class);
    }

    public function getFormattedCheckinAtAttribute(): ?string
    {
        return $this->formatDateTime($this->checkin_date);
    }

    public function getFormattedCheckoutAtAttribute(): ?string
    {
        return $this->formatDateTime($this->checkout_date);
    }

    public function getFormattedPaidAtAttribute(): ?string
    {
        return $this->formatDateTime($this->paid_at);
    }

    private function formatDateTime($dateTimeValue): ?string
    {
        return $dateTimeValue?->format('d/m/Y H:i');
    }
}
