<?php

namespace App\Repositories\Filters;

class RoomMapFilter
{
    public static function apply($query, array $filters = [])
    {
        if (! empty($filters['search'])) {
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

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['floor_id'])) {
            $query->where('floor_id', $filters['floor_id']);
        }

        if (! empty($filters['room_type_id'])) {
            $query->where('room_type_id', $filters['room_type_id']);
        }

        $dateFrom = $filters['date_from'] ?? null;
        $dateTo = $filters['date_to'] ?? null;

        if (! empty($dateFrom) || ! empty($dateTo)) {
            $start = ! empty($dateFrom) ? ($dateFrom.' 00:00:00') : '1970-01-01 00:00:00';
            $end = ! empty($dateTo) ? ($dateTo.' 23:59:59') : '2999-12-31 23:59:59';

            $query->whereHas('bookingDetails', function ($bookingDetailQuery) use ($start, $end) {
                $bookingDetailQuery
                    ->where('checkin_date', '<=', $end)
                    ->where('checkout_date', '>=', $start);
            });
        }

        return $query;
    }
}
