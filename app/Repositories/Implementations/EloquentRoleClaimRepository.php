<?php

namespace App\Repositories\Implementations;

use App\Models\RoleClaim;
use App\Repositories\Contracts\RoleClaimRepositoryInterface;

class EloquentRoleClaimRepository implements RoleClaimRepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->model = new RoleClaim();
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
        return $this->model->findOrFail($id)->update($data);
    }

    public function delete($id)
    {
        return $this->model->findOrFail($id)->delete();
    }
}
