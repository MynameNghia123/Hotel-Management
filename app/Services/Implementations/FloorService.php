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

    public function getAll()
    {
        return $this->floorRepository->getAll();
    }

    public function create(array $data)
    {
        return $this->floorRepository->create($data);
    }

    public function findById($id)
    {
        return $this->floorRepository->findById($id);
    }

    public function update($id, array $data)
    {
        return $this->floorRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->floorRepository->delete($id);
    }

    public function getPaginated(array $filters = [], $perPage = 10)
    {
        throw new \Exception('Not implemented');
    }
}
