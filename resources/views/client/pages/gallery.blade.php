@extends('client.layouts.master')

@section('title', 'Bộ Sưu Tập Hình Ảnh | Urban Luxe Hotel')
@section('meta_description', 'Khám phá không gian sang trọng và hiện đại của Urban Luxe qua bộ sưu tập hình ảnh về phòng nghỉ, ẩm thực và tiện ích đẳng cấp.')

@push('styles')
@vite(['resources/css/client/gallery.css'])
@endpush

@section('content')
<section class="gallery-section py-5">
    
    <!-- Tiêu đề và nút lọc mới, gióng hàng chuẩn -->
    <div class="gallery-header-container">
        <div class="div">
            <div class="div-wrapper"><div class="text-wrapper">Bộ Sưu Tập</div></div>
            <div class="div-wrapper">
                <p class="text">
                    Đắm mình trong trải nghiệm Urban Luxe. Một hành trình thị nhãn<br />qua các không gian được thiết kế dành riêng cho khách du lịch hiện đại.
                </p>
            </div>
        </div>
        <div class="filter-group">
            <button class="filter-btn active">Tất cả</button>
            <button class="filter-btn">Phòng nghỉ</button>
            <button class="filter-btn">Ẩm thực</button>
            <button class="filter-btn">Ngoại cảnh</button>
            <button class="filter-btn">Sự kiện</button>
        </div>
    </div>

    <!-- Gallery Grid Layout (1100px) -->
    <div class="gallery-grid-container pb-5">
        
        <!-- Cột 1 -->
        <div class="gallery-col">
            <div class="gallery-item h-medium shadow-lg">
                <img src="{{ asset('img/Background.png') }}" alt="Phòng ngủ sang trọng" />
            </div>
            <div class="gallery-item h-medium shadow-lg">
                <img src="{{ asset('img/Background (4).png') }}" alt="Không gian thư giãn" />
            </div>
            <div class="gallery-item h-small shadow-lg">
                <img src="{{ asset('img/Background (2).png') }}" alt="Nội thất hiện đại" />
            </div>
        </div>

        <!-- Cột 2 (Lệch một chút tạo hiệu ứng Masonry) -->
        <div class="gallery-col mt-md-5">
            <div class="gallery-item h-small shadow-lg">
                <img src="{{ asset('img/Background (5).png') }}" alt="Dịch vụ cao cấp" />
            </div>
            <div class="gallery-item h-medium shadow-lg">
                <img src="{{ asset('img/Background (1).png') }}" alt="Toàn cảnh khách sạn" />
            </div>
            <div class="gallery-item h-small shadow-lg">
                <img src="{{ asset('img/Background (6).png') }}" alt="Tiện ích nội khu" />
            </div>
        </div>

        <!-- Cột 3 -->
        <div class="gallery-col">
            <div class="gallery-item h-medium shadow-lg">
                <img src="{{ asset('img/Background (7).png') }}" alt="Khu vực nhà hàng" />
            </div>
            <div class="gallery-item h-medium shadow-lg">
                <img src="{{ asset('img/Background (8).png') }}" alt="Hồ bơi vô cực" />
            </div>
            <div class="gallery-item h-small shadow-lg">
                <img src="{{ asset('img/Background (3).png') }}" alt="Sảnh khách sạn" />
            </div>
        </div>

    </div>
</section>
@endsection
