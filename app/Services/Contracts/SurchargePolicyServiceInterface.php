<?php

namespace App\Services\Contracts;

interface SurchargePolicyServiceInterface
{
    public function getByType(string $type);
    public function getEarlyCheckinPolicies();
    public function getLateCheckoutPolicies();
    public function updateEarlyCheckinPolicies(array $policies);
    public function updateLateCheckoutPolicies(array $policies);
    public function updateSurchargePolicies(array $data);
}
