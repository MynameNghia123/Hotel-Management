<?php

namespace App\Repositories\Implementations;

use App\Enums\BookingStatus;
use App\Repositories\Contracts\StatisticalRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class EloquentStatisticalRepository implements StatisticalRepositoryInterface
{
    public function latestBusinessDate(): ?Carbon
    {
        $latestDate = collect([
            DB::table('bookings')->max('booking_date'),
            DB::table('payments')->max('created_at'),
        ])->filter()->max();

        return $latestDate ? Carbon::parse($latestDate) : null;
    }

    public function getRevenueSummary(Carbon $startDate, Carbon $endDate, ?string $status = null): array
    {
        $summary = $this->bookingsForPeriod($startDate, $endDate, $status)
            ->selectRaw('
                COALESCE(SUM(final_amount), 0) as total_revenue,
                COALESCE(SUM(total_room_amount), 0) as room_revenue,
                COALESCE(SUM(total_service_amount), 0) as service_revenue,
                COALESCE(SUM(surcharge_amount), 0) as surcharge_revenue,
                COUNT(*) as bookings_count,
                COUNT(DISTINCT customer_id) as customers_count
            ')
            ->first();

        return [
            'total_revenue' => (float) ($summary->total_revenue ?? 0),
            'room_revenue' => (float) ($summary->room_revenue ?? 0),
            'service_revenue' => (float) ($summary->service_revenue ?? 0),
            'surcharge_revenue' => (float) ($summary->surcharge_revenue ?? 0),
            'bookings_count' => (int) ($summary->bookings_count ?? 0),
            'customers_count' => (int) ($summary->customers_count ?? 0),
        ];
    }

    public function getDailyRevenue(Carbon $startDate, Carbon $endDate, ?string $status = null): Collection
    {
        $rows = $this->bookingsForPeriod($startDate, $endDate, $status)
            ->select('booking_date', 'final_amount')
            ->get();

        return $rows
            ->groupBy(fn ($row) => Carbon::parse($row->booking_date)->toDateString())
            ->map(fn ($items) => (float) $items->sum('final_amount'));
    }

    public function getMonthlyRevenue(int $year, ?string $status = null): Collection
    {
        $query = DB::table('bookings')
            ->whereYear('booking_date', $year);

        $this->applyStatusFilter($query, $status);

        return $query
            ->select('booking_date', 'final_amount')
            ->get()
            ->groupBy(fn ($row) => Carbon::parse($row->booking_date)->month)
            ->map(fn ($items) => (float) $items->sum('final_amount'));
    }

    public function getRecentBookings(int $limit = 5): Collection
    {
        return DB::table('bookings')
            ->leftJoin('customers', 'customers.id', '=', 'bookings.customer_id')
            ->leftJoin('booking_details', 'booking_details.booking_id', '=', 'bookings.id')
            ->leftJoin('rooms', 'rooms.id', '=', 'booking_details.room_id')
            ->select(
                'bookings.id',
                'bookings.status',
                'bookings.booking_date',
                'bookings.final_amount',
                'customers.first_name',
                'customers.last_name',
                DB::raw('MIN(rooms.name) as room_name')
            )
            ->groupBy(
                'bookings.id',
                'bookings.status',
                'bookings.booking_date',
                'bookings.final_amount',
                'customers.first_name',
                'customers.last_name'
            )
            ->orderByDesc('bookings.booking_date')
            ->limit($limit)
            ->get();
    }

    public function getRoomStatusCounts(): Collection
    {
        return DB::table('rooms')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');
    }

    public function getRoomEfficiencySource(Carbon $startDate, Carbon $endDate, ?int $roomTypeId = null): array
    {
        $roomsQuery = DB::table('rooms')
            ->join('room_types', 'room_types.id', '=', 'rooms.room_type_id')
            ->join('floors', 'floors.id', '=', 'rooms.floor_id')
            ->select(
                'rooms.id',
                'rooms.name',
                'rooms.status',
                'room_types.name as room_type_name',
                'room_types.code as room_type_code',
                'floors.name as floor_name'
            );

        if ($roomTypeId) {
            $roomsQuery->where('rooms.room_type_id', $roomTypeId);
        }

        $detailsQuery = DB::table('booking_details')
            ->join('bookings', 'bookings.id', '=', 'booking_details.booking_id')
            ->join('rooms', 'rooms.id', '=', 'booking_details.room_id')
            ->where('bookings.status', '!=', BookingStatus::CANCELLED->value)
            ->where('booking_details.checkin_date', '<=', $endDate->copy()->endOfDay())
            ->where('booking_details.checkout_date', '>=', $startDate->copy()->startOfDay())
            ->select(
                'booking_details.room_id',
                'booking_details.checkin_date',
                'booking_details.checkout_date'
            );

        if ($roomTypeId) {
            $detailsQuery->where('rooms.room_type_id', $roomTypeId);
        }

        return [
            'rooms' => $roomsQuery->orderBy('rooms.name')->get(),
            'details' => $detailsQuery->get(),
        ];
    }

    public function getTopRoomTypes(Carbon $startDate, Carbon $endDate, ?int $roomTypeId = null): Collection
    {
        $query = DB::table('booking_details')
            ->join('bookings', 'bookings.id', '=', 'booking_details.booking_id')
            ->join('rooms', 'rooms.id', '=', 'booking_details.room_id')
            ->join('room_types', 'room_types.id', '=', 'rooms.room_type_id')
            ->where('bookings.status', '!=', BookingStatus::CANCELLED->value)
            ->where('booking_details.checkin_date', '<=', $endDate->copy()->endOfDay())
            ->where('booking_details.checkout_date', '>=', $startDate->copy()->startOfDay())
            ->select(
                'room_types.id',
                'room_types.name',
                'room_types.code',
                DB::raw('COUNT(booking_details.id) as bookings_count')
            )
            ->groupBy('room_types.id', 'room_types.name', 'room_types.code')
            ->orderByDesc('bookings_count');

        if ($roomTypeId) {
            $query->where('room_types.id', $roomTypeId);
        }

        return $query->limit(5)->get();
    }

    public function getRoomTypes(): Collection
    {
        return DB::table('room_types')
            ->select('id', 'name', 'code')
            ->orderBy('name')
            ->get();
    }

    public function getCustomerSummary(Carbon $startDate, Carbon $endDate): array
    {
        $baseQuery = $this->bookingsForPeriod($startDate, $endDate);

        $totalVisits = (clone $baseQuery)->count();
        $customerIds = (clone $baseQuery)->distinct()->pluck('customer_id');
        $returningCustomers = (clone $baseQuery)
            ->select('customer_id', DB::raw('COUNT(*) as visits'))
            ->groupBy('customer_id')
            ->havingRaw('COUNT(*) > 1')
            ->get()
            ->count();

        $firstBookings = DB::table('bookings')
            ->where('status', '!=', BookingStatus::CANCELLED->value)
            ->select('customer_id', DB::raw('MIN(booking_date) as first_booking_at'))
            ->groupBy('customer_id');

        $newCustomers = DB::query()
            ->fromSub($firstBookings, 'first_bookings')
            ->whereBetween('first_booking_at', [
                $startDate->copy()->startOfDay(),
                $endDate->copy()->endOfDay(),
            ])
            ->count();

        return [
            'total_visits' => $totalVisits,
            'total_customers' => $customerIds->count(),
            'new_customers' => $newCustomers,
            'returning_customers' => $returningCustomers,
        ];
    }

    public function getLoyalCustomers(Carbon $startDate, Carbon $endDate, int $limit = 5): Collection
    {
        return $this->bookingsForPeriod($startDate, $endDate)
            ->join('customers', 'customers.id', '=', 'bookings.customer_id')
            ->select(
                'customers.id',
                'customers.first_name',
                'customers.last_name',
                'customers.email',
                DB::raw('COUNT(bookings.id) as visits_count'),
                DB::raw('COALESCE(SUM(bookings.final_amount), 0) as total_spending')
            )
            ->groupBy('customers.id', 'customers.first_name', 'customers.last_name', 'customers.email')
            ->orderByDesc('total_spending')
            ->orderByDesc('visits_count')
            ->limit($limit)
            ->get();
    }

    private function bookingsForPeriod(Carbon $startDate, Carbon $endDate, ?string $status = null): Builder
    {
        $query = DB::table('bookings')
            ->whereBetween('booking_date', [
                $startDate->copy()->startOfDay(),
                $endDate->copy()->endOfDay(),
            ]);

        $this->applyStatusFilter($query, $status);

        return $query;
    }

    private function applyStatusFilter(Builder $query, ?string $status = null): void
    {
        if ($status && $status !== 'all') {
            $query->where('status', $status);
            return;
        }

        $query->where('status', '!=', BookingStatus::CANCELLED->value);
    }
}
