<?php

namespace App\Repositories\Implementations;

use App\Models\EquipmentCategory;
use App\Repositories\Contracts\EquipmentCategoryRepositoryInterface;
use App\Repositories\Filters\EquipmentCategoryFilter;

class EloquentEquipmentCategoryRepository implements EquipmentCategoryRepositoryInterface
{
    protected $model;

    public function __construct(EquipmentCategory $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getPaginated(array $filters = [], $perPage = 10)
    {
        $query = $this->model->query();
        $query = EquipmentCategoryFilter::apply($query, $filters);

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
