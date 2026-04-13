<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\ServiceRepositoryInterface;
use App\Services\Contracts\ServiceServiceInterface;

class ServiceService implements ServiceServiceInterface
{
    public function __construct(
        private readonly ServiceRepositoryInterface $serviceRepository
    ) {}

    public function getAllServices()
    {
        return $this->serviceRepository->getAll();
    }

    public function createService(array $data)
    {
        return $this->serviceRepository->create($data);
    }

    public function getServiceById($id)
    {
        return $this->serviceRepository->findById($id);
    }

    public function updateService($id, array $data)
    {
        return $this->serviceRepository->update($id, $data);
    }

    public function deleteService($id)
    {
        return $this->serviceRepository->delete($id);
    }
}
