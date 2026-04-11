<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Contracts\AmenityServiceInterface;
use App\Http\Requests\StoreAmenityRequest;
use App\Http\Requests\UpdateAmenityRequest;

class AmenityController extends Controller
{
    public function __construct(
        private readonly AmenityServiceInterface $amenityService
    ) {}

    public function index()
    {
        $amenities = $this->amenityService->getAllAmenities();
        return view('admin.amenities.index', compact('amenities'));
    }

    public function create()
    {
        return view('admin.amenities.create');
    }

    public function store(StoreAmenityRequest $request)
    {
        $this->amenityService->createAmenity($request->validated());
        return redirect()->route('admin.amenities.index')->with('success', 'Tiện ích đã được tạo thành công.');
    }

    public function edit($id)
    {
        $amenity = $this->amenityService->getAmenityById($id);
        return view('admin.amenities.edit', compact('amenity'));
    }

    public function update(UpdateAmenityRequest $request, $id)
    {
        $this->amenityService->updateAmenity($id, $request->validated());
        return redirect()->route('admin.amenities.index')->with('success', 'Tiện ích đã được cập nhật.');
    }

    public function destroy($id)
    {
        $this->amenityService->deleteAmenity($id);
        return redirect()->route('admin.amenities.index')->with('success', 'Tiện ích đã bị xoá.');
    }
}
