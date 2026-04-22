<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\PaginationTrait;
use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Services\Contracts\ServiceServiceInterface;
use App\Services\Contracts\ServiceGroupServiceInterface;

class ServiceController extends Controller
{
    use PaginationTrait;

    public function __construct(
        private readonly ServiceServiceInterface $serviceService,
        private readonly ServiceGroupServiceInterface $serviceGroupService
    ) {}

    public function index(Request $request)
    {
        $services = $this->serviceService->getPaginated(
            $request->input('filter', []), 
            $request->input('per_page', 10)
        );

        $this->validatePageNumber($services->currentPage(), $services->lastPage(), 'abort');

        $serviceGroups = $this->serviceGroupService->getAll();
        return view('admin.services.index', compact('services', 'serviceGroups'));
    }

    public function create()
    {
        $serviceGroups = $this->serviceGroupService->getAll();
        return view('admin.services.create', compact('serviceGroups'));
    }

    public function store(StoreServiceRequest $request)
    {
        try {
            $this->serviceService->create($request->validated());
            return redirect()->route('admin.services.index')->with('success', 'Dịch vụ đã được tạo thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        return view('admin.services.edit', [
            'service' => $this->serviceService->findById($id),
            'serviceGroups' => $serviceGroups
        ]);
    }

    public function update(UpdateServiceRequest $request, $id)
    {
        try {
            $this->serviceService->update($id, $request->validated());
            return redirect()->route('admin.services.index')->with('success', 'Cập nhật dịch vụ thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->serviceService->delete($id);
            return redirect()->route('admin.services.index')->with('success', 'Xóa dịch vụ thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
}
