<?php

namespace App\Repositories\Contracts;

interface SurchargePolicyRepositoryInterface
{
    public function getByType(string $type);
    public function createOrUpdateByType(string $type, array $policies);
}
