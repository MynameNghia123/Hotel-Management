<?php

namespace App\Repositories\Contracts;

interface CustomerRepositoryInterface extends BaseRepositoryInterface
{
    public function getDistinctCountries();
    public function findByEmail($email);
}
