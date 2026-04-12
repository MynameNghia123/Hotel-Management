<?php

namespace App\Http\Controllers;

use App\Services\Contracts\EquipmentServiceInterface;
use App\Services\Contracts\EquipmentCategoryServiceInterface;
use App\Http\Requests\Equipment\StoreEquipmentRequest;
use App\Http\Requests\Equipment\UpdateEquipmentRequest;

class EquipmentController extends Controller
{
    public function __construct(
        private readonly EquipmentServiceInterface $equipmentService,
        private readonly EquipmentCategoryServiceInterface $equipmentCategoryService
    ) {}

    public function index()
    {
        $equipments = $this->equipmentService->getAllEquipment();
        return view('admin.equipment.index', compact('equipments'));
    }

    public function create()
    {
        $categories = $this->equipmentCategoryService->getAllEquipmentCategories();
        return view('admin.equipment.create', compact('categories'));
    }

    public function store(StoreEquipmentRequest $request)
    {
        $this->equipmentService->createEquipment($request->validated());
        return redirect()->route('admin.equipment.index')->with('success', 'Thiết bị đã được tạo thành công.');
    }

    public function edit($id)
    {
        $equipment  = $this->equipmentService->getEquipmentById($id);
        $categories = $this->equipmentCategoryService->getAllEquipmentCategories();
        return view('admin.equipment.edit', compact('equipment', 'categories'));
    }

    public function update(UpdateEquipmentRequest $request, $id)
    {
        $this->equipmentService->updateEquipment($id, $request->validated());
        return redirect()->route('admin.equipment.index')->with('success', 'Thiết bị đã được cập nhật.');
    }

    public function destroy($id)
    {
        $this->equipmentService->deleteEquipment($id);
        return redirect()->route('admin.equipment.index')->with('success', 'Thiết bị đã bị xoá.');
    }
}
