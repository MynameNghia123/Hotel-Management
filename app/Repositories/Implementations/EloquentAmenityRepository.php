<?php

namespace App\Repositories\Implementations;

use App\Models\Amenity;
use App\Repositories\Contracts\AmenityRepositoryInterface;

class EloquentAmenityRepository implements AmenityRepositoryInterface
{
    protected $model;

    public function __construct(Amenity $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $record = $this->findById($id);
        $record->update($data);

        return $record;
    }

    public function delete($id)
    {
        $record = $this->findById($id);
        $record->roomTypes()->detach();

        return $record->delete();
    }

    public function getPaginated(array $filters = [], $perPage = 5)
    {
        $query = $this->model->query();

        if (isset($filters['name'])) {
            $query->where('name', 'like', '%'.$filters['name'].'%');
        }

        return $query->paginate($perPage);
    }
}
