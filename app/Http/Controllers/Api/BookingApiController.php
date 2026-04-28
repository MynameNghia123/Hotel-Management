<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Contracts\CustomerServiceInterface;
use App\Services\Contracts\RoomServiceInterface;

class BookingApiController extends Controller
{
    public function __construct(
        private readonly CustomerServiceInterface $customerService,
        private readonly RoomServiceInterface $roomService
    ) {}

    /**
     * Verify customer email for creating new booking
     */
    public function verifyCustomer(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->input('email');
        $customer = $this->customerService->findByEmail($email);

        if ($customer) {
            return response()->json([
                'exists' => true,
                'customer' => [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                ]
            ]);
        }

        return response()->json([
            'exists' => false,
            'message' => 'Khách hàng không tồn tại trong hệ thống'
        ]);
    }

    public function availableRooms(Request $request)
    {
        $validated = $request->validate([
            'check_in_date' => ['required', 'date'],
            'check_out_date' => ['required', 'date', 'after:check_in_date'],
        ]);

        $rooms = $this->roomService->getAvailableRooms(
            $validated['check_in_date'],
            $validated['check_out_date']
        );

        return response()->json([
            'rooms' => $rooms->map(function ($room) {
                return [
                    'id' => $room->id,
                    'name' => $room->name,
                    'room_type' => $room->roomType->name ?? 'N/A',
                    'room_type_code' => strtoupper($room->roomType->code ?? $room->roomType->name ?? ''),
                    'floor_name' => $room->floor->name ?? '',
                    'hourly_price' => (float) ($room->roomType->hourly_price ?? 0),
                    'daily_price' => (float) ($room->roomType->daily_price ?? 0),
                ];
            })->values(),
        ]);
    }
}
