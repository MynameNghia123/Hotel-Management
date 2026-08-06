<?php

namespace App\Services\Implementations;

use App\Actions\CreateBookingAction;
use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Customer;
use App\Repositories\Contracts\ClientBookingRepositoryInterface;
use App\Services\Contracts\ClientBookingServiceInterface;
use App\Services\Contracts\CustomerServiceInterface;
use App\Services\Contracts\RoomServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use RuntimeException;

class ClientBookingService implements ClientBookingServiceInterface
{
    public function __construct(
        private readonly RoomServiceInterface $roomService,
        private readonly CreateBookingAction $createBookingAction,
        private readonly ClientBookingRepositoryInterface $clientBookingRepository,
        private readonly CustomerServiceInterface $customerService
    ) {
    }

    public function buildCheckoutCart(array $payload): array
    {
        $today = now()->startOfDay();
        $checkIn = $this->parseDate($payload['checkin'] ?? null, $today);
        $checkOut = $this->parseDate($payload['checkout'] ?? null, $checkIn->copy()->addDay());

        if ($checkOut->lessThanOrEqualTo($checkIn)) {
            throw new InvalidArgumentException('Ngay tra phong phai sau ngay nhan phong.');
        }

        $roomQtys = $payload['room_qty'] ?? [];
        $selectedRooms = [];

        foreach ($roomQtys as $roomTypeId => $qty) {
            $roomTypeId = (int) $roomTypeId;
            $qty = (int) $qty;

            if ($roomTypeId > 0 && $qty > 0) {
                $selectedRooms[$roomTypeId] = $qty;
            }
        }

        if (empty($selectedRooms)) {
            throw new InvalidArgumentException('Vui long chon it nhat 1 phong.');
        }

        return [
            'checkin' => $checkIn->toDateString(),
            'checkout' => $checkOut->toDateString(),
            'rooms' => $selectedRooms,
        ];
    }

    public function prepareCheckoutData(array $cart): array
    {
        if (!isset($cart['checkin'], $cart['checkout'], $cart['rooms']) || !is_array($cart['rooms'])) {
            throw new InvalidArgumentException('Gio hang dat phong khong hop le.');
        }

        $checkIn = Carbon::parse($cart['checkin'])->startOfDay();
        $checkOut = Carbon::parse($cart['checkout'])->startOfDay();

        if ($checkOut->lessThanOrEqualTo($checkIn)) {
            throw new InvalidArgumentException('Ngay tra phong phai sau ngay nhan phong.');
        }

        $nights = max(1, $checkIn->diffInDays($checkOut));
        $roomTypeIds = array_map('intval', array_keys($cart['rooms']));
        $roomTypesById = $this->clientBookingRepository
            ->getRoomTypesByIds($roomTypeIds)
            ->keyBy('id');

        $roomDetails = [];
        $totalAmount = 0;

        foreach ($cart['rooms'] as $roomTypeId => $qty) {
            $roomTypeId = (int) $roomTypeId;
            $qty = (int) $qty;

            if ($qty <= 0) {
                continue;
            }

            $roomType = $roomTypesById->get($roomTypeId);
            if (!$roomType) {
                continue;
            }

            $subTotal = (float) $roomType->daily_price * $qty * $nights;
            $totalAmount += $subTotal;

            $roomDetails[] = [
                'roomType' => $roomType,
                'qty' => $qty,
                'subTotal' => $subTotal,
            ];
        }

        if (empty($roomDetails)) {
            throw new InvalidArgumentException('Khong tim thay thong tin hang phong da chon.');
        }

        return [
            'roomDetails' => $roomDetails,
            'totalAmount' => $totalAmount,
            'checkin' => $checkIn,
            'checkout' => $checkOut,
            'nights' => $nights,
        ];
    }

