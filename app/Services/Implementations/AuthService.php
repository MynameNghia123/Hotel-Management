<?php

namespace App\Services\Implementations;

use App\Services\Contracts\AuthServiceInterface;
use App\Repositories\Contracts\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Staff;

class AuthService implements AuthServiceInterface
{
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * Đăng nhập staff
     * 
     * @param string $email
     * @param string $password
     * @return Staff|null
     */
    public function login(string $email, string $password): ?Staff
    {
        // Tìm staff theo email
        $staff = $this->authRepository->findByEmail($email);

        // Kiểm tra:
        // 1. Staff tồn tại
        // 2. Mật khẩu đúng
        // 3. Tài khoản đang hoạt động (is_active = true)
        if (!$staff || !Hash::check($password, $staff->password) || !$staff->is_active) {
            return null;
        }

        // Đăng nhập thành công
        Auth::guard('admin')->login($staff);

        return $staff;
    }

    /**
     * Lấy staff hiện tại đang login
     */
    public function getCurrentUser(): ?Staff
    {
        return Auth::guard('admin')->user();
    }

    /**
     * Đăng xuất
     */
    public function logout(): void
    {
        Auth::guard('admin')->logout();
    }
}
