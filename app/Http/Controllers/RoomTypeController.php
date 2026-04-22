<?php

namespace App\Http\Controllers;

use App\Services\Contracts\RoomTypeServiceInterface;
use App\Services\Contracts\RoomTypeImageServiceInterface;
use App\Http\Requests\RoomType\StoreRoomTypeRequest;
use App\Http\Requests\RoomType\UpdateRoomTypeRequest;
use App\Http\Traits\PaginationTrait;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    use PaginationTrait;

    public function __construct(
        private readonly RoomTypeServiceInterface      $roomTypeService,
        private readonly RoomTypeImageServiceInterface $roomTypeImageService
    ) {}

    public function index(Request $request)
    {
        $roomTypes = $this->roomTypeService->getPaginated(
            $request->input('filter', []),
            $this->getPerPage(10)
        );

        $this->validatePageNumber($roomTypes->currentPage(), $roomTypes->lastPage(), 'abort');

        return view('admin.room-types.index', compact('roomTypes'));
    }

    public function create()
    {
        return view('admin.room-types.create', [
            'allAmenities'  => $allAmenities,
            'allEquipments' => $allEquipments,
        ] = $this->roomTypeService->prepareDataForCreate());
    }

    public function store(StoreRoomTypeRequest $request)
    {
        try {
            $roomType = $this->roomTypeService->create($request->validated());
            $this->roomTypeImageService->attachTempImagesToRoomType($roomType->id);

            return redirect()->route('admin.rooms.index')
                ->with('success', 'Loại phòng được tạo thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi khi tạo loại phòng.');
        }
    }

    public function show($id)
    {
        return view('admin.room-types.show', [
            'roomType' => $this->roomTypeService->findWithDetails($id),
        ]);
    }

    public function edit($id)
    {
        return view('admin.room-types.edit',[
            'allAmenities'  => $allAmenities,
            'allEquipments' => $allEquipments,
        ] = $this->roomTypeService->prepareDataForEdit($id));
    }

    public function update(UpdateRoomTypeRequest $request, $id)
    {
        try {
            $this->roomTypeService->update($id, $request->validated());

            return redirect()->route('admin.rooms.index')
                ->with('success', 'Loại phòng được cập nhật thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi khi cập nhật loại phòng.');
        }
    }

    public function destroy($id)
    {
        try {
            $this->roomTypeService->delete($id);

            return redirect()->route('admin.rooms.index')
                ->with('success', 'Loại phòng được xóa thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi khi xóa loại phòng.');
        }
    }
}
