<?php

namespace App\Http\Controllers;

use App\Enums\RepairTicketStatus;
use App\Http\Requests\RepairTicket\StoreRepairTicketRequest;
use App\Http\Requests\RepairTicket\UpdateRepairTicketStatusRequest;
use App\Http\Traits\PaginationTrait;
use App\Services\Contracts\RepairTicketServiceInterface;
use App\Services\Contracts\RoomServiceInterface;
use App\Services\Contracts\StaffServiceInterface;
use Illuminate\Http\Request;

class RepairTicketController extends Controller
{
    use PaginationTrait;

    public function __construct(
        private readonly RepairTicketServiceInterface $repairTicketService,
        private readonly RoomServiceInterface $roomService,
        private readonly StaffServiceInterface $staffService,
    ) {}

    /**
     * Display a listing of all repair tickets
     */
    public function index(Request $request)
    {
        $repairTickets = $this->repairTicketService->getPaginated(
            $request->input('filter', []),
            $request->input('per_page', 15)
        );

        $this->validatePageNumber(
            $repairTickets->currentPage(),
            $repairTickets->lastPage(),
            'abort'
        );

        $statuses = RepairTicketStatus::cases();
        $rooms = $this->roomService->getAll();

        return view('admin.repair-ticket.index', compact(
            'repairTickets',
            'statuses',
            'rooms'
        ));
    }

    /**
     * Show the form for creating a new repair ticket
     */
    public function create()
    {
        $rooms = $this->roomService->getAll();
        $staffs = $this->staffService->getAll();

        return view('admin.repair-ticket.add', compact(
            'rooms',
            'staffs'
        ));
    }

    /**
     * Store a newly created repair ticket in storage
     */
    public function store(StoreRepairTicketRequest $request)
    {
        $repairTicket = $this->repairTicketService->create($request->validated());

        return redirect()
            ->route('admin.repair-ticket.show', $repairTicket->id)
            ->with('success', 'Phiếu sửa chữa đã được tạo thành công');
    }

    /**
     * Display the specified repair ticket
     */
    public function show($id)
    {
        $repairTicket = $this->repairTicketService->findById($id);

        if (! $repairTicket) {
            return redirect()
                ->route('admin.repair-ticket.index')
                ->with('error', 'Phiếu sửa chữa không tồn tại');
        }

        $statuses = RepairTicketStatus::cases();

        return view('admin.repair-ticket.detail', compact(
            'repairTicket',
            'statuses'
        ));
    }

    /**
     * Update the status of a repair ticket
     */
    public function updateStatus($id, UpdateRepairTicketStatusRequest $request)
    {
        $newStatus = $request->post('status');
        $notes = $request->post('notes');

        $result = $this->repairTicketService->transitionStatus($id, $newStatus, $notes);

        if (! $result['success']) {
            return redirect()
                ->back()
                ->with('error', $result['message']);
        }

        return redirect()
            ->back()
            ->with('success', $result['message']);
    }
}
