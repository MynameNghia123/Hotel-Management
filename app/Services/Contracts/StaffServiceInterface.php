<?php

namespace App\Services\Contracts;

interface StaffServiceInterface extends BaseServiceInterface
{
    /**
     * Toggle active status of a staff member.
     * Returns the success message string.
     */
    public function toggleStatus($id, $isActive): string;
}
