<?php

namespace App\Repositories\Filters;

class EquipmentFilter
{
    public static function apply($query, array $filters = [])
    {
        // Search by name
        if (! empty($filters['search'])) {
            $searchTerm = '%'.$filters['search'].'%';
            $query->where('name', 'like', $searchTerm);
        }

        // Filter by category
        if (! empty($filters['category'])) {
            $query->where('equipment_category_id', $filters['category']);
        }

        return $query;
    }
}
