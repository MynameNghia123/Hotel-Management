<?php

namespace App\Repositories\Filters;

use Illuminate\Database\Query\Builder;

class CustomerFilter
{
    public static function apply($query, array $filters = [])
    {
        // Search by name, email, phone number
        if (!empty($filters['search'])) {
            $searchTerm = '%' . $filters['search'] . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", [$searchTerm])
                  ->orWhere('first_name', 'like', $searchTerm)
                  ->orWhere('last_name', 'like', $searchTerm)
                  ->orWhere('email', 'like', $searchTerm)
                  ->orWhere('phone_number', 'like', $searchTerm);
            });
        }

        // Filter by country
        if (!empty($filters['country'])) {
            $query->where('country', $filters['country']);
        }

        return $query;
    }
}
