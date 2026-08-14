<?php

namespace App\Services\Implementations;

use App\Enums\RoomStatus;
use App\Http\Requests\RepairTicket\UpdateRepairTicketStatusRequest;
use App\Models\Room;
use App\Repositories\Contracts\RepairTicketRepositoryInterface;
use App\Services\Contracts\RepairTicketServiceInterface;

class RepairTicketService implements RepairTicketServiceInterface
{
    public function __construct(
        private readonly RepairTicketRepositoryInterface $repairTicketRepository
    ) {}

    /**
     * Get all repair tickets with eager loaded relations
     */
    public function getAll()
    {
        return $this->repairTicketRepository->getAll();
    }

    /**
     * Get all repair tickets with relations and pagination
     */
    public function getAllWithRelations(array $filters = [], $perPage = 10)
    {
        return $this->repairTicketRepository->getWithRelations($filters, $perPage);
    }

    /**
     * Get paginated repair tickets with filters
     */
    public function getPaginated(array $filters = [], $perPage = 10)
    {
        return $this->repairTicketRepository->getPaginated($filters, $perPage);
    }

    /**
     * Find repair ticket by ID with relations
     */
    public function findById($id)
    {
        return $this->repairTicketRepository->findById($id);
    }

    /**
     * Create a new repair ticket and set room status to maintenance
     */
    public function create(array $data)
    {
        $repairTicket = $this->repairTicketRepository->create($data);

        // Automatically set room status to maintenance when creating repair ticket
        if ($repairTicket && isset($data['room_id'])) {
            $room = Room::find($data['room_id']);
            if ($room) {
                $room->update(['status' => RoomStatus::MAINTENANCE->value]);
            }
        }

        return $repairTicket;
    }

    /**
     * Update repair ticket data
     */
    public function update($id, array $data)
    {
        return $this->repairTicketRepository->update($id, $data);
    }

    /**
     * Delete repair ticket
     */
    public function delete($id)
    {
        return $this->repairTicketRepository->delete($id);
    }

    /**
     * Get repair tickets by specific status
     */
    public function getByStatus($status)
    {
        return $this->repairTicketRepository->getByStatus($status);
    }

    /**
     * Get repair tickets for specific room
     */
    public function getByRoomId($roomId)
    {
        return $this->repairTicketRepository->getByRoomId($roomId);
    }

    /**
     * Transition repair ticket status with validation
     */
    public function transitionStatus($id, $newStatusValue, $notes = null)
    {
        $ticket = $this->repairTicketRepository->findById($id);

        if (! $ticket) {
            return [
                'success' => false,
                'message' => 'Phiếu sửa chữa không tồn tại',
            ];
        }

        // Validate status transition using request validation logic
        $validation = UpdateRepairTicketStatusRequest::validateTransition($ticket, $newStatusValue);

        if (! $validation['success']) {
            return $validation;
        }

        // Update status and notes if provided
        $updateData = ['status' => $newStatusValue];
        if ($notes) {
            $updateData['technician_note'] = $notes;
        }

        $this->repairTicketRepository->updateStatus($id, $newStatusValue);

        // Automatically set room status to EMPTY when ticket is completed
        if ($newStatusValue === 'completed' && $ticket->room_id) {
            $room = Room::find($ticket->room_id);
            if ($room) {
                $room->update(['status' => RoomStatus::EMPTY->value]);
            }
        }

        return [
            'success' => true,
            'message' => sprintf(
                'Cập nhật trạng thái thành %s thành công',
                $validation['status']->label()
            ),
        ];
    }

    /**
     * Get repair tickets assigned to specific staff member
     */
    public function getByCreatedByStaff($staffId)
    {
        return $this->repairTicketRepository->getByCreatedByStaff($staffId);
    }
}
