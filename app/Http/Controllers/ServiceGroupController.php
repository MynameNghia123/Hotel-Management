<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ServiceGroup\StoreServiceGroupRequest;
use App\Http\Requests\ServiceGroup\UpdateServiceGroupRequest;
use App\Services\Contracts\ServiceGroupServiceInterface;

class ServiceGroupController extends Controller
{
    public function __construct(
         private readonly ServiceGroupServiceInterface $serviceGroupService
    ) {}

    public function index() 
    {
        $serviceGroups = $this->serviceGroupService->getAllServiceGroups();
        return view('admin.service-types.index', compact('serviceGroups'));
    }

    public function create()
    {
        return view('admin.service-types.create');
    }

    public function store(StoreServiceGroupRequest $request)
    {
        $this->serviceGroupService->createServiceGroup($request->validated());
        return redirect()->route('admin.service-types.index')->with('success', 'Nhóm dịch vụ đã được tạo thành công.');
    }

    public function edit($id) 
    {
        $serviceGroup = $this->serviceGroupService->getServiceGroupById($id);
        return view('admin.service-types.edit', compact('serviceGroup'));
    }

    public function update(UpdateServiceGroupRequest $request, $id)
    {
        $this->serviceGroupService->updateServiceGroup($id, $request->validated());
        return redirect()->route('admin.service-types.index')->with('success', 'Cập nhật nhóm dịch vụ thành công.');
    }

    public function destroy($id)
    {
        $this->serviceGroupService->deleteServiceGroup($id);
        return redirect()->route('admin.service-types.index')->with('success', 'Xóa nhóm dịch vụ thành công .');
    }
}
