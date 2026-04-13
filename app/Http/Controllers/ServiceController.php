<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Services\Contracts\ServiceServiceInterface;
use App\Services\Contracts\ServiceGroupServiceInterface;

class ServiceController extends Controller
{
    public function __construct(
        private readonly ServiceServiceInterface $serviceService,
        private readonly ServiceGroupServiceInterface $serviceGroupService
    ) {}

    public function index()
    {
        $services = $this->serviceService->getAllServices();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $serviceGroups = $this->serviceGroupService->getAllServiceGroups();
        return view('admin.services.create', compact('serviceGroups'));
    }

    public function store(StoreServiceRequest $request)
    {
        $this->serviceService->createService($request->validated());
        return redirect()->route('admin.services.index')->with('success', 'Dịch vụ đã được tạo thành công.');
    }

    public function edit($id)
    {
        $service = $this->serviceService->getServiceById($id);
        $serviceGroups = $this->serviceGroupService->getAllServiceGroups();
        return view('admin.services.edit', compact('service', 'serviceGroups'));
    }

    public function update(UpdateServiceRequest $request, $id)
    {
        $this->serviceService->updateService($id, $request->validated());
        return redirect()->route('admin.services.index')->with('success', 'Cập nhật dịch vụ thành công.');
    }

    public function destroy($id)
    {
        $this->serviceService->deleteService($id);
        return redirect()->route('admin.services.index')->with('success', 'Xóa dịch vụ thành công.');
    }
}
