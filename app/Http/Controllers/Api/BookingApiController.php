<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Contracts\CustomerServiceInterface;

class BookingApiController extends Controller
{
    public function __construct(
        private readonly CustomerServiceInterface $customerService
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
}
