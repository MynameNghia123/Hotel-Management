<?php

namespace App\Repositories\Filters;

class RoleFilter
{
    /**
     * Apply filters to the query builder
     */
    public static function apply($query, array $filters = [])
    {
        // Lọc theo search - tìm kiếm theo tên role
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            // $query->where('name', 'like', "%{$search}%");
                $query->where(function($q) use ($search) {
                    $q->where('id', $search)  // Tìm id chính xác
                    ->orWhereRaw("name LIKE ?", ["%{$search}%"]);  // tim theo ten
                });
        }

        return $query;
    }
}
