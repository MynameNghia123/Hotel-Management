<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    public $timestamps = false; // Bảng không có created_at/updated_at

    protected $fillable = [
        'name',
    ];

    // 1 Floor có nhiều Room
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
