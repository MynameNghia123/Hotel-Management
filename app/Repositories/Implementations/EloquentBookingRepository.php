<?php

namespace App\Repositories\Implementations;

use App\Models\Booking;
use App\Models\BookingDetail;
use App\Repositories\Filters\BookingFilter;
use App\Repositories\Contracts\BookingRepositoryInterface;

class EloquentBookingRepository implements BookingRepositoryInterface
{
    protected $model;

    public function __construct(Booking $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->with('customer', 'bookingDetails.room')->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function findById($id)
    {
        return $this->model->with('customer', 'bookingDetails.room')->findOrFail($id);
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
        $query = $this->model->with('customer', 'bookingDetails.room');

        $query = BookingFilter::apply($query, $filters);

        return $query->paginate($perPage);
    }

    public function getByStatus($status)
    {
        return $this->model->where('status', $status)
            ->with('customer', 'bookingDetails.room')
            ->get();
    }

    public function getByCustomerId($customerId)
    {
        return $this->model->where('customer_id', $customerId)
            ->with('customer', 'bookingDetails.room')
            ->get();
    }

    public function getWithRooms(array $filters = [], $perPage = 10)
    {
        $query = $this->model->with('customer', 'bookingDetails.room');

        $query = BookingFilter::apply($query, $filters);

        return $query->paginate($perPage);
    }

    public function checkRoomAvailability($roomId, $checkInDate, $checkOutDate)
    {
        return !$this->model
            ->whereHas('bookingDetails', function($q) use ($roomId) {
                $q->where('room_id', $roomId);
            })
            ->where(function($q) use ($checkInDate, $checkOutDate) {
                $q->where('check_in_date', '<', $checkOutDate)
                  ->where('check_out_date', '>', $checkInDate);
            })
            ->whereIn('status', ['confirmed', 'occupied'])
            ->exists();
    }

    public function updateStatus($id, $status)
    {
        $record = $this->findById($id);
        $record->status = $status;
        $record->save();
        return $record;
    }
}
