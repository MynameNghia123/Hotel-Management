<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\AmenityRepositoryInterface;
use App\Services\Contracts\AmenityServiceInterface;

class AmenityService implements AmenityServiceInterface
{
    public function __construct(
        private readonly AmenityRepositoryInterface $amenityRepository
    ) {}

    public function getAll()
    {
        return $this->amenityRepository->getAll();
    }

    public function create(array $data)
    {
        return $this->amenityRepository->create($data);
    }

    public function findById($id)
    {
        return $this->amenityRepository->findById($id);
    }

    public function update($id, array $data)
    {
        return $this->amenityRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->amenityRepository->delete($id);
    }

    public function getPaginated(array $filters = [], $perPage = 10)
    {
        return $this->amenityRepository->getPaginated($filters, $perPage);
    }
}
