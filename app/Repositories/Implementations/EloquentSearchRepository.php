<?php

namespace App\Repositories\Implementations;

use App\Enums\BookingStatus;
use App\Enums\RoomStatus;
use App\Models\RoomType;
use App\Repositories\Contracts\SearchRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class EloquentSearchRepository implements SearchRepositoryInterface
{
    public function __construct(
        private readonly RoomType $roomTypeModel
    ) {}

    public function searchRoomTypes(array $criteria): Collection
    {
        /** @var Carbon $checkIn */
        $checkIn = $criteria['checkin'];
        /** @var Carbon $checkOut */
        $checkOut = $criteria['checkout'];

        $requestedAdults = max(1, (int) ($criteria['adults'] ?? 1));
        $requestedChildren = max(0, (int) ($criteria['children'] ?? 0));
        $requestedRooms = max(1, (int) ($criteria['rooms'] ?? 1));
        $strictRoomCount = (bool) ($criteria['strict_room_count'] ?? true);

        $requiredAdultsPerRoom = (int) ceil($requestedAdults / $requestedRooms);
        $requiredChildrenPerRoom = (int) ceil($requestedChildren / $requestedRooms);

        $availableRoomsCondition = function ($roomQuery) use ($checkIn, $checkOut) {
            $roomQuery
                ->where('status', '!=', RoomStatus::MAINTENANCE->value)
                ->whereDoesntHave('bookingDetails', function ($bookingDetailQuery) use ($checkIn, $checkOut) {
                    $bookingDetailQuery
                        ->where('checkin_date', '<', $checkOut->copy()->startOfDay())
                        ->where('checkout_date', '>', $checkIn->copy()->startOfDay())
                        ->whereHas('booking', function ($bookingQuery) {
                            $bookingQuery->whereNotIn('status', [
                                BookingStatus::CANCELLED->value,
                                BookingStatus::PAID->value,
                            ]);
                        });
                });
        };

        $query = $this->roomTypeModel
            ->newQuery()
            ->with([
                'images' => fn ($imageQuery) => $imageQuery->orderBy('order'),
                'amenities' => fn ($amenityQuery) => $amenityQuery->select('amenities.id', 'amenities.name', 'amenities.icon'),
            ])
            ->withCount([
                'rooms',
                'rooms as available_rooms_count' => $availableRoomsCondition,
            ])
            ->where('is_active', true)
            ->where('adult_quantity', '>=', $requiredAdultsPerRoom)
            ->where('child_quantity', '>=', $requiredChildrenPerRoom)
            ->orderByDesc('daily_price')
            ->orderBy('name');

        if ($strictRoomCount) {
            $query->whereHas('rooms', $availableRoomsCondition, '>=', $requestedRooms);
        } else {
            $query->whereHas('rooms', $availableRoomsCondition, '>', 0);
        }

        return $query->get();
    }
}
