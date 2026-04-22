<?php

namespace App\Repositories\Implementations;

use App\Models\Customer;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Repositories\Filters\CustomerFilter;

class EloquentCustomerRepository implements CustomerRepositoryInterface
{
    public function __construct(
        private readonly Customer $model
    ) {}

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
        $query = $this->model->query();
        $query = CustomerFilter::apply($query, $filters);
        return $query->paginate($perPage);
    }

    public function getDistinctCountries()
    {
        return $this->model->distinct('country')
                           ->whereNotNull('country')
                           ->pluck('country')
                           ->sort()
                           ->values();
    }

    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }
}
