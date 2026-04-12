<?php

namespace App\Services\Contracts;

use App\Models\Staff;

interface AuthServiceInterface
{
    /**
     * Động đăng nhập staff
     */
    public function login(string $email, string $password): ?Staff;

    /**
     * Lấy thông tin staff hiện tại (dùng trong controller)
     */
    public function getCurrentUser(): ?Staff;

    /**
     * Đăng xuất
     */
    public function logout(): void;
}
