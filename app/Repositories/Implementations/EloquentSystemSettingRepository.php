<?php

namespace App\Repositories\Implementations;

use App\Models\SystemSetting;
use App\Repositories\Contracts\SystemSettingRepositoryInterface;

class EloquentSystemSettingRepository implements SystemSettingRepositoryInterface
{
    protected $model;

    public function __construct(SystemSetting $model)
    {
        $this->model = $model;
    }

    public function getByKey(string $key)
    {
        return $this->model->where('setting_key', $key)->first();
    }

    public function setByKey(string $key, $value, $description = null)
    {
        $setting = $this->getByKey($key);
        
        if ($setting) {
            $setting->update([
                'setting_value' => $value,
                'description' => $description ?? $setting->description
            ]);
            return $setting;
        }

        return $this->model->create([
            'setting_key' => $key,
            'setting_value' => $value,
            'description' => $description
        ]);
    }
}
