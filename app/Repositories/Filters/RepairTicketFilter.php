<?php

namespace App\Repositories\Filters;

class RepairTicketFilter
{
    /**
     * Apply filters to the repair ticket query
     */
    public static function apply($query, array $filters = [])
    {
        // Filter by status
        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter by room ID
        if (! empty($filters['room_id'])) {
            $query->where('room_id', $filters['room_id']);
        }

        // Search by issue description
        if (! empty($filters['search'])) {
            $query->where('issue_description', 'like', '%'.$filters['search'].'%');
        }

        return $query;
    }
}
