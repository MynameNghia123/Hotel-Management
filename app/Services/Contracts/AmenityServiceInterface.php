<?php

namespace App\Services\Contracts;

interface AmenityServiceInterface
{
    public function getAllAmenities();
    public function createAmenity(array $data);
    public function getAmenityById($id);
    public function updateAmenity($id, array $data);
    public function deleteAmenity($id);
}
