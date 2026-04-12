<?php

namespace App\Repositories\Implementations;

use App\Models\Staff;
use App\Repositories\Contracts\AuthRepositoryInterface;

class EloquentAuthRepository implements AuthRepositoryInterface
{
    protected $model;

    public function __construct(Staff $model)
    {
        $this->model = $model;
    }

    /**
     * Tìm staff theo email
     */
    public function findByEmail(string $email): ?Staff
    {
        return $this->model->with('role')->where('email', $email)->first();
    }

    /**
     * Tìm staff theo ID
     */
    public function findById($id): ?Staff
    {
        return $this->model->with('role')->findOrFail($id);
    }
}
