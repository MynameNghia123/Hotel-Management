<?php

namespace App\Services\Contracts;

use App\Models\Booking;
use App\Models\Customer;

interface ClientBookingServiceInterface
{
    public function buildCheckoutCart(array $payload): array;

    public function prepareCheckoutData(array $cart): array;

    public function findCustomerByEmail(string $email): ?Customer;

    public function createBookingFromCart(array $cart, array $customerData, ?int $customerId = null): Booking;

    public function getBookingForPayment(int $bookingId): ?Booking;

    public function createVnpayPaymentUrl(Booking $booking, ?string $bankCode, string $ipAddress): string;

    public function handleVnpayReturn(array $payload): array;

    public function getBookingForSuccess(int $bookingId): ?Booking;
}
