<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\RoomTypeRepositoryInterface;
use App\Services\Contracts\RoomTypeServiceInterface;

class RoomTypeService implements RoomTypeServiceInterface
{
    protected $roomTypeRepository;

    public function __construct(RoomTypeRepositoryInterface $roomTypeRepository)
    {
        $this->roomTypeRepository = $roomTypeRepository;
    }

    public function getAllWithRoomCount()
    {
        return $this->roomTypeRepository->getAllWithRoomCount();
    }

    public function findById($id)
    {
        return $this->roomTypeRepository->findById($id);
    }

    public function create(array $data)
    {
        return $this->roomTypeRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->roomTypeRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->roomTypeRepository->delete($id);
    }
}
