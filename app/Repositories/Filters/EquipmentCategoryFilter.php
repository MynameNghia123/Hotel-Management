<?php

namespace App\Repositories\Filters;

class EquipmentCategoryFilter
{
    public static function apply($query, array $filters = [])
    {
        // Search by name
        if (!empty($filters['search'])) {
            $searchTerm = '%' . $filters['search'] . '%';
            $query->where('name', 'like', $searchTerm);
        }

        return $query;
    }
}
