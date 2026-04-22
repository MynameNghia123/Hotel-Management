<?php

namespace App\Services\Contracts;

interface CustomerServiceInterface extends BaseServiceInterface
{
    public function getDistinctCountries();
    public function findByEmail($email);
}
