<?php

namespace App\Repositories\Implementations;

use App\Enums\BookingStatus;
use App\Enums\RoomStatus;
use App\Models\Room;
use App\Repositories\Contracts\RoomRepositoryInterface;
use Carbon\Carbon;

class EloquentRoomRepository implements RoomRepositoryInterface
{
    protected $model;

    public function __construct(Room $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->with(['roomType', 'floor'])->orderBy('name')->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function findById($id)
    {
        return $this->model->with(['roomType', 'floor'])->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $record = $this->model->findOrFail($id);
        $record->update($data);
        return $record;
    }

    public function delete($id)
    {
        $record = $this->model->findOrFail($id);
        return $record->delete();
    }

    public function getByRoomType($roomTypeId)
    {
        return $this->model->with(['roomType', 'floor'])
            ->where('room_type_id', $roomTypeId)
            ->get();
    }

    public function getAvailableRooms($checkInDate, $checkOutDate)
    {
        $checkInAt = Carbon::parse($checkInDate)->startOfDay();
        $checkOutAt = Carbon::parse($checkOutDate)->startOfDay();

        return $this->model->with(['roomType', 'floor'])
            ->where('status', '!=', RoomStatus::MAINTENANCE->value)
            ->whereDoesntHave('bookingDetails', function ($query) use ($checkInAt, $checkOutAt) {
                $query->where('checkin_date', '<', $checkOutAt)
                    ->where('checkout_date', '>', $checkInAt);
                $query->whereHas('booking', function ($bookingQuery) {
                    $bookingQuery->whereNotIn('status', [
                        BookingStatus::CANCELLED->value,
                        BookingStatus::PAID->value,
                    ]);
                });
            })
            ->when($checkOutAt->lessThanOrEqualTo($checkInAt), fn ($query) => $query->whereRaw('1 = 0'))
            ->get();
    }

    public function getPaginated(array $filters = [], $perPage = 5)
    {
        $query = $this->model->with(['roomType', 'floor']);

        if (isset($filters['number'])) {
            $query->where('number', 'like', '%' . $filters['number'] . '%');
        }

        if (isset($filters['room_type_id'])) {
            $query->where('room_type_id', $filters['room_type_id']);
        }

        if (isset($filters['floor_id'])) {
            $query->where('floor_id', $filters['floor_id']);
        }

        return $query->paginate($perPage);
    }
}
