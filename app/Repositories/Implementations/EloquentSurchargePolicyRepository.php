<?php

namespace App\Repositories\Implementations;

use App\Models\SurchargePolicy;
use App\Repositories\Contracts\SurchargePolicyRepositoryInterface;

class EloquentSurchargePolicyRepository implements SurchargePolicyRepositoryInterface
{
    protected $model;

    public function __construct(SurchargePolicy $model)
    {
        $this->model = $model;
    }

    public function getByType(string $type)
    {
        return $this->model->where('policy_type', $type)
            ->orderBy('hour_mark', 'asc')
            ->get();
    }

    public function createOrUpdateByType(string $type, array $policies)
    {
        // Xóa các policies cũ của loại này
        $this->model->where('policy_type', $type)->delete();

        // Tạo policies mới
        $created = [];
        foreach ($policies as $policy) {
            $created[] = $this->model->create([
                'policy_type' => $type,
                'hour_mark' => $policy['hour_mark'] ?? 0,
                'price' => $policy['price'] ?? 0,
            ]);
        }

        return $created;
    }
}
