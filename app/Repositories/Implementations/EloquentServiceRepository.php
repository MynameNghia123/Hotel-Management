<?php

namespace App\Repositories\Implementations;

use App\Models\Service;
use App\Repositories\Contracts\ServiceRepositoryInterface;
use App\Repositories\Filters\ServiceFilter;

class EloquentServiceRepository implements ServiceRepositoryInterface
{
    protected $model;

    public function __construct(Service $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->with('group')->get();
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
        $query = $this->model->with('group');

        $query = ServiceFilter::apply($query, $filters);

        return $query->paginate($perPage);
    }
}
