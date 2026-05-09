<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface HomeRepositoryInterface
{
    public function getFeaturedRoomTypes(int $limit = 3): Collection;
}
