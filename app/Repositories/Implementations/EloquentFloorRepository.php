<?php

namespace App\Repositories\Implementations;

use App\Models\Floor;
use App\Repositories\Contracts\FloorRepositoryInterface;

class EloquentFloorRepository implements FloorRepositoryInterface
{
    protected $model;

    public function __construct(Floor $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->with('rooms')->get();
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
        $record = $this->model->findOrFail($id);
        $record->update($data);
        return $record;
    }

    public function delete($id)
    {
        $record = $this->model->findOrFail($id);
        return $record->delete();
    }

    public function getPaginated(array $filters = [], $perPage = 10)
    {
        $query = $this->model->with('rooms');

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        return $query->paginate($perPage);
    }
}
