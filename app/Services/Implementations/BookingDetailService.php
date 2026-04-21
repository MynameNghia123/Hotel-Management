<?php

namespace App\Services\Implementations;

use App\Repositories\Contracts\BookingDetailRepositoryInterface;
use App\Services\Contracts\BookingDetailServiceInterface;

class BookingDetailService implements BookingDetailServiceInterface
{
    public function __construct(
        private readonly BookingDetailRepositoryInterface $bookingDetailRepository
    ) {}

    public function getAll()
    {
        return $this->bookingDetailRepository->getAll();
    }

    public function create(array $data)
    {
        return $this->bookingDetailRepository->create($data);
    }

    public function findById($id)
    {
        return $this->bookingDetailRepository->findById($id);
    }

    public function update($id, array $data)
    {
        return $this->bookingDetailRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->bookingDetailRepository->delete($id);
    }

    public function getPaginated(array $filters = [], $perPage = 10)
    {
        return $this->bookingDetailRepository->getPaginated($filters, $perPage);
    }

    public function getByBookingId($bookingId)
    {
        return $this->bookingDetailRepository->getByBookingId($bookingId);
    }

    public function createMultiple($bookingId, array $roomIds)
    {
        return $this->bookingDetailRepository->createMultiple($bookingId, $roomIds);
    }

    public function getWithRooms($bookingId)
    {
        return $this->bookingDetailRepository->getWithRooms($bookingId);
    }
}
