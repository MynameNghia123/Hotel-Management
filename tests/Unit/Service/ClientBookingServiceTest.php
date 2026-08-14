<?php

namespace Tests\Unit\Service;

use App\Actions\CreateBookingAction;
use App\Repositories\Contracts\ClientBookingRepositoryInterface;
use App\Services\Contracts\CustomerServiceInterface;
use App\Services\Contracts\RoomServiceInterface;
use App\Services\Implementations\ClientBookingService;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ClientBookingServiceTest extends TestCase
{
    private ClientBookingService $service;

    protected function setUp(): void
    {
        parent::setUp();

        // We can mock dependencies since we are only testing buildCheckoutCart logic
        $roomService = $this->createMock(RoomServiceInterface::class);
        $createBookingAction = $this->createMock(CreateBookingAction::class);
        $clientBookingRepository = $this->createMock(ClientBookingRepositoryInterface::class);
        $customerService = $this->createMock(CustomerServiceInterface::class);

        $this->service = new ClientBookingService(
            $roomService,
            $createBookingAction,
            $clientBookingRepository,
            $customerService
        );
    }

    public function test_it_throws_exception_when_checkout_before_checkin()
    {
        $payload = [
            'checkin' => '2026-08-20',
            'checkout' => '2026-08-19', // Checkout before checkin
            'room_qty' => [
                '1' => '1',
            ],
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Ngay tra phong phai sau ngay nhan phong.');

        $this->service->buildCheckoutCart($payload);
    }

    public function test_it_throws_exception_when_checkout_equals_checkin()
    {
        $payload = [
            'checkin' => '2026-08-20',
            'checkout' => '2026-08-20', // Checkout equals checkin
            'room_qty' => [
                '1' => '1',
            ],
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Ngay tra phong phai sau ngay nhan phong.');

        $this->service->buildCheckoutCart($payload);
    }
}
