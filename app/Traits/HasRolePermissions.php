<?php

namespace App\Traits;

trait HasRolePermissions
{
    protected ?array $cachedPermissions = null;

    public function hasPermission(string $claimName, ?string $claimValue = null): bool
    {
        [$claimName, $claimValue] = $this->normalizePermission($claimName, $claimValue);

        if (! $claimName || ! $claimValue || ! $this->role_id) {
            return false;
        }

        if ((int) $this->role_id === 1) {
            return true;
        }

        return in_array($claimName.'.'.$claimValue, $this->getPermissions(), true);
    }

    public function hasAnyPermission(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    public function getPermissions(): array
    {
        if ($this->cachedPermissions !== null) {
            return $this->cachedPermissions;
        }

        if (! $this->role_id) {
            return [];
        }

        $role = $this->relationLoaded('role') ? $this->role : $this->role()->with('roleClaims')->first();

        if (! $role) {
            return $this->cachedPermissions = [];
        }

        $claims = $role->relationLoaded('roleClaims')
            ? $role->roleClaims
            : $role->roleClaims()->get();

        return $this->cachedPermissions = $claims
            ->map(fn ($claim) => $claim->claim_name.'.'.$claim->claim_value)
            ->values()
            ->all();
    }

    private function normalizePermission(string $claimName, ?string $claimValue = null): array
    {
        if ($claimValue === null && str_contains($claimName, '.')) {
            return explode('.', $claimName, 2);
        }

        return [$claimName, $claimValue];
    }
}
