<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\ServiceGroupRepositoryInterface;
use App\Services\Contracts\ServiceGroupServiceInterface;

class ServiceGroupService implements ServiceGroupServiceInterface
{
    public function __construct(
        private readonly ServiceGroupRepositoryInterface $serviceGroupRepository
    ) {}

    public function getAllServiceGroups()
    {
        return $this->serviceGroupRepository->getAll();
    }

    public function createServiceGroup(array $data)
    {
        return $this->serviceGroupRepository->create($data);
    }

    public function getServiceGroupById($id)
    {
        return $this->serviceGroupRepository->findById($id);
    }

    public function updateServiceGroup($id, array $data)
    {
        return $this->serviceGroupRepository->update($id, $data);
    }

    public function deleteServiceGroup($id)
    {
        return $this->serviceGroupRepository->delete($id);
    }
}
