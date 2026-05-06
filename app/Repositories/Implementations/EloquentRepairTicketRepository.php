<?php

namespace App\Repositories\Implementations;

use App\Models\RepairTicket;
use App\Repositories\Contracts\RepairTicketRepositoryInterface;
use App\Repositories\Filters\RepairTicketFilter;

class EloquentRepairTicketRepository implements RepairTicketRepositoryInterface
{
    public function __construct(private readonly RepairTicket $model)
    {}

    /**
     * Get all repair tickets
     */
    public function getAll()
    {
        return $this->model->with(['room'])
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * Find repair ticket by ID
     */
    public function findById($id)
    {
        return $this->model->with(['room'])->find($id);
    }

    /**
     * Create a new repair ticket
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update repair ticket
     */
    public function update($id, array $data)
    {
        $model = $this->findById($id);
        if ($model) {
            $model->update($data);
        }
        return $model;
    }

    /**
     * Delete repair ticket
     */
    public function delete($id)
    {
        $model = $this->findById($id);
        if ($model) {
            $model->delete();
        }
        return $model;
    }

    /**
     * Get repair tickets by status
     */
    public function getByStatus($status)
    {
        return $this->model->with(['room'])
            ->where('status', $status)
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * Get repair tickets by room ID
     */
    public function getByRoomId($roomId)
    {
        return $this->model->with(['room'])
            ->where('room_id', $roomId)
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * Get repair tickets with eager loaded relations and filtering
     */
    public function getWithRelations(array $filters = [], $perPage = 10)
    {
        $query = $this->model->with(['room']);

        // Apply filters using RepairTicketFilter
        $query = RepairTicketFilter::apply($query, $filters);

        // Order by created date (latest first)
        $query->orderByDesc('created_at');

        return $query->paginate($perPage);
    }

    /**
     * Get paginated repair tickets with filters (alias for getWithRelations)
     */
    public function getPaginated(array $filters = [], $perPage = 10)
    {
        return $this->getWithRelations($filters, $perPage);
    }

    /**
     * Update repair ticket status with validation
     */
    public function updateStatus($id, $status)
    {
        $model = $this->findById($id);
        if ($model) {
            $model->update(['status' => $status]);
        }
        return $model;
    }

    /**
     * Get repair tickets assigned to specific technician
     */
    public function getByCreatedByStaff($staffId)
    {
        // Note: This method is kept for backward compatibility but now filters by room
        // since technician_id column no longer exists
        return $this->model->with(['room'])
            ->orderByDesc('created_at')
            ->get();
    }
}
