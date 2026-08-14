<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Query\Builder;

class StaffFilter
{
    /**
     * Apply filters to the query builder
     */
    public static function apply($query, array $filters = [])
    {
        // Lọc theo search - tìm kiếm trong cả id, và tên (gộp first_name + last_name)
        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)  // Tìm id chính xác
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"]);  // Gộp first_name + last_name
            });
        }

        // Lọc theo role_id - sử dụng where= (khớp chính xác)
        if (! empty($filters['role_id'])) {
            $query->where('role_id', $filters['role_id']);
        }

        return $query;
    }
}
