<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\SearchRepositoryInterface;
use App\Services\Contracts\SearchServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class SearchService implements SearchServiceInterface
{
    public function __construct(
        private readonly SearchRepositoryInterface $searchRepository
    ) {
    }

    public function prepareSearchData(array $params): array
    {
        $today = now()->startOfDay();
        $checkIn = $this->parseDate($params['checkin'] ?? null, $today);
        $checkOut = $this->parseDate($params['checkout'] ?? null, $checkIn->copy()->addDay());

        if ($checkOut->lessThanOrEqualTo($checkIn)) {
            $checkOut = $checkIn->copy()->addDay();
        }

        [$adults, $children, $rooms] = $this->resolveGuestBreakdown($params);
        $guests = $this->resolveGuestsFromBreakdown($params, $adults, $children);

        $criteria = [
            'checkin' => $checkIn,
            'checkout' => $checkOut,
            'adults' => $adults,
            'children' => $children,
            'rooms' => $rooms,
            'room_type' => isset($params['room_type']) && is_numeric($params['room_type'])
                ? (int) $params['room_type']
                : null,
            'strict_room_count' => true,
        ];

        $matchedRoomTypes = $this->searchRepository->searchRoomTypes($criteria);

        if ($matchedRoomTypes->isEmpty() && $criteria['rooms'] > 1) {
            $criteria['strict_room_count'] = false;
            $matchedRoomTypes = $this->searchRepository->searchRoomTypes($criteria);
        }

        $availableRoomTypes = $this->mapRoomTypesForSearchView(
            $this->hydrateRoomTypeCards($matchedRoomTypes, $criteria)
        );

        return [
            'availableRoomTypes' => $availableRoomTypes,
            'checkin' => $checkIn->toDateString(),
            'checkout' => $checkOut->toDateString(),
            'checkinLabel' => $checkIn->format('d/m'),
            'checkoutLabel' => $checkOut->format('d/m'),
            'guests' => $guests,
        ];
    }

    private function parseDate(?string $value, Carbon $fallback): Carbon
    {
        if (!$value) {
            return $fallback->copy();
        }

        try {
            return Carbon::parse($value)->startOfDay();
        } catch (\Throwable) {
            return $fallback->copy();
        }
    }

    private function hydrateRoomTypeCards(Collection $roomTypes, array $criteria): Collection
    {
        $requestedRooms = (int) $criteria['rooms'];
        $selectedRoomTypeId = $criteria['room_type'] ? (int) $criteria['room_type'] : null;

        return $roomTypes->values()->map(function ($roomType, $index) use ($requestedRooms, $selectedRoomTypeId) {
            $isPreferred = $selectedRoomTypeId
                ? (int) $roomType->id === $selectedRoomTypeId
                : $index === 0;

            $defaultQuantity = $isPreferred
                ? min((int) $roomType->available_rooms_count, $requestedRooms)
                : 0;

            $roomType->default_selected_quantity = max(0, $defaultQuantity);
            $roomType->is_preferred = $isPreferred;

            return $roomType;
        });
    }

    private function resolveGuestBreakdown(array $params): array
    {
        $hasDetailedGuests = isset($params['adults']) || isset($params['children']) || isset($params['rooms']);

        if ($hasDetailedGuests) {
            return [
                isset($params['adults']) && is_numeric($params['adults']) ? max(1, (int) $params['adults']) : 2,
                isset($params['children']) && is_numeric($params['children']) ? max(0, (int) $params['children']) : 0,
                isset($params['rooms']) && is_numeric($params['rooms']) ? max(1, (int) $params['rooms']) : 1,
            ];
        }

        $guests = isset($params['guests']) && is_numeric($params['guests']) ? max(1, (int) $params['guests']) : 2;

        return [$guests, 0, 1];
    }

    private function resolveGuestsFromBreakdown(array $params, int $adults, int $children): int
    {
        if (isset($params['guests']) && is_numeric($params['guests'])) {
            return max(1, (int) $params['guests']);
        }

        return max(1, $adults + $children);
    }

    private function mapRoomTypesForSearchView(Collection $roomTypes): Collection
    {
        return $roomTypes->values()->map(function ($roomType) {
            $roomType->setAttribute(
                'available_count',
                (int) ($roomType->available_rooms_count ?? 0)
            );

            return $roomType;
        });
    }
}
