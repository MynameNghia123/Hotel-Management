<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\HomeRepositoryInterface;
use App\Services\Contracts\HomeServiceInterface;

class HomeService implements HomeServiceInterface
{
    public function __construct(
        private readonly HomeRepositoryInterface $homeRepository
    ) {}

    public function getHomepageData(): array
    {
        return [
            'featuredRoomTypes' => $this->homeRepository->getFeaturedRoomTypes(3),
        ];
    }
}
