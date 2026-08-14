<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\StaffRepositoryInterface;
use App\Services\Contracts\StaffServiceInterface;
use Illuminate\Support\Facades\Hash;

class StaffService implements StaffServiceInterface
{
    public function __construct(
        private readonly StaffRepositoryInterface $staffRepository
    ) {}

    public function getAll()
    {
        return $this->staffRepository->getAll();
    }

    public function create(array $data)
    {
        // Hash the password before saving
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->staffRepository->create($data);
    }

    public function findById($id)
    {
        return $this->staffRepository->findById($id);
    }

    public function update($id, array $data)
    {
        // Hash password nếu có
        if (isset($data['password']) && ! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->staffRepository->update($id, $data);
    }

    public function delete($id): bool
    {
        return $this->staffRepository->delete($id);
    }

    public function getPaginated(array $filters = [], $perPage = 15)
    {
        return $this->staffRepository->getPaginated($filters, $perPage);
    }

    public function toggleStatus($id, $isActive): string
    {
        $this->staffRepository->update($id, ['is_active' => $isActive]);

        return $isActive
            ? 'Kích hoạt nhân viên thành công!'
            : 'Vô hiệu hóa nhân viên thành công!';
    }
}
