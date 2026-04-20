<?php

namespace App\Http\Controllers;

use App\Services\Contracts\EquipmentCategoryServiceInterface;
use App\Http\Requests\EquipmentCategory\StoreEquipmentCategoryRequest;
use App\Http\Requests\EquipmentCategory\UpdateEquipmentCategoryRequest;
use App\Http\Traits\PaginationTrait;
use Illuminate\Http\Request;

class EquipmentCategoryController extends Controller
{
    use PaginationTrait;

    public function __construct(
        private readonly EquipmentCategoryServiceInterface $equipmentCategoryService
    ) {}

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', $this->getPerPage(10));
        $filters = $request->input('filter', []);

        $categories = $this->equipmentCategoryService->getPaginated($filters, $perPage);
        
        $this->validatePageNumber($categories->currentPage(), $categories->lastPage(), 'abort');
        return view('admin.equipment-types.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.equipment-types.create');
    }

    public function store(StoreEquipmentCategoryRequest $request)
    {
        try {
            $this->equipmentCategoryService->create($request->validated());
            return redirect()->route('admin.equipment-types.index')->with('success', 'Loại thiết bị đã được tạo thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $category = $this->equipmentCategoryService->findById($id);
        return view('admin.equipment-types.edit', compact('category'));
    }

    public function update(UpdateEquipmentCategoryRequest $request, $id)
    {
        try {
            $this->equipmentCategoryService->update($id, $request->validated());
            return redirect()->route('admin.equipment-types.index')->with('success', 'Loại thiết bị đã được cập nhật.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->equipmentCategoryService->delete($id);
            return redirect()->route('admin.equipment-types.index')->with('success', 'Loại thiết bị đã bị xoá.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
}
