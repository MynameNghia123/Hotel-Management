<?php

namespace Tests\Feature\Booking;

use App\Actions\CreateBookingAction;
use App\Enums\RoomStatus;
use App\Models\Customer;
use App\Models\Floor;
use App\Models\Room;
use App\Models\RoomType;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateBookingActionTest extends TestCase
{
    use RefreshDatabase;

    private CreateBookingAction $action;

    private Room $room;

    private Customer $customer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->action = $this->app->make(CreateBookingAction::class);

        // Setup base data
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

        $this->room = Room::create([
            'room_type_id' => $roomType->id,
            'floor_id' => $floor->id,
            'name' => '101',
            'status' => RoomStatus::EMPTY->value,
        ]);

        $this->customer = Customer::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone_number' => '0123456789',
        ]);
    }

    public function test_it_creates_booking_successfully_for_available_room()
    {
        $checkin = now()->addDays(1)->toDateString();
        $checkout = now()->addDays(3)->toDateString();

        $validatedData = [
            'customer_id' => $this->customer->id,
            'room_ids' => [$this->room->id],
            'checkin_dates' => [$checkin],
            'checkout_dates' => [$checkout],
            'hourly_prices' => [100000],
            'daily_prices' => [500000],
            'booking_date' => now()->format('Y-m-d H:i:s'),
            'total_service_amount' => 0,
            'total_room_amount' => 1000000,
            'surcharge_amount' => 0,
            'final_amount' => 1000000,
        ];

        $booking = $this->action->execute($validatedData);

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'customer_id' => $this->customer->id,
            'final_amount' => 1000000,
        ]);

        $this->assertDatabaseHas('booking_details', [
            'booking_id' => $booking->id,
            'room_id' => $this->room->id,
            'checkin_date' => $checkin.' 00:00:00', // SQLite stores as datetime string
            'checkout_date' => $checkout.' 00:00:00',
        ]);

        $this->assertDatabaseHas('rooms', [
            'id' => $this->room->id,
            'status' => RoomStatus::BOOKED->value,
        ]);
    }

    public function test_it_throws_exception_when_room_is_already_booked()
    {
        $checkin = now()->addDays(1)->toDateString();
        $checkout = now()->addDays(3)->toDateString();

        $validatedData = [
            'customer_id' => $this->customer->id,
            'room_ids' => [$this->room->id],
            'checkin_dates' => [$checkin],
            'checkout_dates' => [$checkout],
            'hourly_prices' => [100000],
            'daily_prices' => [500000],
            'booking_date' => now()->format('Y-m-d H:i:s'),
            'total_service_amount' => 0,
            'total_room_amount' => 1000000,
            'surcharge_amount' => 0,
            'final_amount' => 1000000,
        ];

        // First booking succeeds
        $this->action->execute($validatedData);

        // Second booking for the same dates and room should fail
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Phòng {$this->room->name} đã có lịch trong khoảng ngày đã chọn. Vui lòng chọn phòng khác.");

        $this->action->execute($validatedData);
    }
}
