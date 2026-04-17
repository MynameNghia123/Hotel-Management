<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\ServiceRepositoryInterface;
use App\Services\Contracts\ServiceServiceInterface;

class ServiceService implements ServiceServiceInterface
{
    public function __construct(
        private readonly ServiceRepositoryInterface $serviceRepository
    ) {}

    public function getAll()
    {
        return $this->serviceRepository->getAll();
    }

    public function create(array $data)
    {
        return $this->serviceRepository->create($data);
    }

    public function findById($id)
    {
        return $this->serviceRepository->findById($id);
    }

    public function update($id, array $data)
    {
        return $this->serviceRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->serviceRepository->delete($id);
    }

    public function getPaginated(array $filters = [], $perPage = 10)
    {
        return $this->serviceRepository->getPaginated($filters, $perPage);
    }
}
