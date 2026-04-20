<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\ServiceGroupRepositoryInterface;
use App\Services\Contracts\ServiceGroupServiceInterface;

class ServiceGroupService implements ServiceGroupServiceInterface
{
    public function __construct(
        private readonly ServiceGroupRepositoryInterface $serviceGroupRepository
    ) {}

    public function getAll()
    {
        return $this->serviceGroupRepository->getAll();
    }

    public function create(array $data)
    {
        return $this->serviceGroupRepository->create($data);
    }

    public function findById($id)
    {
        return $this->serviceGroupRepository->findById($id);
    }

    public function update($id, array $data)
    {
        return $this->serviceGroupRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->serviceGroupRepository->delete($id);
    }
    public function getPaginated(array $filters = [], $perPage = 10)
    {
        return $this->serviceGroupRepository->getPaginated($filters, $perPage);
    }
}
