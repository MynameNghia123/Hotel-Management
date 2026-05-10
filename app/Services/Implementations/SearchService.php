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

        $criteria = [
            'checkin' => $checkIn,
            'checkout' => $checkOut,
            'adults' => max(1, (int) ($params['adults'] ?? 2)),
            'children' => max(0, (int) ($params['children'] ?? 0)),
            'rooms' => max(1, (int) ($params['rooms'] ?? 1)),
            'room_type' => isset($params['room_type']) && is_numeric($params['room_type']) ? (int) $params['room_type'] : null,
            'strict_room_count' => true,
        ];

        $matchedRoomTypes = $this->searchRepository->searchRoomTypes($criteria);
        $isRelaxedResult = false;

        if ($matchedRoomTypes->isEmpty() && $criteria['rooms'] > 1) {
            $isRelaxedResult = true;
            $criteria['strict_room_count'] = false;
            $matchedRoomTypes = $this->searchRepository->searchRoomTypes($criteria);
        }

        $roomTypes = $this->hydrateRoomTypeCards($matchedRoomTypes, $criteria);
        $nights = max(1, $checkIn->diffInDays($checkOut));

        return [
            'criteria' => [
                'checkin' => $checkIn->toDateString(),
                'checkout' => $checkOut->toDateString(),
                'adults' => $criteria['adults'],
                'children' => $criteria['children'],
                'rooms' => $criteria['rooms'],
                'room_type' => $criteria['room_type'],
            ],
            'searchSummary' => [
                'checkin_label' => $checkIn->format('d/m/Y'),
                'checkout_label' => $checkOut->format('d/m/Y'),
                'nights' => $nights,
                'requested_guests_label' => $criteria['adults'] . ' người lớn, ' . $criteria['children'] . ' trẻ em',
                'requested_rooms_label' => $criteria['rooms'] . ' phòng',
                'results_count' => $roomTypes->count(),
                'is_relaxed_result' => $isRelaxedResult,
            ],
            'roomTypes' => $roomTypes,
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
}
