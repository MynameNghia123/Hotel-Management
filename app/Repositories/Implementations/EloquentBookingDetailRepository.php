<?php

namespace App\Repositories\Implementations;

use App\Models\BookingDetail;
use App\Repositories\Contracts\BookingDetailRepositoryInterface;

class EloquentBookingDetailRepository implements BookingDetailRepositoryInterface
{
    protected $model;

    public function __construct(BookingDetail $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->with('booking', 'room')->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function findById($id)
    {
        return $this->model->with('booking', 'room')->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $record = $this->findById($id);
        $record->update($data);

        return $record;
    }

    public function delete($id)
    {
        $record = $this->findById($id);

        return $record->delete();
    }

    public function getPaginated(array $filters = [], $perPage = 10)
    {
        $query = $this->model->with('booking', 'room');

        return $query->paginate($perPage);
    }

    public function getByBookingId($bookingId)
    {
        return $this->model
            ->where('booking_id', $bookingId)
            ->with('room')
            ->get();
    }

    public function createMultiple($bookingId, array $roomIds)
    {
        $records = [];
        foreach ($roomIds as $roomId) {
            $records[] = $this->model->create([
                'booking_id' => $bookingId,
                'room_id' => $roomId,
            ]);
        }

        return $records;
    }

    public function getWithRooms($bookingId)
    {
        return $this->model
            ->where('booking_id', $bookingId)
            ->with('room')
            ->get();
    }
}
