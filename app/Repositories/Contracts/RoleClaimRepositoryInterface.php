<?php

namespace App\Repositories\Contracts;

interface RoleClaimRepositoryInterface extends BaseRepositoryInterface
{
    //
    public function getByRoleId($roleId);

    public function deleteByRoleId($roleId);
}
