<?php

namespace App\Http\Controllers;

use App\Services\Contracts\EquipmentServiceInterface;
use App\Http\Requests\Equipment\StoreEquipmentRequest;
use App\Http\Requests\Equipment\UpdateEquipmentRequest;
use App\Http\Traits\PaginationTrait;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    use PaginationTrait;

    public function __construct(
        private readonly EquipmentServiceInterface $equipmentService
    ) {}

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', $this->getPerPage(10));
        $filters = $request->input('filter', []);

        [
            'equipments' => $equipments,
            'categories' => $categories,
        ] = $this->equipmentService->prepareDataForIndex($filters, $perPage);

        $this->validatePageNumber($equipments->currentPage(), $equipments->lastPage(), 'abort');

        return view('admin.equipment.index', compact('equipments', 'categories'));
    }

    public function create()
    {
        return view('admin.equipment.create',[
            'categories' => $categories,
        ] = $this->equipmentService->prepareDataForCreate());
    }

    public function store(StoreEquipmentRequest $request)
    {
        try {
            $this->equipmentService->create($request->validated());
            return redirect()->route('admin.equipment.index')->with('success', 'Thiết bị đã được tạo thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        return view('admin.equipment.edit', [
            'equipment'  => $equipment,
            'categories' => $categories,
        ] = $this->equipmentService->prepareDataForEdit($id));
    }

    public function update(UpdateEquipmentRequest $request, $id)
    {
        try {
            $this->equipmentService->update($id, $request->validated());
            return redirect()->route('admin.equipment.index')->with('success', 'Thiết bị đã được cập nhật.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->equipmentService->delete($id);
            return redirect()->route('admin.equipment.index')->with('success', 'Thiết bị đã bị xoá.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
}
