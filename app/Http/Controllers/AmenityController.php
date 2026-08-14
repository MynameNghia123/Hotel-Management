<?php

namespace App\Http\Controllers;

use App\Http\Requests\Amenity\StoreAmenityRequest;
use App\Http\Requests\Amenity\UpdateAmenityRequest;
use App\Http\Traits\PaginationTrait;
use App\Services\Contracts\AmenityServiceInterface;
use Illuminate\Http\Request;

class AmenityController extends Controller
{
    use PaginationTrait;

    public function __construct(
        private readonly AmenityServiceInterface $amenityService
    ) {}

    public function index(Request $request)
    {
        $perpage = $request->input('per_page', 10);
        $filters = $request->input('filter', []);

        $amenities = $this->amenityService->getPaginated($filters, $perpage);

        $this->validatePageNumber($amenities->currentPage(), $amenities->lastPage(), 'abort');

        return view('admin.amenities.index', compact('amenities'));
    }

    public function create()
    {
        return view('admin.amenities.create');
    }

    public function store(StoreAmenityRequest $request)
    {
        try {
            $this->amenityService->create($request->validated());

            return redirect()->route('admin.amenities.index')->with('success', 'Tiện ích đã được tạo thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Lỗi: '.$e->getMessage());
        }
    }

    public function edit($id)
    {
        $amenity = $this->amenityService->findById($id);

        return view('admin.amenities.edit', compact('amenity'));
    }

    public function update(UpdateAmenityRequest $request, $id)
    {
        try {
            $this->amenityService->update($id, $request->validated());

            return redirect()->route('admin.amenities.index')->with('success', 'Tiện ích đã được cập nhật.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Lỗi: '.$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->amenityService->delete($id);

            return redirect()->route('admin.amenities.index')->with('success', 'Tiện ích đã bị xoá.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi: '.$e->getMessage());
        }
    }
}
