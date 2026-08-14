<?php

namespace App\Actions\RoomMap;

use App\Enums\RoomStatus;
use App\Repositories\Contracts\RoomMapRepositoryInterface;

class UpdateRoomStatusAction
{
    public function __construct(
        protected RoomMapRepositoryInterface $roomMapRepository,
    ) {}

    public function execute(int $roomId, string $status): void
    {
        $room = $this->roomMapRepository->findRoomById($roomId);
        $newStatus = RoomStatus::tryFrom($status);

        if (! $room || ! $newStatus) {
            throw new \RuntimeException('Trạng thái phòng không hợp lệ.');
        }

        $currentStatus = $room->status instanceof RoomStatus
            ? $room->status
            : RoomStatus::tryFrom((string) $room->status);

        $this->validateStatusTransition($currentStatus, $newStatus);
        $this->roomMapRepository->updateRoomStatusById($roomId, $newStatus->value);
    }

    private function validateStatusTransition($currentStatus, $newStatus): void
    {
        $allowedTransitions = [
            RoomStatus::EMPTY->value => [RoomStatus::MAINTENANCE],
            RoomStatus::MAINTENANCE->value => [RoomStatus::EMPTY],
        ];

        if (! $currentStatus || ! in_array($newStatus, $allowedTransitions[$currentStatus->value] ?? [], true)) {
            throw new \RuntimeException('Chỉ được chuyển giữa trạng thái Trống và Đang sửa chữa.');
        }
    }
}
