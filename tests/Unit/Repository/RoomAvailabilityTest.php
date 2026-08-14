<?php

namespace Tests\Unit\Repository;

use App\Enums\BookingStatus;
use App\Enums\RoomStatus;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Customer;
use App\Models\Floor;
use App\Models\Room;
use App\Models\RoomType;
use App\Repositories\Implementations\EloquentRoomRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoomAvailabilityTest extends TestCase
{
    use RefreshDatabase;

    private EloquentRoomRepository $repository;

    private Room $room1;

    private Room $room2;

    private Room $room3;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new EloquentRoomRepository(new Room);

        // Create base data
        $floor = Floor::create(['name' => 'Floor 1']);
        $roomType = RoomType::create([
            'name' => 'Standard',
            'code' => 'STD',
            'adult_quantity' => 2,
            'child_quantity' => 1,
            'single_bed_quantity' => 1,
            'double_bed_quantity' => 0,
            'width' => 5,
            'height' => 5,
            'hourly_price' => 100000,
            'daily_price' => 500000,
            'is_active' => true,
        ]);

        $this->room1 = Room::create([
            'room_type_id' => $roomType->id,
            'floor_id' => $floor->id,
            'name' => '101',
            'status' => RoomStatus::EMPTY->value,
        ]);

        $this->room2 = Room::create([
            'room_type_id' => $roomType->id,
            'floor_id' => $floor->id,
            'name' => '102',
            'status' => RoomStatus::EMPTY->value,
        ]);

        $this->room3 = Room::create([
            'room_type_id' => $roomType->id,
            'floor_id' => $floor->id,
            'name' => '103',
            'status' => RoomStatus::EMPTY->value,
        ]);
    }

    private function createBooking(Room $room, string $checkin, string $checkout, BookingStatus $status): void
    {
        $customer = Customer::create([
            'first_name' => 'Test',
            'last_name' => 'Customer',
            'email' => uniqid().'@example.com',
            'phone_number' => uniqid(),
        ]);

        $booking = Booking::create([
            'customer_id' => $customer->id,
            'booking_date' => now(),
            'total_service_amount' => 0,
            'total_room_amount' => 500000,
            'surcharge_amount' => 0,
            'final_amount' => 500000,
            'status' => $status->value,
        ]);

        BookingDetail::create([
            'booking_id' => $booking->id,
            'room_id' => $room->id,
            'checkin_date' => $checkin,
            'checkout_date' => $checkout,
            'hourly_price' => 100000,
            'daily_price' => 500000,
            'room_amount' => 500000,
            'service_amount' => 0,
            'surcharge_amount' => 0,
            'payment_status' => 'unpaid',
        ]);
    }

    public function test_it_returns_available_rooms_when_no_booking_exists()
    {
        $checkIn = Carbon::now()->addDays(1)->toDateString();
        $checkOut = Carbon::now()->addDays(3)->toDateString();

        $availableRooms = $this->repository->getAvailableRooms($checkIn, $checkOut);

        $this->assertCount(3, $availableRooms);
        $this->assertTrue($availableRooms->contains('id', $this->room1->id));
        $this->assertTrue($availableRooms->contains('id', $this->room2->id));
        $this->assertTrue($availableRooms->contains('id', $this->room3->id));
    }

    public function test_it_excludes_rooms_with_overlapping_active_bookings()
    {
        $checkIn = Carbon::now()->addDays(1)->toDateString();
        $checkOut = Carbon::now()->addDays(3)->toDateString();

        // room1 has overlapping booking (PENDING)
        $this->createBooking(
            $this->room1,
            Carbon::now()->addDays(1)->toDateString(),
            Carbon::now()->addDays(2)->toDateString(),
            BookingStatus::PENDING
        );

        // room2 has overlapping booking (CONFIRMED)
        $this->createBooking(
            $this->room2,
            Carbon::now()->addDays(2)->toDateString(),
            Carbon::now()->addDays(4)->toDateString(),
            BookingStatus::CONFIRMED
        );

        $availableRooms = $this->repository->getAvailableRooms($checkIn, $checkOut);

        $this->assertCount(1, $availableRooms);
        $this->assertTrue($availableRooms->contains('id', $this->room3->id));
    }

    public function test_it_includes_rooms_whose_bookings_are_cancelled_or_paid()
    {
        $checkIn = Carbon::now()->addDays(1)->toDateString();
        $checkOut = Carbon::now()->addDays(3)->toDateString();

        // room1 has overlapping booking, but it's CANCELLED
        $this->createBooking(
            $this->room1,
            Carbon::now()->addDays(1)->toDateString(),
            Carbon::now()->addDays(2)->toDateString(),
            BookingStatus::CANCELLED
        );

        // room2 has overlapping booking, but it's PAID
        $this->createBooking(
            $this->room2,
            Carbon::now()->addDays(2)->toDateString(),
            Carbon::now()->addDays(4)->toDateString(),
            BookingStatus::PAID
        );

        $availableRooms = $this->repository->getAvailableRooms($checkIn, $checkOut);

        // All 3 rooms should be available
        $this->assertCount(3, $availableRooms);
        $this->assertTrue($availableRooms->contains('id', $this->room1->id));
        $this->assertTrue($availableRooms->contains('id', $this->room2->id));
        $this->assertTrue($availableRooms->contains('id', $this->room3->id));
    }
}
