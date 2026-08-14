<?php

namespace App\Services\Contracts;

interface RoleClaimServiceInterface extends BaseServiceInterface
{
    public function getByRoleId($roleId);

    public function deleteByRoleId($roleId);
}
