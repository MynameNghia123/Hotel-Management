@extends('client.layouts.master')

@section('title', 'Phòng Nghỉ & Suite | Urban Luxe Hotel')
@section('meta_description', 'Khám phá không gian nghỉ dưỡng đẳng cấp tại Urban Luxe với các loại phòng Deluxe, Suite và Penthouse sang trọng bậc nhất.')

@push('styles')
@vite(['resources/css/client/room.css'])
@endpush

@section('content')
<!-- Hero Section -->
<section class="rooms-hero" style="background-image: linear-gradient(rgba(15, 22, 36, 0.7), rgba(15, 22, 36, 0.7)), url('{{ asset('img/room-penthouse.png') }}');">
    <div class="container">
        <h1>Phòng Nghỉ & Suite</h1>
        <p>Mỗi không gian là một sự kết hợp hoàn hảo giữa nghệ thuật thiết kế và sự tiện nghi đẳng cấp.</p>
    </div>
</section>

</section>

<!-- Filter Section -->
<section class="rooms-filter-section">
    <div class="filter-toggle-container">
        <div class="filter-suggestion">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Gợi ý: Thử lọc theo "Hạng Suite" hoặc "Tiện ích Balcony" để tìm phòng ưng ý.
        </div>
        <button class="filter-btn-toggle" onclick="toggleFilter()">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
            Bộ Lọc
        </button>
    </div>

    <div class="filter-expandable-box" id="filterBox">
        <div class="filter-grid">
            <!-- Hạng phòng -->
            <div class="filter-group">
                <span class="filter-group-title">Hạng Phòng</span>
                <div class="filter-options-list">
                    <label class="filter-checkbox-item"><input type="checkbox"> Standard Single</label>
                    <label class="filter-checkbox-item"><input type="checkbox"> Deluxe Double</label>
                    <label class="filter-checkbox-item"><input type="checkbox"> Luxury Suite</label>
                </div>
            </div>

            <!-- Tiện ích -->
            <div class="filter-group">
                <span class="filter-group-title">Tiện Ích</span>
                <div class="filter-options-list">
                    <label class="filter-checkbox-item"><input type="checkbox"> Free Wi-Fi</label>
                    <label class="filter-checkbox-item"><input type="checkbox"> Air Conditioning</label>
                    <label class="filter-checkbox-item"><input type="checkbox"> Balcony</label>
                    <label class="filter-checkbox-item"><input type="checkbox"> Mini Bar</label>
                </div>
            </div>

            <!-- Khoảng giá -->
            <div class="filter-group">
                <span class="filter-group-title">Khoảng Giá (VNĐ)</span>
                <div class="filter-options-list">
                    <div class="price-range-inputs">
                        <input type="number" class="filter-mini-input" placeholder="Từ">
                        <span style="color: #475569;">-</span>
                        <input type="number" class="filter-mini-input" placeholder="Đến">
                    </div>
                    <label class="filter-checkbox-item" style="margin-top: 5px;"><input type="checkbox"> Dưới 1.000.000</label>
                    <label class="filter-checkbox-item"><input type="checkbox"> Trên 5.000.000</label>
                </div>
            </div>

            <!-- Đánh giá -->
            <div class="filter-group">
                <span class="filter-group-title">Đánh Giá</span>
                <div class="filter-options-list">
                    <label class="filter-checkbox-item"><input type="checkbox"> 5 Sao (Tuyệt vời)</label>
                    <label class="filter-checkbox-item"><input type="checkbox"> 4 Sao (Rất tốt)</label>
                </div>
            </div>
        </div>

        <div class="filter-actions">
            <button class="btn-reset-filter">Đặt lại</button>
            <button class="btn-apply-filter">Áp dụng lọc</button>
        </div>
    </div>
</section>

<script>
    function toggleFilter() {
        const filterBox = document.getElementById('filterBox');
        filterBox.classList.toggle('active');
    }
</script>

