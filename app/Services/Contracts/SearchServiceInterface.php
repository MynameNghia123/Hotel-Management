<?php

namespace App\Services\Contracts;

interface SearchServiceInterface
{
    public function prepareSearchData(array $params): array;
}
