<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\FloorRepositoryInterface;
use App\Services\Contracts\FloorServiceInterface;

class FloorService implements FloorServiceInterface
{
    protected $floorRepository;

    public function __construct(FloorRepositoryInterface $floorRepository)
    {
        $this->floorRepository = $floorRepository;
    }

    public function getAllFloors()
    {
        return $this->floorRepository->getAll();
    }

    public function createFloor(array $data)
    {
        return $this->floorRepository->create($data);
    }

    public function findFloorById($id)
    {
        return $this->floorRepository->findById($id);
    }

    public function updateFloor($id, array $data)
    {
        return $this->floorRepository->update($id, $data);
    }

    public function deleteFloor($id)
    {
        return $this->floorRepository->delete($id);
    }
}
