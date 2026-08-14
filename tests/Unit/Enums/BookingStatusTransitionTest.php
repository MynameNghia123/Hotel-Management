<?php

namespace Tests\Unit\Enums;

use App\Enums\BookingStatus;
use PHPUnit\Framework\TestCase;

class BookingStatusTransitionTest extends TestCase
{
    public function test_it_allows_valid_status_transitions()
    {
        // PENDING -> CONFIRMED
        $this->assertTrue(BookingStatus::PENDING->canTransitionTo(BookingStatus::CONFIRMED));

        // PENDING -> CANCELLED
        $this->assertTrue(BookingStatus::PENDING->canTransitionTo(BookingStatus::CANCELLED));

        // CONFIRMED -> OCCUPIED
        $this->assertTrue(BookingStatus::CONFIRMED->canTransitionTo(BookingStatus::OCCUPIED));

        // CONFIRMED -> CANCELLED
        $this->assertTrue(BookingStatus::CONFIRMED->canTransitionTo(BookingStatus::CANCELLED));

        // OCCUPIED -> PAID
        $this->assertTrue(BookingStatus::OCCUPIED->canTransitionTo(BookingStatus::PAID));
    }

    public function test_it_rejects_invalid_status_transitions()
    {
        // PENDING -> OCCUPIED (must go through CONFIRMED first)
        $this->assertFalse(BookingStatus::PENDING->canTransitionTo(BookingStatus::OCCUPIED));

        // PENDING -> PAID
        $this->assertFalse(BookingStatus::PENDING->canTransitionTo(BookingStatus::PAID));

        // CONFIRMED -> PENDING (cannot go backwards)
        $this->assertFalse(BookingStatus::CONFIRMED->canTransitionTo(BookingStatus::PENDING));

        // OCCUPIED -> PENDING
        $this->assertFalse(BookingStatus::OCCUPIED->canTransitionTo(BookingStatus::PENDING));

        // OCCUPIED -> CANCELLED (already checked in, cannot cancel)
        $this->assertFalse(BookingStatus::OCCUPIED->canTransitionTo(BookingStatus::CANCELLED));

        // PAID -> CANCELLED (already paid)
        $this->assertFalse(BookingStatus::PAID->canTransitionTo(BookingStatus::CANCELLED));

        // PAID -> ANY (terminal state)
        $this->assertFalse(BookingStatus::PAID->canTransitionTo(BookingStatus::PENDING));
        $this->assertFalse(BookingStatus::PAID->canTransitionTo(BookingStatus::CONFIRMED));
        $this->assertFalse(BookingStatus::PAID->canTransitionTo(BookingStatus::OCCUPIED));

        // CANCELLED -> ANY (terminal state)
        $this->assertFalse(BookingStatus::CANCELLED->canTransitionTo(BookingStatus::PENDING));
        $this->assertFalse(BookingStatus::CANCELLED->canTransitionTo(BookingStatus::CONFIRMED));
        $this->assertFalse(BookingStatus::CANCELLED->canTransitionTo(BookingStatus::OCCUPIED));
        $this->assertFalse(BookingStatus::CANCELLED->canTransitionTo(BookingStatus::PAID));
    }
}
