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

    public function getAllRooms()
    {
        return $this->roomRepository->getAll();
    }

    public function createRoom(array $data)
    {
        return $this->roomRepository->create($data);
    }

    public function findRoomById($id)
    {
        return $this->roomRepository->findById($id);
    }

    public function updateRoom($id, array $data)
    {
        return $this->roomRepository->update($id, $data);
    }

    public function deleteRoom($id)
    {
        return $this->roomRepository->delete($id);
    }
}
