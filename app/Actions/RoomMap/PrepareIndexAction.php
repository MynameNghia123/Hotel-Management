<?php

namespace App\Actions\RoomMap;

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
        $rooms = $this->roomMapRepository->getFilteredRooms($filters);
        $this->syncRoomStatusAction->execute($rooms);
        
        $floors = $this->roomMapRepository->getAllFloors();
        $statusCounts = $this->roomMapRepository->getRoomStatusCounts($filters);

        return $this->roomMapIndexResource->toArray($rooms, $floors, $statusCounts, $filters);
    }
}
