i<?php

namespace App\Repositories\Implementations;

use App\Models\Room;
use App\Repositories\Contracts\RoomRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentRoomRepository extends BaseRepository implements RoomRepositoryInterface
{
    public function __construct(Room $model)
    {
        parent::__construct($model);
    }

    /**
     * Lấy danh sách phòng còn trống trong khoảng thời gian nhất định.
     */
    public function getAvailableRooms(string $checkIn, string $checkOut): Collection
    {
        return $this->model
            ->where('status', 'available')
            ->whereDoesntHave('bookings', function ($query) use ($checkIn, $checkOut) {
                $query->whereNotIn('status', ['cancelled', 'checked_out'])
                      ->where(function ($q) use ($checkIn, $checkOut) {
                          $q->whereBetween('check_in', [$checkIn, $checkOut])
                            ->orWhereBetween('check_out', [$checkIn, $checkOut])
                            ->orWhere(function ($q2) use ($checkIn, $checkOut) {
                                $q2->where('check_in', '<=', $checkIn)
                                   ->where('check_out', '>=', $checkOut);
                            });
                      });
            })
            ->with(['roomType'])
            ->get();
    }

    /**
     * Lấy danh sách phòng theo loại phòng với phân trang.
     */
    public function getRoomsByType(int $roomTypeId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->where('room_type_id', $roomTypeId)
            ->with(['roomType'])
            ->paginate($perPage);
    }

    /**
     * Lấy danh sách phòng theo trạng thái.
     */
    public function getRoomsByStatus(string $status, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->where('status', $status)
            ->with(['roomType'])
            ->paginate($perPage);
    }

    /**
     * Lấy danh sách phòng theo tầng.
     */
    public function getRoomsByFloor(int $floor): Collection
    {
        return $this->model
            ->where('floor', $floor)
            ->with(['roomType'])
            ->get();
    }

    /**
     * Cập nhật trạng thái phòng.
     */
    public function updateStatus(int $roomId, string $status): bool
    {
        return $this->model
            ->findOrFail($roomId)
            ->update(['status' => $status]);
    }

    /**
     * Tìm kiếm phòng theo tên hoặc số phòng.
     */
    public function searchRooms(string $keyword, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->where('room_number', 'LIKE', "%{$keyword}%")
            ->orWhere('name', 'LIKE', "%{$keyword}%")
            ->with(['roomType'])
            ->paginate($perPage);
    }

    /**
     * Lấy thống kê tỷ lệ lấp đầy (occupancy rate) theo khoảng thời gian.
     * Trả về: ['total_rooms' => int, 'occupied_rooms' => int, 'occupancy_rate' => float]
     */
    public function getOccupancyRate(string $startDate, string $endDate): array
    {
        $totalRooms = $this->model->count();

        $occupiedRooms = $this->model
            ->whereHas('bookings', function ($query) use ($startDate, $endDate) {
                $query->whereNotIn('status', ['cancelled'])
                      ->where('check_in', '<=', $endDate)
                      ->where('check_out', '>=', $startDate);
            })
            ->count();

        return [
            'total_rooms'    => $totalRooms,
            'occupied_rooms' => $occupiedRooms,
            'occupancy_rate' => $totalRooms > 0
                ? round(($occupiedRooms / $totalRooms) * 100, 2)
                : 0.0,
        ];
    }
}
