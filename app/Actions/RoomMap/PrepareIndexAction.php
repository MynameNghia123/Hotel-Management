<?php

namespace App\Actions\RoomMap;

use App\Enums\RoomStatus;
use App\Http\Resources\RoomMapIndexResource;
use App\Repositories\Contracts\RoomMapRepositoryInterface;
use Illuminate\Support\Collection;

class PrepareIndexAction
{
    public function __construct(
        protected RoomMapRepositoryInterface $roomMapRepository,
        protected SyncRoomStatusAction $syncRoomStatusAction,
        protected RoomMapIndexResource $roomMapIndexResource,
    ) {}

    public function execute(array $filters = []): array
    {
        $filters = $this->normalizeDateFilters($filters);

        $syncFilters = $this->removeFilterKeys($filters, ['status', 'date_from', 'date_to']);
        $roomsForStatusSync = $this->roomMapRepository->getFilteredRooms($syncFilters);
        $this->syncRoomStatusAction->execute($roomsForStatusSync);

        $rooms = $this->roomMapRepository->getFilteredRooms($this->removeFilterKeys($filters, ['status']));
        $statusCounts = $this->calculateStatusCounts($rooms);
        $rooms = $this->applyStatusFilter($rooms, $filters['status'] ?? null);

        $floors = $this->roomMapRepository->getAllFloors();

        return $this->roomMapIndexResource->toArray($rooms, $floors, $statusCounts, $filters);
    }

    private function normalizeDateFilters(array $filters): array
    {
        $today = now()->toDateString();
        $filters['date_from'] = ! empty($filters['date_from']) ? $filters['date_from'] : $today;
        $filters['date_to'] = ! empty($filters['date_to']) ? $filters['date_to'] : $filters['date_from'];

        if ($filters['date_from'] > $filters['date_to']) {
            [$filters['date_from'], $filters['date_to']] = [$filters['date_to'], $filters['date_from']];
        }

        return $filters;
    }

    private function removeFilterKeys(array $filters, array $keys): array
    {
        foreach ($keys as $key) {
            unset($filters[$key]);
        }

        return $filters;
    }

    private function calculateStatusCounts(Collection $rooms): array
    {
        $rawCounts = $rooms
            ->map(fn ($room) => (string) ($room->getAttribute('room_map_status') ?: RoomStatus::EMPTY->value))
            ->countBy()
            ->all();

        $counts = [];
        foreach (RoomStatus::all() as $status) {
            $counts[$status->value] = (int) ($rawCounts[$status->value] ?? 0);
        }

        return $counts;
    }

    private function applyStatusFilter(Collection $rooms, ?string $status): Collection
    {
        if (empty($status)) {
            return $rooms;
        }

        return $rooms
            ->filter(fn ($room) => (string) $room->getAttribute('room_map_status') === $status)
            ->values();
    }
}
