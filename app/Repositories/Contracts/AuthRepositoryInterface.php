<?php

namespace App\Repositories\Contracts;

use App\Models\Staff;

interface AuthRepositoryInterface
{
    /**
     * Tìm staff theo email
     */
    public function findByEmail(string $email): ?Staff;

    /**
     * Tìm staff theo ID
     */
    public function findById($id): ?Staff;
}
