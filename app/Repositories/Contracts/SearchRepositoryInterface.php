<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface SearchRepositoryInterface
{
    public function searchRoomTypes(array $criteria): Collection;
}
