<?php

namespace App\Services\Contracts;

interface ServiceGroupServiceInterface
{
    public function getAllServiceGroups();
    public function getServiceGroupById($id);
    public function createServiceGroup(array $data);
    public function updateServiceGroup($id, array $data);
    public function deleteServiceGroup($id);
}
