<?php

namespace App\Repositories\Filters;

class RoomMapFilter
{
    public static function apply($query, array $filters = [])
    {
        if (!empty($filters['search'])) {
            $search = trim($filters['search']);
            $query->where(function ($q) use ($search) {
                if (is_numeric($search)) {
                    $q->where('id', (int) $search);
                }

                $q->orWhere('name', 'like', "%{$search}%")
                    ->orWhereHas('roomType', function ($roomTypeQuery) use ($search) {
                        $roomTypeQuery->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('floor', function ($floorQuery) use ($search) {
                        $floorQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['floor_id'])) {
            $query->where('floor_id', $filters['floor_id']);
        }

        if (!empty($filters['room_type_id'])) {
            $query->where('room_type_id', $filters['room_type_id']);
        }

        return $query;
    }
}
