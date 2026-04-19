<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\RoomTypeRepositoryInterface;
use App\Services\Contracts\RoomTypeServiceInterface;

class RoomTypeService implements RoomTypeServiceInterface
{
    public function __construct(
        protected RoomTypeRepositoryInterface $roomTypeRepository
    ) {}

    /**
     * Get all room types
     */
    public function getAll()
    {
        return $this->roomTypeRepository->getAll();
    }

    /**
     * Get all room types with room count
     */
    public function getAllWithRoomCount()
    {
        return $this->roomTypeRepository->getAllWithRoomCount();
    }

    /**
     * Find room type by ID
     */
    public function findById($id)
    {
        return $this->roomTypeRepository->findById($id);
    }

    /**
     * Find room type with all details
     */
    public function findWithDetails($id)
    {
        return $this->roomTypeRepository->findWithDetails($id);
    }

    /**
     * Create a new room type
     */
    public function create(array $data)
    {
        return $this->roomTypeRepository->create($data);
    }

    /**
     * Update room type
     */
    public function update($id, array $data)
    {
        return $this->roomTypeRepository->update($id, $data);
    }

    /**
     * Delete room type
     */
    public function delete($id)
    {
        return $this->roomTypeRepository->delete($id);
    }

    /**
     * Get paginated room types
     */
    public function getPaginated(array $filters = [], $perPage = 10)
    {
        return $this->roomTypeRepository->getPaginated($filters, $perPage);
    }
}
