<?php

namespace App\Repositories\Implementations;

use App\Models\ServiceGroup;
use App\Repositories\Contracts\ServiceGroupRepositoryInterface;
use App\Repositories\Filters\ServiceGroupFilter;

class EloquentServiceGroupRepository implements ServiceGroupRepositoryInterface
{
    protected $model;

    public function __construct(ServiceGroup $model)
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

        return $record->delete();
    }

    public function getPaginated(array $filters = [], $perPage = 5)
    {
        $query = $this->model->with('services');

        $query = ServiceGroupFilter::apply($query, $filters);

        return $query->paginate($perPage);
    }
}
