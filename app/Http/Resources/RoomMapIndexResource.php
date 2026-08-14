<?php

namespace App\Http\Resources;

use App\Enums\RoomStatus;
use App\Services\Contracts\BookingServiceInterface;
use App\Services\Contracts\CustomerServiceInterface;
use App\Services\Contracts\RoomTypeServiceInterface;
use Illuminate\Support\Collection;

class RoomMapIndexResource
{
    public function __construct(
        protected RoomTypeServiceInterface $roomTypeService,
        protected CustomerServiceInterface $customerService,
        protected BookingServiceInterface $bookingService,
    ) {}

    public function toArray(
        Collection $rooms,
        Collection $floors,
        array $statusCounts,
        array $filters
    ): array {
        $statusMeta = $this->buildStatusMeta();
        $groupBy = $this->determineGroupBy($filters);
        $buildRoomCards = fn ($groupRooms) => RoomMapResource::collection($groupRooms)->resolve();

        $groups = $groupBy === 'room_type'
            ? $this->buildGroupsByRoomType($rooms, $buildRoomCards)
            : $this->buildGroupsByFloor($rooms, $floors, $buildRoomCards);

        return [
            'rooms' => $rooms,
            'roomStatusCounts' => $statusCounts,
            'floors' => $floors,
            'totalRooms' => array_sum($statusCounts),
            'activeStatus' => $filters['status'] ?? null,
            'statusMeta' => $statusMeta,
            'groupBy' => $groupBy,
            'groups' => $groups,
            'filtersWithoutStatus' => $this->removeFilterKey($filters, 'status'),
            'filtersWithoutSearch' => $this->removeFilterKey($filters, 'search'),
            'filtersWithoutDate' => $this->removeFilterKeys($filters, ['date_from', 'date_to']),
            'roomTypes' => $this->roomTypeService->getAll(),
            'customers' => $this->customerService->getAll(),
            'recentBookings' => $this->bookingService->getPaginated([], 5),
            'filters' => $filters,
        ];
    }

    private function buildStatusMeta(): array
    {
        return collect(RoomStatus::cases())
            ->mapWithKeys(fn (RoomStatus $status) => [
                $status->value => [
                    'label' => $status->label(),
                    'badge' => $status->badgeColor(),
                ],
            ])
            ->all();
    }

    private function determineGroupBy(array $filters): string
    {
        return ($filters['group_by'] ?? 'floor') === 'room_type' ? 'room_type' : 'floor';
    }

    private function removeFilterKey(array $filters, string $key): array
    {
        unset($filters[$key]);

        return $filters;
    }

    private function removeFilterKeys(array $filters, array $keys): array
    {
        foreach ($keys as $key) {
            unset($filters[$key]);
        }

        return $filters;
    }

    private function buildGroupsByRoomType(Collection $rooms, callable $buildRoomCards): array
    {
        $roomsByRoomType = $rooms->groupBy('room_type_id');
        $roomTypes = $this->roomTypeService->getAll()->sortBy('name', SORT_NATURAL)->values();

        return $this->buildGroupsFromEntities($roomsByRoomType, $roomTypes, $buildRoomCards);
    }

    private function buildGroupsByFloor(Collection $rooms, Collection $floors, callable $buildRoomCards): array
    {
        $roomsByFloor = $rooms->groupBy('floor_id');

        return $this->buildGroupsFromEntities($roomsByFloor, $floors, $buildRoomCards);
    }

    private function buildGroupsFromEntities($roomsByEntityId, $entities, callable $buildRoomCards): array
    {
        $groups = [];

        foreach ($entities as $entity) {
            $groupRooms = ($roomsByEntityId->get($entity->id) ?? collect())
                ->sortBy('name', SORT_NATURAL)
                ->values();

            if ($groupRooms->isEmpty()) {
                continue;
            }

            $groups[] = [
                'id' => $entity->id,
                'name' => strtoupper((string) $entity->name),
                'count' => $groupRooms->count(),
                'rooms' => $buildRoomCards($groupRooms),
            ];
        }

        return $groups;
    }
}
