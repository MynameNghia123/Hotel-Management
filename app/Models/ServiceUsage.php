<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceUsage extends Model
{
    protected $table = 'service_usages';

    protected $fillable = [
        'booking_detail_id',
        'service_id',
        'quantity',
        'unit_price',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'float',
    ];

    public function bookingDetail()
    {
        return $this->belongsTo(BookingDetail::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
