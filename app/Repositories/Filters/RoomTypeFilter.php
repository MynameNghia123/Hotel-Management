<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Query\Builder;

class RoomTypeFilter
{
    /**
     * Apply filters to the query
     */
    public static function apply($query, array $filters = [])
    {
        // Search by name
        if (!empty($filters['search'])) {
            $searchTerm = '%' . $filters['search'] . '%';
            $query->where('name', 'like', $searchTerm);
        }

        // Filter by status (dùng !== '' vì "0" là giá trị hợp lệ, !empty("0") sẽ sai)
        if (isset($filters['is_active']) && $filters['is_active'] !== '') {
            $query->where('is_active', $filters['is_active']);
        }

        return $query;
    }
}
