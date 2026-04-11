<?php

namespace App\Models;

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
}
