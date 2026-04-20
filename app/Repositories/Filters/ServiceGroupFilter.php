<?php
namespace App\Repositories\Filters;

class ServiceGroupFilter
{
    public static function apply($query, array $filters = [])
    {
        if (!empty($filters['search'])){
            $search = $filters['search'];
            $query->where(function($q) use ($search){
                if (is_numeric($search)) {
                    $q->where('id', (int)$search);
                }
                $q->orwhere('service_name', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['group_id'])){
            $query->where('group_id', $filters['group_id']);
        }
        return $query;

    }
}