    public function createBookingFromCart(array $cart, array $customerData, ?int $customerId = null): Booking
    {
        if (!isset($cart['checkin'], $cart['checkout'], $cart['rooms']) || !is_array($cart['rooms'])) {
            throw new RuntimeException('Gio hang dat phong khong hop le.');
        }

        $checkIn = Carbon::parse($cart['checkin'])->startOfDay();
        $checkOut = Carbon::parse($cart['checkout'])->startOfDay();

        if ($checkOut->lessThanOrEqualTo($checkIn)) {
            throw new RuntimeException('Ngay tra phong phai sau ngay nhan phong.');
        }

        $nights = max(1, $checkIn->diffInDays($checkOut));
        $availableRooms = $this->roomService->getAvailableRooms(
            $checkIn->toDateString(),
            $checkOut->toDateString()
        );

        $roomIds = [];
        $checkinDates = [];
        $checkoutDates = [];
        $dailyPrices = [];
        $hourlyPrices = [];
        $totalRoomAmount = 0;

        foreach ($cart['rooms'] as $roomTypeId => $qty) {
            $roomTypeId = (int) $roomTypeId;
            $qty = (int) $qty;

            if ($qty <= 0) {
                continue;
            }

            $roomsOfType = $availableRooms
                ->where('room_type_id', $roomTypeId)
                ->take($qty);

            if ($roomsOfType->count() < $qty) {
                throw new RuntimeException('Khong du phong trong cho loai phong ban chon. Vui long tim kiem lai.');
            }

            foreach ($roomsOfType as $room) {
                $roomIds[] = $room->id;
                $checkinDates[] = $checkIn->toDateString();
                $checkoutDates[] = $checkOut->toDateString();
                $dailyPrices[] = (float) $room->roomType->daily_price;
                $hourlyPrices[] = (float) $room->roomType->hourly_price;

                $totalRoomAmount += (float) $room->roomType->daily_price * $nights;
            }
        }

        if (empty($roomIds)) {
            throw new RuntimeException('Vui long chon it nhat 1 phong.');
        }

        $bookingData = [
            'booking_date' => now()->format('Y-m-d H:i:s'),
            'room_ids' => $roomIds,
            'checkin_dates' => $checkinDates,
            'checkout_dates' => $checkoutDates,
            'daily_prices' => $dailyPrices,
            'hourly_prices' => $hourlyPrices,
            'total_room_amount' => $totalRoomAmount,
            'total_service_amount' => 0,
            'surcharge_amount' => 0,
            'final_amount' => $totalRoomAmount,
        ];

        if ($customerId) {
            $bookingData['customer_id'] = $customerId;
        } else {
            $email = mb_strtolower(trim((string) ($customerData['email'] ?? '')));
            if ($email === '') {
                throw new RuntimeException('Vui long nhap email khach hang.');
            }

            $existingCustomer = $this->findCustomerByEmail($email);

            if ($existingCustomer) {
                $bookingData['customer_id'] = (int) $existingCustomer->id;
            } else {
                $firstName = trim((string) ($customerData['first_name'] ?? ''));
                $lastName = trim((string) ($customerData['last_name'] ?? ''));
                $phone = trim((string) ($customerData['phone'] ?? ''));
                $country = trim((string) ($customerData['country'] ?? ''));

                if ($firstName === '' || $lastName === '' || $phone === '') {
                    throw new RuntimeException('Vui long nhap day du ho, ten va so dien thoai de tao khach hang moi.');
                }

                $bookingData['customer_new_email'] = $email;
                $bookingData['customer_first_name'] = $firstName;
                $bookingData['customer_last_name'] = $lastName;
                $bookingData['customer_phone'] = $phone;
                $bookingData['customer_country'] = $country !== '' ? $country : null;
            }
        }

        return $this->createBookingAction->execute($bookingData);
    }

    public function getBookingForPayment(int $bookingId): ?Booking
    {
        return $this->clientBookingRepository->findBookingForPayment($bookingId);
    }

    public function createVnpayPaymentUrl(Booking $booking, ?string $bankCode, string $ipAddress): string
    {
        $vnpUrl = (string) config('services.vnpay.url');
        $vnpReturnUrl = (string) config('services.vnpay.return_url');
        $vnpTmnCode = trim((string) config('services.vnpay.tmn_code'));
        $vnpHashSecret = trim((string) config('services.vnpay.hash_secret'));

        if ($vnpUrl === '' || $vnpReturnUrl === '' || $vnpTmnCode === '' || $vnpHashSecret === '') {
            throw new RuntimeException('Cau hinh VNPAY chua day du.');
        }

        $txnRef = $booking->id . '_' . time();
        $inputData = [
            'vnp_Version' => '2.1.0',
            'vnp_TmnCode' => $vnpTmnCode,
            'vnp_Amount' => (int) round((float) $booking->final_amount * 100),
            'vnp_Command' => 'pay',
            'vnp_CreateDate' => date('YmdHis'),
            'vnp_CurrCode' => 'VND',
            'vnp_IpAddr' => $ipAddress,
            'vnp_Locale' => 'vn',
            'vnp_OrderInfo' => 'Thanh toan dat phong Urban Luxe Hotel cho booking ' . $booking->id,
            'vnp_OrderType' => 'billpayment',
            'vnp_ReturnUrl' => $vnpReturnUrl,
            'vnp_TxnRef' => $txnRef,
        ];

        if ($bankCode) {
            $inputData['vnp_BankCode'] = trim($bankCode);
        }

        ksort($inputData);

        $hashData = '';
        $query = '';
        $i = 0;
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . '=' . urlencode($value);
            } else {
                $hashData .= urlencode($key) . '=' . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . '=' . urlencode($value) . '&';
        }

