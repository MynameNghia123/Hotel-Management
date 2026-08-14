<?php

namespace App\Repositories\Implementations;

use App\Models\Equipment;
use App\Repositories\Contracts\EquipmentRepositoryInterface;
use App\Repositories\Filters\EquipmentFilter;

class EloquentEquipmentRepository implements EquipmentRepositoryInterface
{
    protected $model;

    public function __construct(Equipment $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->with('category')->get();
    }

    public function getPaginated(array $filters = [], $perPage = 10)
    {
        $query = $this->model->with('category');
        $query = EquipmentFilter::apply($query, $filters);

        return $query->paginate($perPage);
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

        return $record->delete();
    }
}