<!-- Rooms Listing Section -->
<section class="rooms-section">
    <div class="rooms-container">
        
        <!-- Room 1: Deluxe Room -->
        <div class="room-card-large">
            <div class="room-image-wrapper">
                <img src="{{ asset('img/room-deluxe.png') }}" alt="Phòng Deluxe Cao Cấp">
                <div class="room-image-overlay"></div>
                <div class="room-code-badge">DLX-101</div>
            </div>
            <div class="room-info-content">
                <span class="room-category">City Sanctuary</span>
                <h2 class="room-title">Phòng Deluxe<br>Cao Cấp</h2>
                <p class="room-description">
                    Ngỡ như chạm tay vào mây trời với hệ thống cửa kính panorama. Một không gian được tinh tuyển tỉ mỉ để mang đến sự thư thái tuyệt đối giữa lòng đô thị náo nhiệt.
                </p>
                <div class="room-amenities-list">
                    <div class="amenity-item">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M4 8V4m0 0h4M4 4l5 5m11-5V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5"></path></svg>
                        35 m²
                    </div>
                    <div class="amenity-item">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M3 10V6a2 2 0 012-2h14a2 2 0 012 2v4M3 10l9 7 9-7M3 10v10a2 2 0 002 2h14a2 2 0 002-2V10"></path></svg>
                        King
                    </div>
                    <div class="amenity-item">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                        02 Khách
                    </div>
                </div>
                <div class="room-card-footer">
                    <div class="room-price">
                        <span class="price-label">Giá từ</span>
                        <span class="price-val">500.000 VNĐ</span>
                        <span class="price-unit">/ đêm</span>
                    </div>
                    <div class="room-actions">
                        <a href="#" class="btn-room-detail">KHÁM PHÁ</a>
                        <a href="#" class="btn-room-book">ĐẶT NGAY</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Room 2: Urban Suite King -->
        <div class="room-card-large">
            <div class="room-image-wrapper">
                <img src="{{ asset('img/room-suite.png') }}" alt="Urban Suite King">
                <div class="room-image-overlay"></div>
                <div class="room-code-badge">USK-590</div>
            </div>
            <div class="room-info-content">
                <span class="room-category">Elite Lifestyle</span>
                <h2 class="room-title">Urban Suite<br>King Edition</h2>
                <p class="room-description">
                    Đỉnh cao của sự sang trọng với phòng khách biệt lập và nội thất được chế tác riêng. Trải nghiệm giấc ngủ hoàng gia trên chiếc giường King-size cao cấp với tầm nhìn Panorama toàn cảnh.
                </p>
                <div class="room-amenities-list">
                    <div class="amenity-item">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M4 8V4m0 0h4M4 4l5 5m11-5V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5"></path></svg>
                        40 m²
                    </div>
                    <div class="amenity-item">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M3 10V6a2 2 0 012-2h14a2 2 0 012 2v4M3 10l9 7 9-7M3 10v10a2 2 0 002 2h14a2 2 0 002-2V10"></path></svg>
                        Grand King
                    </div>
                    <div class="amenity-item">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                        03 Khách
                    </div>
                </div>
                <!-- Mini Equipment Tags -->
                <div style="font-size: 0.7rem; color: #94a3b8; margin-bottom: 35px; display: flex; gap: 20px; letter-spacing: 1px; text-transform: uppercase;">
                    <span><i class="fas fa-snowflake"></i> Daikin 1.5HP</span>
                    <span><i class="fas fa-tv"></i> 4K Samsung 55"</span>
                    <span><i class="fas fa-wine-glass"></i> Mini Bar Elite</span>
                </div>
                <div class="room-card-footer">
                    <div class="room-price">
                        <span class="price-label">Giá ưu đãi</span>
                        <span class="price-val">1.500.000 VNĐ</span>
                        <span class="price-unit">/ đêm</span>
                    </div>
                    <div class="room-actions">
                        <a href="#" class="btn-room-detail">KHÁM PHÁ</a>
                        <a href="#" class="btn-room-book">ĐẶT NGAY</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Room 3: Urban Penthouse -->
        <div class="room-card-large">
            <div class="room-image-wrapper">
                <img src="{{ asset('img/room-penthouse.png') }}" alt="Urban Penthouse">
                <div class="room-image-overlay"></div>
                <div class="room-code-badge">PTH-001</div>
            </div>
            <div class="room-info-content">
                <span class="room-category">Bespoke Living</span>
                <h2 class="room-title">Ultra Lux<br>Penthouse</h2>
                <p class="room-description">
                    Biểu tượng của quyền năng và phong cách. Khách hàng sẽ tận hưởng đặc quyền với hồ bơi vô cực riêng, dịch vụ quản gia 24/7 và một tầm nhìn không giới hạn ra đường chân trời thành phố.
                </p>
                <div class="room-amenities-list">
                    <div class="amenity-item">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M4 8V4m0 0h4M4 4l5 5m11-5V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5"></path></svg>
                        150 m²
                    </div>
                    <div class="amenity-item">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M3 10V6a2 2 0 012-2h14a2 2 0 012 2v4M3 10l9 7 9-7M3 10v10a2 2 0 002 2h14a2 2 0 002-2V10"></path></svg>
                        Royal Bed
                    </div>
                    <div class="amenity-item">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                        04 Khách
                    </div>
                </div>
                <div class="room-card-footer">
                    <div class="room-price">
                        <span class="price-label">Giá thượng lưu</span>
                        <span class="price-val">5.000.000 VNĐ</span>
                        <span class="price-unit">/ đêm</span>
                    </div>
                    <div class="room-actions">
                        <a href="#" class="btn-room-detail">KHÁM PHÁ</a>
                        <a href="#" class="btn-room-book">ĐẶT NGAY</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection