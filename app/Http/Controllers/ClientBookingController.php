<?php

namespace App\Http\Controllers;

use App\Actions\CreateBookingAction;
use App\Models\RoomType;
use App\Services\Contracts\RoomServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientBookingController extends Controller
{
    private $roomService;
    private $createBookingAction;

    public function __construct(
        RoomServiceInterface $roomService,
        CreateBookingAction $createBookingAction
    ) {
        $this->roomService = $roomService;
        $this->createBookingAction = $createBookingAction;
    }

    public function search(Request $request)
    {
        $checkin = $request->input('checkin', now()->format('Y-m-d'));
        $checkout = $request->input('checkout', now()->addDay()->format('Y-m-d'));
        $guests = $request->input('guests', 1);

        try {
            $checkInAt = Carbon::parse($checkin)->startOfDay();
            $checkOutAt = Carbon::parse($checkout)->startOfDay();
            if ($checkOutAt->lessThanOrEqualTo($checkInAt)) {
                $checkOutAt = $checkInAt->copy()->addDay();
                $checkout = $checkOutAt->format('Y-m-d');
            }
        } catch (\Exception $e) {
            $checkin = now()->format('Y-m-d');
            $checkout = now()->addDay()->format('Y-m-d');
        }

        // Lấy tất cả phòng trống
        $availableRooms = $this->roomService->getAvailableRooms($checkin, $checkout);

        // Gom nhóm theo RoomType
        $availableRoomTypes = $availableRooms->groupBy('room_type_id')->map(function ($rooms) {
            $roomType = $rooms->first()->roomType;
            $roomType->available_count = $rooms->count();
            return $roomType;
        })->values();

        // (Tùy chọn) Lọc theo số khách (nếu adult_quantity >= guests thì hiển thị, v.v)
        // Hiện tại chỉ cần show hết và để khách tự cân nhắc số lượng phòng

        return view('client.pages.search', compact('availableRoomTypes', 'checkin', 'checkout', 'guests'));
    }

    public function initCheckout(Request $request)
    {
        $checkin = $request->input('checkin');
        $checkout = $request->input('checkout');
        $roomQtys = $request->input('room_qty', []); // mảng [room_type_id => quantity]

        $selectedRooms = [];
        foreach ($roomQtys as $roomTypeId => $qty) {
            if ($qty > 0) {
                $selectedRooms[$roomTypeId] = $qty;
            }
        }

        if (empty($selectedRooms)) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất 1 phòng.');
        }

        // Lưu vào session
        session([
            'booking_cart' => [
                'checkin' => $checkin,
                'checkout' => $checkout,
                'rooms' => $selectedRooms
            ]
        ]);

        return redirect()->route('checkout');
    }

    public function checkout()
    {
        $cart = session('booking_cart');
        if (!$cart) {
            return redirect()->route('search')->with('error', 'Giỏ hàng trống. Vui lòng chọn phòng.');
        }

        $checkin = Carbon::parse($cart['checkin']);
        $checkout = Carbon::parse($cart['checkout']);
        $nights = $checkin->diffInDays($checkout);

        $roomDetails = [];
        $totalAmount = 0;

        foreach ($cart['rooms'] as $roomTypeId => $qty) {
            $roomType = RoomType::find($roomTypeId);
            if ($roomType) {
                $subTotal = $roomType->daily_price * $qty * $nights;
                $totalAmount += $subTotal;

                $roomDetails[] = [
                    'roomType' => $roomType,
                    'qty' => $qty,
                    'subTotal' => $subTotal
                ];
            }
        }

        $user = Auth::guard('web')->user();

        return view('client.pages.checkout', compact('roomDetails', 'totalAmount', 'checkin', 'checkout', 'nights', 'user'));
    }

    public function store(Request $request)
    {
        $cart = session('booking_cart');
        if (!$cart) {
            return redirect()->route('search')->with('error', 'Giỏ hàng trống.');
        }

        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
        ]);

        try {
            $checkin = Carbon::parse($cart['checkin']);
            $checkout = Carbon::parse($cart['checkout']);
            $nights = $checkin->diffInDays($checkout);

            // Tìm các room_id thực tế còn trống cho các loại phòng khách đã chọn
            $availableRooms = $this->roomService->getAvailableRooms($cart['checkin'], $cart['checkout']);
            
            $roomIds = [];
            $checkinDates = [];
            $checkoutDates = [];
            $dailyPrices = [];
            $hourlyPrices = [];

            $totalRoomAmount = 0;

            foreach ($cart['rooms'] as $roomTypeId => $qty) {
                $roomsOfType = $availableRooms->where('room_type_id', $roomTypeId)->take($qty);
                
                if ($roomsOfType->count() < $qty) {
                    throw new \Exception("Không đủ phòng trống cho loại phòng bạn chọn. Vui lòng tìm kiếm lại.");
                }

                foreach ($roomsOfType as $room) {
                    $roomIds[] = $room->id;
                    $checkinDates[] = $cart['checkin'];
                    $checkoutDates[] = $cart['checkout'];
                    $dailyPrices[] = $room->roomType->daily_price;
                    $hourlyPrices[] = $room->roomType->hourly_price;
                    
                    $totalRoomAmount += ($room->roomType->daily_price * $nights);
                }
            }

            // Gói dữ liệu để truyền vào CreateBookingAction
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

            // Gắn customer (đã đăng nhập hoặc email mới)
            if (Auth::guard('web')->check()) {
                $bookingData['customer_id'] = Auth::guard('web')->id();
            } else {
                $bookingData['customer_new_email'] = $request->email;
                $bookingData['customer_first_name'] = $request->first_name;
                $bookingData['customer_last_name'] = $request->last_name;
                $bookingData['customer_phone'] = $request->phone;
            }

            // Thực thi Action
            $booking = $this->createBookingAction->execute($bookingData);

            // Xóa giỏ hàng, lưu ID booking vào session
            session()->forget('booking_cart');
            session(['booking_id' => $booking->id]);

            return redirect()->route('payment');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function payment()
    {
        $bookingId = session('booking_id');
        if (!$bookingId) {
            return redirect()->route('home');
        }

        // Lấy thông tin booking từ DB
        $booking = \App\Models\Booking::with('bookingDetails.room.roomType')->find($bookingId);
        if (!$booking) {
            return redirect()->route('home');
        }

        return view('client.pages.payment', compact('booking'));
    }

    public function processPayment(Request $request)
    {
        $bookingId = session('booking_id');
        if (!$bookingId) {
            return redirect()->route('home');
        }

        $booking = \App\Models\Booking::find($bookingId);
        if (!$booking) {
            return redirect()->route('home');
        }

        $paymentType = $request->input('payment_type', 'pay_at_hotel');

        if ($paymentType === 'vnpay') {
            $vnp_Url = config('services.vnpay.url');
        $vnp_Returnurl = config('services.vnpay.return_url');
        $vnp_TmnCode = trim(config('services.vnpay.tmn_code'));
        $vnp_HashSecret = trim(config('services.vnpay.hash_secret'));

        $vnp_TxnRef = $booking->id . '_' . time();
        $vnp_OrderInfo = "Thanh toan dat phong Urban Luxe Hotel cho booking " . $booking->id;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = (int)($booking->final_amount * 100);
        $vnp_Locale = 'vn';
        $vnp_BankCode = $request->input('bank_code', '');
        $vnp_IpAddr = $request->ip();

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (!empty($vnp_BankCode)) {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return redirect($vnp_Url);
        }

        // For other payment methods (cash, manual bank transfer)
        // Keep status as PENDING, or update payment method if needed.
        return redirect()->route('success')->with('success', 'Đặt phòng thành công! Vui lòng thanh toán tại quầy khi nhận phòng.');
    }

    public function vnpayReturn(Request $request)
    {
        $vnp_HashSecret = trim(config('services.vnpay.hash_secret'));
        $inputData = array();
        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        
        $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $txnRefParts = explode('_', $request->vnp_TxnRef);
        $bookingId = $txnRefParts[0];

        if ($secureHash == $vnp_SecureHash) {
            if ($request->vnp_ResponseCode == '00') {
                $booking = \App\Models\Booking::find($bookingId);
                if ($booking) {
                    $booking->update(['status' => \App\Enums\BookingStatus::CONFIRMED->value]);
                    
                    \App\Models\Payment::create([
                        'booking_id' => $bookingId,
                        'amount' => $request->vnp_Amount / 100,
                        'payment_method' => 'vnpay',
                        'transaction_code' => $request->vnp_TransactionNo,
                        'note' => 'Thanh toán trực tuyến qua VNPAY',
                    ]);
                }
                
                session(['booking_id' => $bookingId]);
                return redirect()->route('success')->with('success', 'Thanh toán đặt phòng thành công!');
            } else {
                return redirect()->route('payment')->with('error', 'Giao dịch không thành công hoặc bị hủy (Mã lỗi: ' . $request->vnp_ResponseCode . ')');
            }
        } else {
            return redirect()->route('payment')->with('error', 'Chữ ký VNPAY không hợp lệ. Vui lòng thử lại.');
        }
    }

    public function success()
    {
        $bookingId = session('booking_id');
        if (!$bookingId) {
            return redirect()->route('home');
        }

        $booking = \App\Models\Booking::with(['customer', 'bookingDetails.room.roomType'])->find($bookingId);
        
        return view('client.pages.success', compact('booking'));
    }
}
