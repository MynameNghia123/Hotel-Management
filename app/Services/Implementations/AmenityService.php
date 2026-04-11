<?php

namespace App\Services\Implementations;

use App\Services\Contracts\AmenityServiceInterface;
use App\Repositories\Contracts\AmenityRepositoryInterface;

class AmenityService implements AmenityServiceInterface
{
    public function __construct(
        private readonly AmenityRepositoryInterface $amenityRepository
    ) {}

    public function getAllAmenities()
    {
        return $this->amenityRepository->getAll();
    }

    public function createAmenity(array $data)
    {
        return $this->amenityRepository->create($data);
    }

    public function getAmenityById($id)
    {
        return $this->amenityRepository->findById($id);
    }

    public function updateAmenity($id, array $data)
    {
        return $this->amenityRepository->update($id, $data);
    }

    public function deleteAmenity($id)
    {
        return $this->amenityRepository->delete($id);
    }
}
