<?php

namespace App\Repositories\Implementations;

use App\Models\RoomType;
use App\Repositories\Contracts\RoomTypeRepositoryInterface;
use App\Repositories\Filters\RoomTypeFilter;

class EloquentRoomTypeRepository implements RoomTypeRepositoryInterface
{
    public function __construct(
        protected RoomType $model
    ) {}

    /**
     * Get all room types
     */
    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * Get all room types with room count
     */
    public function getAllWithRoomCount()
    {
        return $this->model->withCount('rooms')->get();
    }

    /**
     * Create a new room type
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Find room type by ID
     */
    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Find room type with all details
     */
    public function findWithDetails($id)
    {
        return $this->model
            ->with(['amenities', 'equipments', 'images'])
            ->findOrFail($id);
    }

    /**
     * Update room type
     */
    public function update($id, array $data)
    {
        $record = $this->findById($id);
        $record->update($data);
        return $record;
    }

    /**
     * Delete room type
     */
    public function delete($id)
    {
        $record = $this->findById($id);
        return $record->delete();
    }

    /**
     * Get paginated room types
     */
    public function getPaginated(array $filters = [], $perPage = 5)
    {
        $query = $this->model->query()->withCount('rooms');
        $query = RoomTypeFilter::apply($query, $filters);
        return $query->paginate($perPage);
    }
}
