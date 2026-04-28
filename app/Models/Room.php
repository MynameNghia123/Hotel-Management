<?php

namespace App\Models;

use App\Enums\RoomStatus;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public $timestamps = false; // Bảng không có created_at/updated_at

    protected $fillable = [
        'room_type_id',
        'floor_id',
        'name',
        'status',
    ];

    protected $casts = [
        'status' => RoomStatus::class,
    ];

    // Mỗi Room thuộc 1 RoomType
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    // Mỗi Room thuộc 1 Floor
    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    // 1 Room có nhiều BookingDetail
    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class);
    }

    public function getIsEmptyAttribute(): bool
    {
        return $this->status === RoomStatus::EMPTY;
    }

    public function getShowIndicatorAttribute(): bool
    {
        return !$this->is_empty;
    }
}
