<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\RoomRepositoryInterface;
use App\Services\Contracts\RoomServiceInterface;

class RoomService implements RoomServiceInterface
{
    protected $roomRepository;

    public function __construct(RoomRepositoryInterface $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    // BaseServiceInterface methods
    public function create(array $data)
    {
        return $this->roomRepository->create($data);
    }

    public function findById($id)
    {
        return $this->roomRepository->findById($id);
    }

    public function update($id, array $data)
    {
        return $this->roomRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->roomRepository->delete($id);
    }
    public function getPaginated(array $filters = [], $perPage = 10)
    {
        throw new \Exception('Not implemented');
    }
    public function getAll()
    {
        return $this->roomRepository->getAll();
    }

    // Domain-specific methods
    public function getByRoomType($roomTypeId)
    {
        return $this->roomRepository->getByRoomType($roomTypeId);
    }

    public function getAvailableRooms($checkInDate, $checkOutDate)
    {
        return $this->roomRepository->getAvailableRooms($checkInDate, $checkOutDate);
    }
}
