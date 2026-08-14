<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    public $timestamps = false;

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

    // RoomType <-> Amenities (many-to-many)
    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'room_type_amenities', 'room_type_id', 'amenity_id');
    }

    // RoomType <-> Equipments (many-to-many với quantity)
    public function equipments()
    {
        return $this->belongsToMany(Equipment::class, 'room_equipment', 'room_type_id', 'equipment_id')
            ->withPivot('quantity');
    }

    // RoomType có nhiều Images
    public function images()
    {
        return $this->hasMany(RoomTypeImage::class, 'room_type_id')->orderBy('order');
    }
}
