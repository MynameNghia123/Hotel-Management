<?php

namespace App\Services\Contracts;

interface SystemSettingServiceInterface
{
    public function getByKey(string $key);
    public function setByKey(string $key, $value, $description = null);
    public function getCheckInTime();
    public function getCheckOutTime();
    public function getRoundMinutes();
    public function updateGeneralSettings(array $data);
}
