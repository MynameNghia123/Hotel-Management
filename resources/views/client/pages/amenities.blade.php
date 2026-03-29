@extends('client.layouts.master')
@section('title', 'Tiện Ích Cao Cấp | Urban Luxe Hotel')
@section('meta_description', 'Trải nghiệm hệ thống tiện ích đẳng cấp tại Urban Luxe: Hồ bơi vô cực, Spa thư giãn, phòng Gym hiện đại và dịch vụ quản gia 24/7.')
@push('styles')
@vite(['resources/css/client/amenities.css'])
@endpush

@section('content')
<section class="amenities-section py-5">
    
    <!-- Header Image chuẩn 1100px -->
    <div class="amenities-container">
        <img src="{{ asset('img/amenities.png') }}" alt="Amenities Header" class="amenities-header-img shadow-sm" />
    </div>

    <!-- 4-Grid Layout 1100px sòng phẳng -->
    <div class="amenities-container">
        <div class="amenities-grid">
            
            <div class="amenity-card shadow-sm">
                <img src="{{ asset('img/amenity-1.png') }}" alt="Amenity 1" />
            </div>

            <div class="amenity-card shadow-sm">
                <img src="{{ asset('img/amenity-2.png') }}" alt="Amenity 2" />
            </div>

            <div class="amenity-card shadow-sm">
                <img src="{{ asset('img/amenity-3.png') }}" alt="Amenity 3" />
            </div>

            <div class="amenity-card shadow-sm">
                <img src="{{ asset('img/amenity-4.png') }}" alt="Amenity 4" />
            </div>

        </div>
    </div>
</section>
@endsection
