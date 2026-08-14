<?php

namespace App\Services\Implementations;

use App\Enums\RoomStatus;
use App\Repositories\Contracts\StatisticalRepositoryInterface;
use App\Services\Contracts\StatisticalServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class StatisticalService implements StatisticalServiceInterface
{
    public function __construct(
        private readonly StatisticalRepositoryInterface $statisticalRepository
    ) {}

    public function overview(array $filters = []): array
    {
        $range = $this->resolveDateRange($filters, 'month');
        $previousRange = $this->previousRange($range['start'], $range['end']);

        $summary = $this->statisticalRepository->getRevenueSummary($range['start'], $range['end']);
        $previousSummary = $this->statisticalRepository->getRevenueSummary($previousRange['start'], $previousRange['end']);
        $roomEfficiency = $this->roomEfficiencyMetrics($range['start'], $range['end']);
        $customers = $this->statisticalRepository->getCustomerSummary($range['start'], $range['end']);
        $dailyRevenue = $this->dailySeries($range['start'], $range['end'], $this->statisticalRepository->getDailyRevenue($range['start'], $range['end']));

        return [
            'range' => $range,
            'generated_at' => $this->generatedAtLabel($range['end']),
            'summary' => [
                'revenue' => $summary['total_revenue'],
                'revenue_growth' => $this->percentageChange($summary['total_revenue'], $previousSummary['total_revenue']),
                'occupancy_rate' => $roomEfficiency['occupancy_rate'],
                'occupancy_growth' => $this->percentageChange(
                    $roomEfficiency['occupancy_rate'],
                    $this->roomEfficiencyMetrics($previousRange['start'], $previousRange['end'])['occupancy_rate']
                ),
                'guest_visits' => $customers['total_visits'],
                'guest_growth' => $this->percentageChange($customers['total_visits'], $this->statisticalRepository->getCustomerSummary($previousRange['start'], $previousRange['end'])['total_visits']),
                'bookings_count' => $summary['bookings_count'],
            ],
            'line_chart' => $this->lineChart($dailyRevenue->pluck('value')->all(), 600, 200),
            'daily_revenue' => $dailyRevenue,
            'revenue_mix' => $this->revenueMix($summary),
            'activities' => $this->formatActivities($this->statisticalRepository->getRecentBookings(4)),
        ];
    }

    public function revenue(array $filters = []): array
    {
        $range = $this->resolveDateRange($filters, 'month');
        $status = $filters['status'] ?? null;
        $previousRange = $this->previousRange($range['start'], $range['end']);
        $year = (int) ($filters['year'] ?? $range['end']->year);

        $summary = $this->statisticalRepository->getRevenueSummary($range['start'], $range['end'], $status);
        $previousSummary = $this->statisticalRepository->getRevenueSummary($previousRange['start'], $previousRange['end'], $status);
        $monthlyRevenue = $this->monthlySeries($year, $this->statisticalRepository->getMonthlyRevenue($year, $status));
        $previousYearRevenue = $this->monthlySeries($year - 1, $this->statisticalRepository->getMonthlyRevenue($year - 1, $status));
        $maxMonthlyRevenue = max(1, $monthlyRevenue->max('value'), $previousYearRevenue->max('value'));

        return [
            'range' => $range,
            'generated_at' => $this->generatedAtLabel($range['end']),
            'filters' => [
                'status' => $status ?: 'all',
                'year' => $year,
            ],
            'summary' => $summary + [
                'growth' => $this->percentageChange($summary['total_revenue'], $previousSummary['total_revenue']),
            ],
            'revenue_mix' => $this->revenueMix($summary),
            'monthly_revenue' => $monthlyRevenue,
            'previous_year_revenue' => $previousYearRevenue,
            'current_year_chart' => $this->lineChart($monthlyRevenue->pluck('value')->all(), 800, 300, $maxMonthlyRevenue),
            'previous_year_chart' => $this->lineChart($previousYearRevenue->pluck('value')->all(), 800, 300, $maxMonthlyRevenue),
            'max_monthly_revenue' => $maxMonthlyRevenue,
        ];
    }

    public function roomEfficiency(array $filters = []): array
    {
        $range = $this->resolveDateRange($filters, 'week');
        $roomTypeId = isset($filters['room_type_id']) && $filters['room_type_id'] !== ''
            ? (int) $filters['room_type_id']
            : null;
        $previousRange = $this->previousRange($range['start'], $range['end']);

        $metrics = $this->roomEfficiencyMetrics($range['start'], $range['end'], $roomTypeId);
        $previousMetrics = $this->roomEfficiencyMetrics($previousRange['start'], $previousRange['end'], $roomTypeId);
        $roomStatus = $this->roomStatusSummary();
        $topRoomTypes = $this->topRoomTypes($range['start'], $range['end'], $roomTypeId);

        return [
            'range' => $range,
            'generated_at' => $this->generatedAtLabel($range['end']),
            'filters' => [
                'room_type_id' => $roomTypeId,
            ],
            'room_types' => $this->statisticalRepository->getRoomTypes(),
            'metrics' => $metrics + [
                'occupancy_growth' => $this->percentageChange($metrics['occupancy_rate'], $previousMetrics['occupancy_rate']),
            ],
            'room_status' => $roomStatus,
            'top_room_types' => $topRoomTypes,
            'room_rows' => $metrics['room_rows'],
        ];
    }

    public function customers(array $filters = []): array
    {
        $range = $this->resolveDateRange($filters, 'month');
        $previousRange = $this->previousRange($range['start'], $range['end']);

        $summary = $this->statisticalRepository->getCustomerSummary($range['start'], $range['end']);
        $previousSummary = $this->statisticalRepository->getCustomerSummary($previousRange['start'], $previousRange['end']);
        $returningRate = $summary['total_customers'] > 0
            ? round(($summary['returning_customers'] / $summary['total_customers']) * 100, 1)
            : 0;

        return [
            'range' => $range,
            'generated_at' => $this->generatedAtLabel($range['end']),
            'summary' => [
                'total_visits' => $summary['total_visits'],
                'total_visits_growth' => $this->percentageChange($summary['total_visits'], $previousSummary['total_visits']),
                'new_customers' => $summary['new_customers'],
                'new_customers_growth' => $this->percentageChange($summary['new_customers'], $previousSummary['new_customers']),
                'returning_rate' => $returningRate,
                'total_customers' => $summary['total_customers'],
            ],
            'loyal_customers' => $this->statisticalRepository->getLoyalCustomers($range['start'], $range['end'], 5),
        ];
    }

    private function resolveDateRange(array $filters, string $defaultPeriod): array
    {
        $latestBusinessDate = $this->statisticalRepository->latestBusinessDate() ?? now();
        $end = ! empty($filters['end_date'])
            ? Carbon::parse($filters['end_date'])
            : $latestBusinessDate->copy();

        $start = ! empty($filters['start_date'])
            ? Carbon::parse($filters['start_date'])
            : match ($defaultPeriod) {
                'week' => $end->copy()->subDays(6),
                'year' => $end->copy()->startOfYear(),
                default => $end->copy()->startOfMonth(),
            };

        if ($start->greaterThan($end)) {
            [$start, $end] = [$end, $start];
        }

        return [
            'start' => $start->copy()->startOfDay(),
            'end' => $end->copy()->endOfDay(),
            'start_date' => $start->toDateString(),
            'end_date' => $end->toDateString(),
            'label' => $start->format('d/m/Y').' - '.$end->format('d/m/Y'),
        ];
    }

    private function previousRange(Carbon $startDate, Carbon $endDate): array
    {
        $days = max(1, $startDate->copy()->startOfDay()->diffInDays($endDate->copy()->startOfDay()) + 1);
        $previousEnd = $startDate->copy()->subDay()->endOfDay();
        $previousStart = $previousEnd->copy()->subDays($days - 1)->startOfDay();

        return [
            'start' => $previousStart,
            'end' => $previousEnd,
        ];
    }

    private function dailySeries(Carbon $startDate, Carbon $endDate, Collection $values): Collection
    {
        $series = collect();
        $cursor = $startDate->copy()->startOfDay();

        while ($cursor->lte($endDate)) {
            $dateKey = $cursor->toDateString();
            $series->push([
                'label' => $cursor->format('d/m'),
                'date' => $dateKey,
                'value' => (float) ($values[$dateKey] ?? 0),
            ]);
            $cursor->addDay();
        }

        return $series;
    }

    private function monthlySeries(int $year, Collection $values): Collection
    {
        return collect(range(1, 12))->map(fn ($month) => [
            'label' => 'Tháng '.$month,
            'month' => $month,
            'year' => $year,
            'value' => (float) ($values[$month] ?? 0),
        ]);
    }

    private function percentageChange(float|int $current, float|int $previous): float
    {
        if ((float) $previous === 0.0) {
            return $current > 0 ? 100.0 : 0.0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }

    private function revenueMix(array $summary): array
    {
        $items = [
            ['key' => 'room', 'label' => 'Tiền phòng', 'value' => $summary['room_revenue'], 'color' => '#1e2e6b'],
            ['key' => 'service', 'label' => 'Dịch vụ', 'value' => $summary['service_revenue'], 'color' => '#3b82f6'],
            ['key' => 'surcharge', 'label' => 'Phụ thu', 'value' => $summary['surcharge_revenue'], 'color' => '#93c5fd'],
        ];

        $total = max(0.0, array_sum(array_column($items, 'value')));
        $offset = 0.0;
        $circumference = 251.2;

        return collect($items)->map(function ($item) use ($total, $circumference, &$offset) {
            $percent = $total > 0 ? round(($item['value'] / $total) * 100, 1) : 0.0;
            $length = round(($percent / 100) * $circumference, 1);
            $dashOffset = -$offset;
            $offset += $length;

            return $item + [
                'percent' => $percent,
                'dasharray' => $length.' '.round($circumference - $length, 1),
                'dashoffset' => $dashOffset,
            ];
        })->all();
    }

    private function lineChart(array $values, int $width, int $height, ?float $scaleMax = null): array
    {
        $count = count($values);

        if ($count === 0) {
            return ['path' => '', 'area_path' => '', 'points' => [], 'max' => 0];
        }

        $max = max(1, $scaleMax ?? max($values));
        $usableHeight = max(1, $height - 24);
        $stepX = $count > 1 ? $width / ($count - 1) : 0;
        $points = [];

        foreach ($values as $index => $value) {
            $x = round($index * $stepX, 2);
            $y = round($height - 12 - (($value / $max) * $usableHeight), 2);
            $points[] = [$x, $y];
        }

        $path = collect($points)
            ->map(fn ($point, $index) => ($index === 0 ? 'M' : 'L').$point[0].','.$point[1])
            ->implode(' ');

        $areaPath = $path.' L'.$width.','.$height.' L0,'.$height.' Z';

        return [
            'path' => $path,
            'area_path' => $areaPath,
            'points' => $points,
            'max' => $max,
        ];
    }

    private function roomEfficiencyMetrics(Carbon $startDate, Carbon $endDate, ?int $roomTypeId = null): array
    {
        $source = $this->statisticalRepository->getRoomEfficiencySource($startDate, $endDate, $roomTypeId);
        $rooms = $source['rooms'];
        $detailsByRoom = $source['details']->groupBy('room_id');
        $days = max(1, $startDate->copy()->startOfDay()->diffInDays($endDate->copy()->startOfDay()) + 1);
        $totalRoomNights = max(1, $rooms->count() * $days);
        $occupiedRoomNights = 0;

        $roomRows = $rooms->map(function ($room) use ($detailsByRoom, $startDate, $endDate, $days, &$occupiedRoomNights) {
            $roomNights = $detailsByRoom->get($room->id, collect())
                ->sum(fn ($detail) => $this->overlapDays($detail->checkin_date, $detail->checkout_date, $startDate, $endDate));

            $occupiedRoomNights += $roomNights;
            $rate = round(($roomNights / $days) * 100, 1);

            return [
                'room_name' => $room->name,
                'room_type' => $room->room_type_name,
                'floor' => $room->floor_name,
                'status' => $room->status,
                'status_label' => $this->roomStatusLabel($room->status),
                'badge_class' => $this->roomStatusBadgeClass($room->status),
                'occupancy_rate' => min(100, $rate),
                'progress_color' => $this->progressColor($rate),
            ];
        });

        return [
            'room_count' => $rooms->count(),
            'booking_count' => $source['details']->count(),
            'occupied_room_nights' => $occupiedRoomNights,
            'available_room_nights' => $totalRoomNights,
            'occupancy_rate' => round(($occupiedRoomNights / $totalRoomNights) * 100, 1),
            'estimated_revenue' => $this->statisticalRepository->getRevenueSummary($startDate, $endDate)['total_revenue'],
            'room_rows' => $roomRows,
        ];
    }

    private function overlapDays(string $checkinDate, string $checkoutDate, Carbon $startDate, Carbon $endDate): int
    {
        $checkin = Carbon::parse($checkinDate)->startOfDay();
        $checkout = Carbon::parse($checkoutDate)->startOfDay();
        $start = $checkin->greaterThan($startDate) ? $checkin : $startDate->copy()->startOfDay();
        $end = $checkout->lessThan($endDate) ? $checkout : $endDate->copy()->startOfDay()->addDay();

        if ($end->lessThanOrEqualTo($start)) {
            return 0;
        }

        return max(1, (int) $start->diffInDays($end));
    }

    private function roomStatusSummary(): array
    {
        $counts = $this->statisticalRepository->getRoomStatusCounts();
        $occupied = (int) ($counts[RoomStatus::OCCUPIED->value] ?? 0) + (int) ($counts[RoomStatus::CHECKOUT->value] ?? 0);
        $empty = (int) ($counts[RoomStatus::EMPTY->value] ?? 0);
        $maintenance = (int) ($counts[RoomStatus::MAINTENANCE->value] ?? 0);
        $total = (int) $counts->sum();
        $other = max(0, $total - $occupied - $empty - $maintenance);

        return [
            'total' => $total,
            'items' => [
                ['key' => 'occupied', 'label' => 'Đang ở', 'count' => $occupied, 'color' => '#1e2e6b'],
                ['key' => 'empty', 'label' => 'Phòng trống', 'count' => $empty, 'color' => '#93c5fd'],
                ['key' => 'maintenance', 'label' => 'Bảo trì', 'count' => $maintenance, 'color' => '#ef4444'],
                ['key' => 'other', 'label' => 'Khác', 'count' => $other, 'color' => '#94a3b8'],
            ],
        ];
    }

    private function topRoomTypes(Carbon $startDate, Carbon $endDate, ?int $roomTypeId = null): Collection
    {
        $rows = $this->statisticalRepository->getTopRoomTypes($startDate, $endDate, $roomTypeId);
        $max = max(1, (int) $rows->max('bookings_count'));
        $colors = ['#1e2e6b', '#3b82f6', '#6366f1', '#94a3b8', '#10b981'];

        return $rows->values()->map(fn ($row, $index) => [
            'name' => $row->name,
            'code' => $row->code,
            'bookings_count' => (int) $row->bookings_count,
            'percent' => round(($row->bookings_count / $max) * 100),
            'color' => $colors[$index] ?? '#94a3b8',
        ]);
    }

    private function formatActivities(Collection $bookings): Collection
    {
        return $bookings->map(function ($booking) {
            $customerName = trim(($booking->first_name ?? '').' '.($booking->last_name ?? '')) ?: 'Khách lẻ';
            $roomName = $booking->room_name ? 'Phòng '.$booking->room_name : 'Chưa gán phòng';

            return [
                'title' => $roomName.' - '.$this->bookingStatusLabel($booking->status),
                'description' => 'Khách hàng: '.$customerName,
                'time' => Carbon::parse($booking->booking_date)->diffForHumans(),
                'color' => $this->bookingStatusColor($booking->status),
            ];
        });
    }

    private function bookingStatusLabel(?string $status): string
    {
        return match ($status) {
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'occupied' => 'Đang ở',
            'paid' => 'Đã thanh toán',
            'cancelled' => 'Đã hủy',
            default => 'Cập nhật',
        };
    }

    private function bookingStatusColor(?string $status): string
    {
        return match ($status) {
            'paid' => '#f0642f',
            'occupied' => '#10b981',
            'confirmed' => '#4f46e5',
            'cancelled' => '#ef4444',
            default => '#3b82f6',
        };
    }

    private function roomStatusLabel(?string $status): string
    {
        return match ($status) {
            RoomStatus::EMPTY->value => 'Trống',
            RoomStatus::BOOKED->value => 'Đã đặt',
            RoomStatus::CONFIRMED->value => 'Đã xác nhận',
            RoomStatus::INCOMING->value => 'Sắp đến',
            RoomStatus::OCCUPIED->value => 'Đang ở',
            RoomStatus::CHECKOUT->value => 'Chuẩn bị đi',
            RoomStatus::DIRTY->value => 'Bẩn',
            RoomStatus::MAINTENANCE->value => 'Bảo trì',
            default => 'Không rõ',
        };
    }

    private function roomStatusBadgeClass(?string $status): string
    {
        return match ($status) {
            RoomStatus::EMPTY->value => 'badge-blue',
            RoomStatus::MAINTENANCE->value => 'badge-orange',
            default => 'badge-green',
        };
    }

    private function progressColor(float $rate): string
    {
        return match (true) {
            $rate >= 75 => '#10b981',
            $rate >= 40 => '#f59e0b',
            default => '#ef4444',
        };
    }

    private function generatedAtLabel(Carbon $date): string
    {
        return 'Dữ liệu tính đến '.$date->format('d/m/Y');
    }
}
