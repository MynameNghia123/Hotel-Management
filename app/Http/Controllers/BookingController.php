<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\BookingStatus;
use App\Http\Traits\PaginationTrait;
use App\Http\Requests\Booking\StoreBookingRequest;
use App\Services\Contracts\BookingServiceInterface;
use App\Services\Contracts\BookingDetailServiceInterface;
use App\Services\Contracts\CustomerServiceInterface;
use App\Services\Contracts\RoomServiceInterface;
use App\Models\Customer;
use App\Models\Staff;
use App\Services\Implementations\StaffService;

class BookingController extends Controller
{
    use PaginationTrait;

    public function __construct(
        private readonly BookingServiceInterface $bookingService,
        private readonly BookingDetailServiceInterface $bookingDetailService,
        private readonly CustomerServiceInterface $customerService,
        private readonly RoomServiceInterface $roomService,
        private readonly StaffService $staffService
    ) {}

    /**
     * Display all bookings with status filtering
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $filters = $request->input('filters', []);

        $bookings = $this->bookingService->getPaginated($filters, $perPage);

        $this->validatePageNumber($bookings->currentPage(), $bookings->lastPage(), 'abort');

        $statuses = BookingStatus::cases();
        $statusCounts = $this->bookingService->getStatusCounts();

        return view('admin.bookings.index', compact('bookings', 'statuses', 'statusCounts'));
    }

    /**
     * Show form to create new booking
     */
    public function create()
    {
        $rooms = $this->roomService->getAll();
        $customers = $this->customerService->getAll();
        $staffs = $this->staffService->getAll();
        
        return view('admin.bookings.create', compact('rooms', 'customers', 'staffs'));
    }

    /**
     * Store new booking with customer and booking details
     */
    public function store(StoreBookingRequest $request)
    {
        try {
            // Get validated data
            $validated = $request->validated();

            // Get or create customer
            $customer = null;
            if ($validated['customer_id'] ?? null) {
                $customer = Customer::findOrFail($validated['customer_id']);
            } else if ($validated['customer_email'] ?? null) {
                $customer = Customer::where('email', $validated['customer_email'])->first();
                if (!$customer) {
                    $customer = $this->customerService->create([
                        'name' => $validated['customer_name'],
                        'email' => $validated['customer_email'],
                        'phone' => $validated['customer_phone'] ?? null,
                    ]);
                }
            }

            if (!$customer) {
                throw new \Exception('Vui lòng chọn khách hàng hoặc nhập thông tin mới');
            }

            // Create booking
            $bookingData = [
                'customer_id' => $customer->id,
                'booking_date' => $validated['booking_date'],
                'staff_id' => $validated['staff_id'] ?? null,
                'total_service_amount' => $validated['total_service_amount'] ?? 0,
                'total_room_amount' => $validated['total_room_amount'] ?? 0,
                'surcharge_amount' => $validated['surcharge_amount'] ?? 0,
                'final_amount' => $validated['final_amount'] ?? 0,
                'status' => BookingStatus::PENDING->value,
            ];
            $booking = $this->bookingService->create($bookingData);

            // Create booking details for each room
            $roomIds = $validated['room_ids'] ?? [];
            if (!empty($roomIds)) {
                foreach ($roomIds as $index => $roomId) {
                    $this->bookingDetailService->create([
                        'booking_id' => $booking->id,
                        'room_id' => $roomId,
                        'checkin_date' => $validated['checkin_dates'][$index] ?? now(),
                        'checkout_date' => $validated['checkout_dates'][$index] ?? now()->addDay(),
                        'hourly_price' => $validated['hourly_prices'][$index] ?? 0,
                        'daily_price' => $validated['daily_prices'][$index] ?? 0,
                        'service_amount' => 0,
                        'surcharge_amount' => 0,
                    ]);
                }
            }

            return redirect()->route('admin.bookings.show', $booking->id)
                ->with('success', 'Đặt phòng mới được tạo thành công.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Lỗi: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display booking details
     */
    public function show($id)
    {
        $booking = $this->bookingService->findById($id);
        if (!$booking) {
            abort(404);
        }
        $bookingDetails = $this->bookingDetailService->getWithRooms($booking->id);
        $statuses = BookingStatus::cases();

        return view('admin.bookings.show', compact('booking', 'bookingDetails', 'statuses'));
    }

    /**
     * Update booking status with validation
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|string',
            ]);

            $newStatus = BookingStatus::from($request->input('status'));
            $this->bookingService->updateStatus($id, $newStatus);

            return redirect()->route('admin.bookings.show', $id)
                ->with('success', "Cập nhật trạng thái thành công: {$newStatus->label()}");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
}
