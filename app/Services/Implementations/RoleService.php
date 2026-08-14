<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Services\Contracts\RoleClaimServiceInterface;
use App\Services\Contracts\RoleServiceInterface;

class RoleService implements RoleServiceInterface
{
    protected $roleRepository;

    protected $roleClaimService;

    public function __construct(RoleRepositoryInterface $roleRepository, RoleClaimServiceInterface $roleClaimService)
    {
        $this->roleRepository = $roleRepository;
        $this->roleClaimService = $roleClaimService;
    }

    public function getAll()
    {
        return $this->roleRepository->getAll();
    }

    public function findById($id)
    {
        return $this->roleRepository->findById($id);
    }

    public function create(array $data)
    {
        // Tạo role
        $role = $this->roleRepository->create(['name' => $data['name']]);

        // Lấy permissions từ data
        $permissions = $data['permissions'] ?? [];

        // Lưu permissions (role claims)
        if (! empty($permissions)) {
            foreach ($permissions as $permission) {
                $parts = explode('.', $permission);
                if (count($parts) == 2) {
                    $this->roleClaimService->create([
                        'claim_name' => $parts[0],
                        'claim_value' => $parts[1],
                        'role_id' => $role->id,
                    ]);
                }
            }
        }

        return $role;
    }

    public function update($id, array $data)
    {
        // dd($data);

        // Update role
        $role = $this->roleRepository->update($id, ['name' => $data['name']]);

        // Lấy permissions từ data
        $permissions = $data['permissions'] ?? [];

        // Xóa role claims cũ
        $oldClaims = $this->roleClaimService->getAll()->where('role_id', $id);
        foreach ($oldClaims as $claim) {
            $this->roleClaimService->delete($claim->id);
        }

        // Lưu role claims mới
        if (! empty($permissions)) {
            foreach ($permissions as $permission) {
                $parts = explode('.', $permission);
                if (count($parts) == 2) {
                    $this->roleClaimService->create([
                        'claim_name' => $parts[0],
                        'claim_value' => $parts[1],
                        'role_id' => $id,
                    ]);
                }
            }
        }

        return $role;
    }

    public function delete($id)
    {
        return $this->roleRepository->delete($id);
    }

    public function getPaginated(array $filters = [], $perPage = 15)
    {
        return $this->roleRepository->getPaginated($filters, $perPage);
    }
}
