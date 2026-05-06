<?php

namespace App\Services\Implementations;

use App\Models\SurchargePolicy;
use App\Repositories\Contracts\SurchargePolicyRepositoryInterface;
use App\Services\Contracts\SurchargePolicyServiceInterface;

class SurchargePolicyService implements SurchargePolicyServiceInterface
{
    protected $repository;

    public function __construct(SurchargePolicyRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getByType(string $type)
    {
        return $this->repository->getByType($type);
    }

    public function getEarlyCheckinPolicies()
    {
        return $this->getByType(SurchargePolicy::POLICY_EARLY_CHECKIN);
    }

    public function getLateCheckoutPolicies()
    {
        return $this->getByType(SurchargePolicy::POLICY_LATE_CHECKOUT);
    }

    public function updateEarlyCheckinPolicies(array $policies)
    {
        return $this->repository->createOrUpdateByType(SurchargePolicy::POLICY_EARLY_CHECKIN, $policies);
    }

    public function updateLateCheckoutPolicies(array $policies)
    {
        return $this->repository->createOrUpdateByType(SurchargePolicy::POLICY_LATE_CHECKOUT, $policies);
    }

    public function updateSurchargePolicies(array $data)
    {
        if (isset($data['early_checkin_policies'])) {
            $this->updateEarlyCheckinPolicies($data['early_checkin_policies']);
        }

        if (isset($data['late_checkout_policies'])) {
            $this->updateLateCheckoutPolicies($data['late_checkout_policies']);
        }

        return true;
    }
}
