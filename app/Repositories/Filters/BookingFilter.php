<?php

namespace App\Repositories\Filters;

class BookingFilter
{
    public static function apply($query, array $filters = [])
    {
        // dd($filters);
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                if (is_numeric($search)) {
                    $q->where('id', (int)$search);
                }
                $q->orWhereHas('customer', function($q) use ($search) {
                    $like = "%{$search}%";

                    $q->where('email', 'like', $like)
                      ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", [$like])
                      ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", [$like]);
                });
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['customer_id'])) {
            $query->where('customer_id', $filters['customer_id']);
        }

        if (!empty($filters['date_from'])) {
            $query->where('check_in_date', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('check_out_date', '<=', $filters['date_to']);
        }

        return $query;
    }
}
