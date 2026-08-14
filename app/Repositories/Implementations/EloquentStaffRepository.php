<?php

namespace App\Repositories\Implementations;

use App\Models\Staff;
use App\Repositories\Contracts\StaffRepositoryInterface;
use App\Repositories\Filters\StaffFilter;
use Illuminate\Support\Collection;

class EloquentStaffRepository implements StaffRepositoryInterface
{
    protected $model;

    public function __construct(Staff $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model->with('role')->get();
    }

    public function create(array $data): Staff
    {
        return $this->model->create($data);
    }

    public function findById($id): Staff
    {
        return $this->model->with('role')->findOrFail($id);
    }

    public function update($id, array $data): Staff
    {
        $staff = $this->findById($id);
        $staff->update($data);

        return $staff;
    }

    public function delete($id): bool
    {
        $staff = $this->findById($id);

        return $staff->delete();
    }

    public function getPaginated(array $filters = [], $perPage = 10)
    {
        $query = $this->model->with('role');

        // Áp dụng các filter từ StaffFilter
        $query = StaffFilter::apply($query, $filters);

        return $query->paginate($perPage);
    }
}
