<?php

namespace App\Repositories\Implementations;

use App\Models\Room;
use App\Repositories\Contracts\RoomRepositoryInterface;

class EloquentRoomRepository implements RoomRepositoryInterface
{
    protected $model;

    public function __construct(Room $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->with(['roomType', 'floor'])->get();
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
        return $this->model->with(['roomType', 'floor'])
            ->whereNotIn('id', function ($query) use ($checkInDate, $checkOutDate) {
                $query->select('room_id')
                    ->from('booking_details')
                    ->whereRaw('? < checkout_date AND ? > checkin_date', [$checkInDate, $checkOutDate]);
            })
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
