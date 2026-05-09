<?php

namespace App\Repositories\Contracts;

use Carbon\Carbon;
use Illuminate\Support\Collection;

interface StatisticalRepositoryInterface
{
    public function latestBusinessDate(): ?Carbon;

    public function getRevenueSummary(Carbon $startDate, Carbon $endDate, ?string $status = null): array;

    public function getDailyRevenue(Carbon $startDate, Carbon $endDate, ?string $status = null): Collection;

    public function getMonthlyRevenue(int $year, ?string $status = null): Collection;

    public function getRecentBookings(int $limit = 5): Collection;

    public function getRoomStatusCounts(): Collection;

    public function getRoomEfficiencySource(Carbon $startDate, Carbon $endDate, ?int $roomTypeId = null): array;

    public function getTopRoomTypes(Carbon $startDate, Carbon $endDate, ?int $roomTypeId = null): Collection;

    public function getRoomTypes(): Collection;

    public function getCustomerSummary(Carbon $startDate, Carbon $endDate): array;

    public function getLoyalCustomers(Carbon $startDate, Carbon $endDate, int $limit = 5): Collection;
}
