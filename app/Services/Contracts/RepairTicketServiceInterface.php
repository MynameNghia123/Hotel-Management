<?php

namespace App\Services\Contracts;

interface RepairTicketServiceInterface extends BaseServiceInterface
{
    /**
     * Get all repair tickets with relations
     */
    public function getAllWithRelations(array $filters = [], $perPage = 10);

    /**
     * Get paginated repair tickets with filters
     */
    public function getPaginated(array $filters = [], $perPage = 10);

    /**
     * Get repair tickets by status
     */
    public function getByStatus($status);

    /**
     * Get repair tickets by room ID
     */
    public function getByRoomId($roomId);

    /**
     * Get repair tickets created by specific staff
     */
    public function getByCreatedByStaff($staffId);

    /**
     * Transition repair ticket status with validation
     */
    public function transitionStatus($id, $newStatusValue, $notes = null);
}
