<?php

namespace App\Http\Controllers;

use App\Services\Contracts\EquipmentCategoryServiceInterface;
use App\Http\Requests\EquipmentCategory\StoreEquipmentCategoryRequest;
use App\Http\Requests\EquipmentCategory\UpdateEquipmentCategoryRequest;

class EquipmentCategoryController extends Controller
{
    public function __construct(
        private readonly EquipmentCategoryServiceInterface $equipmentCategoryService
    ) {}

    public function index()
    {
        $categories = $this->equipmentCategoryService->getAllEquipmentCategories();
        return view('admin.equipment-types.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.equipment-types.create');
    }

    public function store(StoreEquipmentCategoryRequest $request)
    {
        $this->equipmentCategoryService->createEquipmentCategory($request->validated());
        return redirect()->route('admin.equipment-types.index')->with('success', 'Loại thiết bị đã được tạo thành công.');
    }

    public function edit($id)
    {
        $category = $this->equipmentCategoryService->getEquipmentCategoryById($id);
        return view('admin.equipment-types.edit', compact('category'));
    }

    public function update(UpdateEquipmentCategoryRequest $request, $id)
    {
        $this->equipmentCategoryService->updateEquipmentCategory($id, $request->validated());
        return redirect()->route('admin.equipment-types.index')->with('success', 'Loại thiết bị đã được cập nhật.');
    }

    public function destroy($id)
    {
        $this->equipmentCategoryService->deleteEquipmentCategory($id);
        return redirect()->route('admin.equipment-types.index')->with('success', 'Loại thiết bị đã bị xoá.');
    }
}