        $vnpUrl = $vnpUrl . '?' . $query;
        $secureHash = hash_hmac('sha512', $hashData, $vnpHashSecret);
        $vnpUrl .= 'vnp_SecureHash=' . $secureHash;

        return $vnpUrl;
    }

    public function handleVnpayReturn(array $payload): array
    {
        $vnpHashSecret = trim((string) config('services.vnpay.hash_secret'));
        if ($vnpHashSecret === '') {
            return [
                'ok' => false,
                'route' => 'payment',
                'message' => 'Cau hinh VNPAY khong hop le.',
            ];
        }

        $inputData = [];
        foreach ($payload as $key => $value) {
            if (str_starts_with((string) $key, 'vnp_')) {
                $inputData[$key] = $value;
            }
        }

        $vnpSecureHash = (string) ($inputData['vnp_SecureHash'] ?? '');
        unset($inputData['vnp_SecureHash'], $inputData['vnp_SecureHashType']);

        if ($vnpSecureHash === '') {
            return [
                'ok' => false,
                'route' => 'payment',
                'message' => 'Chu ky VNPAY khong hop le.',
            ];
        }

        ksort($inputData);
        $hashData = '';
        $i = 0;
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . '=' . urlencode($value);
            } else {
                $hashData .= urlencode($key) . '=' . urlencode($value);
                $i = 1;
            }
        }
        $calculatedHash = hash_hmac('sha512', $hashData, $vnpHashSecret);

        $txnRef = (string) ($payload['vnp_TxnRef'] ?? '');
        $txnRefParts = explode('_', $txnRef);
        $bookingId = (int) ($txnRefParts[0] ?? 0);

        if ($bookingId <= 0) {
            return [
                'ok' => false,
                'route' => 'payment',
                'message' => 'Khong xac dinh duoc don dat phong.',
            ];
        }

        if (!hash_equals($calculatedHash, $vnpSecureHash)) {
            return [
                'ok' => false,
                'route' => 'payment',
                'message' => 'Chu ky VNPAY khong hop le. Vui long thu lai.',
            ];
        }

        if (($payload['vnp_ResponseCode'] ?? null) !== '00') {
            return [
                'ok' => false,
                'route' => 'payment',
                'message' => 'Giao dich khong thanh cong hoac bi huy (Ma loi: ' . ($payload['vnp_ResponseCode'] ?? 'N/A') . ')',
            ];
        }

        $booking = $this->clientBookingRepository->findBookingById($bookingId);
        if (!$booking) {
            return [
                'ok' => false,
                'route' => 'home',
                'message' => 'Khong tim thay don dat phong.',
            ];
        }

        $transactionCode = (string) ($payload['vnp_TransactionNo'] ?? '');
        $amount = ((float) ($payload['vnp_Amount'] ?? 0)) / 100;

        DB::transaction(function () use ($bookingId, $transactionCode, $amount) {
            $this->clientBookingRepository->updateBookingStatus(
                $bookingId,
                BookingStatus::CONFIRMED->value
            );

            if ($transactionCode !== '' && !$this->clientBookingRepository->paymentTransactionExists($bookingId, $transactionCode)) {
                $this->clientBookingRepository->createPayment([
                    'booking_id' => $bookingId,
                    'amount' => $amount,
                    'payment_method' => 'vnpay',
                    'transaction_code' => $transactionCode,
                    'note' => 'Thanh toan truc tuyen qua VNPAY',
                ]);
            }
        });

        return [
            'ok' => true,
            'route' => 'success',
            'booking_id' => $bookingId,
            'message' => 'Thanh toan dat phong thanh cong!',
        ];
    }

    public function getBookingForSuccess(int $bookingId): ?Booking
    {
        return $this->clientBookingRepository->findBookingForSuccess($bookingId);
    }

    public function findCustomerByEmail(string $email): ?Customer
    {
        $normalizedEmail = mb_strtolower(trim($email));
        if ($normalizedEmail === '') {
            return null;
        }

        return $this->customerService->findByEmail($normalizedEmail);
    }

    private function parseDate(?string $value, Carbon $fallback): Carbon
    {
        if (!$value) {
            return $fallback->copy();
        }

        try {
            return Carbon::parse($value)->startOfDay();
        } catch (\Throwable) {
            return $fallback->copy();
        }
    }

}
