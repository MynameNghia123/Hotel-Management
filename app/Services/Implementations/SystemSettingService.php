<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\SystemSettingRepositoryInterface;
use App\Services\Contracts\SystemSettingServiceInterface;

class SystemSettingService implements SystemSettingServiceInterface
{
    protected $repository;

    public function __construct(SystemSettingRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getByKey(string $key)
    {
        return $this->repository->getByKey($key);
    }

    public function setByKey(string $key, $value, $description = null)
    {
        return $this->repository->setByKey($key, $value, $description);
    }

    public function getCheckInTime()
    {
        $setting = $this->getByKey('check_in_time');

        return $setting ? $setting->setting_value : '14:00';
    }

    public function getCheckOutTime()
    {
        $setting = $this->getByKey('check_out_time');

        return $setting ? $setting->setting_value : '12:00';
    }

    public function getRoundMinutes()
    {
        $setting = $this->getByKey('round_minutes');

        return $setting ? (int) $setting->setting_value : 15;
    }

    public function updateGeneralSettings(array $data)
    {
        if (isset($data['check_in_time'])) {
            $this->setByKey('check_in_time', $data['check_in_time'], 'Thời gian nhận phòng trong ngày');
        }

        if (isset($data['check_out_time'])) {
            $this->setByKey('check_out_time', $data['check_out_time'], 'Thời gian trả phòng trong ngày');
        }

        if (isset($data['round_minutes'])) {
            $this->setByKey('round_minutes', $data['round_minutes'], 'Số phút làm tròn 1 giờ');
        }

        return true;
    }
}
