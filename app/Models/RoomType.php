<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    public $timestamps = false; // Bảng không có created_at/updated_at

    protected $fillable = [
        'name',
        'code',
        'adult_quantity',
        'child_quantity',
        'single_bed_quantity',
        'double_bed_quantity',
        'width',
        'height',
        'hourly_price',
        'daily_price',
        'is_active',
        'description',
    ];

    // 1 RoomType có nhiều Room
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
