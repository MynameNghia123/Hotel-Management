<?php

namespace App\Repositories\Implementations;

use App\Models\RoomType;
use App\Repositories\Contracts\HomeRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class EloquentHomeRepository implements HomeRepositoryInterface
{
    public function __construct(
        private readonly RoomType $roomTypeModel
    ) {
    }

    public function getFeaturedRoomTypes(int $limit = 3): Collection
    {
        $baseQuery = $this->buildFeaturedQuery();

        $activeRoomTypes = (clone $baseQuery)
            ->where('is_active', true)
            ->limit($limit)
            ->get();

        if ($activeRoomTypes->isNotEmpty()) {
            return $activeRoomTypes;
        }

        return $baseQuery->limit($limit)->get();
    }

    private function buildFeaturedQuery(): Builder
    {
        return $this->roomTypeModel
            ->newQuery()
            ->with([
                'images' => fn ($query) => $query->orderBy('order'),
            ])
            ->orderByDesc('daily_price')
            ->orderBy('name');
    }
}
