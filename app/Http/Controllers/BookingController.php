<?php

namespace App\Http\Controllers;

use App\Actions\CreateBookingAction;
use App\Enums\BookingStatus;
use App\Http\Requests\Booking\StoreBookingRequest;
use App\Http\Requests\Booking\UpdateBookingStatusRequest;
use App\Http\Traits\PaginationTrait;
use App\Services\Contracts\BookingServiceInterface;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    use PaginationTrait;

    public function __construct(
        private readonly BookingServiceInterface $bookingService,
        private readonly CreateBookingAction $createBookingAction
    ) {}

    /**
     * Display all bookings with status filtering
     */
    public function index(Request $request)
    {
        $bookings = $this->bookingService->getPaginated(
            $request->input('filters', []),
            $this->getPerPage(10)
        );

        $this->validatePageNumber($bookings->currentPage(), $bookings->lastPage(), 'abort');

        // dd($bookings);
        return view('admin.bookings.index', [
            'bookings' => $bookings,
            'statuses' => BookingStatus::cases(),
            'statusCounts' => $this->bookingService->getStatusCounts(),
        ]);
    }

    /**
     * Show form to create new booking
     */
    public function create()
    {
        [
            'rooms' => $rooms,
            'customers' => $customers,
            'staffs' => $staffs
        ] = $this->bookingService->prepareDataForCreate();

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

            // Execute booking creation action
            $booking = $this->createBookingAction->execute($validated);

            return redirect()->route('admin.bookings.show', $booking->id)
                ->with('success', 'Đặt phòng mới được tạo thành công.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Lỗi: '.$e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display booking details
     */
    public function show($id)
    {
        [
            'booking' => $booking,
            'bookingDetails' => $bookingDetails,
            'statuses' => $statuses
        ] = $this->bookingService->getBookingWithDetails($id);
        if (! $booking) {
            abort(404);
        }

        return view('admin.bookings.show', compact('booking', 'bookingDetails', 'statuses'));
    }

    /**
     * Update booking status with validation
     */
    public function updateStatus(UpdateBookingStatusRequest $request, $id)
    {
        try {
            $newStatus = BookingStatus::from($request->input('status'));
            $this->bookingService->updateStatus($id, $newStatus);

            return redirect()->route('admin.bookings.show', $id)
                ->with('success', "Cập nhật trạng thái thành công: {$newStatus->label()}");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Lỗi: '.$e->getMessage());
        }
    }
}
