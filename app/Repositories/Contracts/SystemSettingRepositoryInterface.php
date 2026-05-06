<?php

namespace App\Repositories\Contracts;

interface SystemSettingRepositoryInterface
{
    public function getByKey(string $key);
    public function setByKey(string $key, $value, $description = null);
}
