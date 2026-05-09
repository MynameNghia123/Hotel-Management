<?php

namespace App\Services\Contracts;

interface StatisticalServiceInterface
{
    public function overview(array $filters = []): array;

    public function revenue(array $filters = []): array;

    public function roomEfficiency(array $filters = []): array;

    public function customers(array $filters = []): array;
}
