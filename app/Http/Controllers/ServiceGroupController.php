<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ServiceGroup\StoreServiceGroupRequest;
use App\Http\Requests\ServiceGroup\UpdateServiceGroupRequest;
use App\Http\Traits\PaginationTrait;
use App\Services\Contracts\ServiceGroupServiceInterface;

class ServiceGroupController extends Controller
{
    use PaginationTrait;
    public function __construct(
         private readonly ServiceGroupServiceInterface $serviceGroupService
    ) {}

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $filters = $request->input('filter', []);

        $serviceGroups = $this->serviceGroupService->getPaginated($filters, $perPage);

        $this->validatePageNumber($serviceGroups->currentPage(), $serviceGroups->lastPage(), 'abort');

        return view('admin.service-types.index', compact('serviceGroups'));
    }
    // public function index() 
    // {   

    //     $serviceGroups = $this->serviceGroupService->getAllServiceGroups();
    //     return view('admin.service-types.index', compact('serviceGroups'));
    // }

    public function create()
    {
        return view('admin.service-types.create');
    }

    public function store(StoreServiceGroupRequest $request)
    {
        try {
            $this->serviceGroupService->create($request->validated());
            return redirect()->route('admin.service-types.index')->with('success', 'Nhóm dịch vụ đã được tạo thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id) 
    {
        $serviceGroup = $this->serviceGroupService->findById($id);
        return view('admin.service-types.edit', compact('serviceGroup'));
    }

    public function update(UpdateServiceGroupRequest $request, $id)
    {
        try {
            $this->serviceGroupService->update($id, $request->validated());
            return redirect()->route('admin.service-types.index')->with('success', 'Cập nhật nhóm dịch vụ thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->serviceGroupService->delete($id);
            return redirect()->route('admin.service-types.index')->with('success', 'Xóa nhóm dịch vụ thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
}
