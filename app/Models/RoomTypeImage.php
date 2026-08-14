<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class RoomTypeImage extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'room_type_id',
        'image_url',
        'order',
    ];

    /**
     * Normalize image_url to always return a valid relative path.
     * Handles 3 formats in DB:
     *   1) Public image path: "/img/room-deluxe.png"
     *   2) Old absolute: "http://localhost/storage/room-types/xxx.jpg"
     *   3) Storage relative: "/storage/room-types/xxx.jpg"
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (! $value) {
                    return $value;
                }

                // Already a proper relative path starting with /storage/
                if (str_starts_with($value, '/storage/')) {
                    return $value;
                }

                // Absolute URL containing /storage/ - extract the relative part
                if (str_contains($value, '/storage/')) {
                    return '/storage/'.substr($value, strpos($value, '/storage/') + strlen('/storage/'));
                }

                // Seed data or other relative path without /storage/ prefix
                // These are in public/ directory
                return '/'.ltrim($value, '/');
            },
        );
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }
}
