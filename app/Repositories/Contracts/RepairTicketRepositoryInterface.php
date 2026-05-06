<?php

namespace App\Repositories\Contracts;

interface RepairTicketRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get repair tickets by status
     */
    public function getByStatus($status);

    /**
     * Get repair tickets by room ID
     */
    public function getByRoomId($roomId);

    /**
     * Get repair tickets with related data (rooms, staff, etc.)
     */
    public function getWithRelations(array $filters = [], $perPage = 10);

    /**
     * Get paginated repair tickets with filters
     */
    public function getPaginated(array $filters = [], $perPage = 10);

    /**
     * Update repair ticket status
     */
    public function updateStatus($id, $status);

    /**
     * Get repair tickets created by specific staff member
     */
    public function getByCreatedByStaff($staffId);
}
