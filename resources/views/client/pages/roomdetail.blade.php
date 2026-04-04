@extends('client.layouts.master')

@section('title', 'Phòng Deluxe Cao Cấp | Urban Luxe')
@section('meta_description', 'Khám phá phòng Deluxe Cao Cấp tại Urban Luxe - không gian nghỉ dưỡng 35m² với tầm nhìn thành phố tuyệt đẹp và tiện nghi 5 sao.')

@push ('styles')
<!-- If you use Vite, use this instead -->
@vite(['resources/css/client/roomdetail.css'])
@endpush

@section('content')
<div class="room-detail-container">
    <div class="container">
        <!-- Room Breadcrumbs (Simple & Elegant) -->
        <div class="breadcrumbs" style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 30px;">
            <a href="/" style="color: var(--text-muted);">Trang Chủ</a> &nbsp;/&nbsp; 
            <a href="/rooms" style="color: var(--text-muted);">Phòng Nghỉ</a> &nbsp;/&nbsp; 
            <span style="color: var(--text-white);">Phòng Deluxe Cao Cấp</span>
        </div>

        <!-- Room Gallery Grid -->
        <div class="room-gallery">
            <div class="gallery-item gallery-main">
                <img src="{{ asset('img/room-deluxe.png') }}" alt="Main Room Image">
            </div>
            <div class="gallery-item">
                <img src="{{ asset('img/Background (1).png') }}" alt="Gallery Image 1">
            </div>
            <div class="gallery-item">
                <img src="{{ asset('img/Background (2).png') }}" alt="Gallery Image 2">
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="room-content-grid">
            <!-- Left Column: Details -->
            <div class="room-details-left">
                <div class="room-info-header">
                    <span class="room-category">Hướng Thành Phố</span>
                    <div class="room-title-row">
                        <h1 class="room-title">Phòng Deluxe Cao Cấp</h1>
                        <div class="room-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span>(128 đánh giá)</span>
                        </div>
                    </div>
                    <div class="room-meta">
                        <span><i class="fas fa-expand-arrows-alt"></i> 35 m²</span>
                        <span><i class="fas fa-user-friends"></i> 2 Người Lớn</span>
                        <span><i class="fas fa-bed"></i> 1 Giường King-size</span>
                    </div>
                </div>

                <!-- Description Section -->
                <div class="room-description">
                    <h2 class="section-label">Mô tả chi tiết</h2>
                    <p>
                        Tận hưởng không gian nghỉ dưỡng sang trọng bậc nhất tại Urban Luxe với phòng Deluxe Cao Cấp. 
                        Được thiết kế tinh xảo với phong cách hiện đại pha lẫn nét cổ điển, căn phòng mang đến sự ấm cúng 
                        và đẳng cấp tuyệt đối cho kỳ nghỉ của bạn.
                        <br><br>
                        Với tầm nhìn toàn cảnh hướng ra trung tâm thành phố sôi động từ cửa sổ kính trần-sàn, 
                        bạn sẽ có những phút giây thư giãn tuyệt vời khi ngắm nhìn hoàng hôn rực rỡ hay lung linh ánh đèn đêm. 
                        Phòng được trang bị đầy đủ các tiện nghi hiện đại nhất để đáp ứng mọi nhu cầu của khách hàng khó tính nhất.
                    </p>
                </div>

                <!-- Amenities Section -->
                <div class="room-amenities">
                    <h2 class="section-label">Tiện nghi phòng nghỉ</h2>
                    <div class="amenities-list">
                        <div class="amenity-item"><i class="fas fa-wifi"></i> Wi-Fi Miễn Phí</div>
                        <div class="amenity-item"><i class="fas fa-snowflake"></i> Máy Lạnh</div>
                        <div class="amenity-item"><i class="fas fa-tv"></i> Smart TV HD</div>
                        <div class="amenity-item"><i class="fas fa-coffee"></i> Máy Pha Cà Phê</div>
                        <div class="amenity-item"><i class="fas fa-bath"></i> Bồn Tắm Riêng</div>
                        <div class="amenity-item"><i class="fas fa-safe"></i> Két Sắt An Toàn</div>
                        <div class="amenity-item"><i class="fas fa-wind"></i> Máy Sấy Tóc</div>
                        <div class="amenity-item"><i class="fas fa-wine-glass-alt"></i> Mini Bar</div>
                        <div class="amenity-item"><i class="fas fa-concierge-bell"></i> Phục Vụ 24/7</div>
                    </div>
                </div>

                <!-- Services Section -->
                <div class="room-services" style="margin-top: 40px;">
                    <h2 class="section-label">Dịch vụ đi kèm</h2>
                    <p style="color: var(--text-light); font-size: 0.95rem; line-height: 1.6;">
                        • Miễn phí ăn sáng buffet hàng ngày tại nhà hàng tầng trệt. <br>
                        • Sử dụng miễn phí hồ bơi vô cực và phòng gym 24/7. <br>
                        • Nước khoáng, trà và cà phê trong phòng hàng ngày.
                    </p>
                </div>
            </div>

            <!-- Right Column: Booking Card -->
            <div class="booking-sidebar">
                <div class="booking-card">
                    <div class="price-box">
                        <span class="current-price">500.000 VNĐ</span>
                        <span class="price-period">/ ĐÊM</span>
                    </div>

                    <div class="booking-form-item">
                        <label>Ngày nhận & trả phòng</label>
                        <div class="booking-input-group">
                            <i class="far fa-calendar-alt"></i>
                            <input type="text" placeholder="Chọn khoảng thời gian..." readonly style="cursor: pointer;">
                        </div>
                    </div>

                    <div class="booking-form-item">
                        <label>Số lượng khách</label>
                        <div class="booking-input-group">
                            <i class="fas fa-users"></i>
                            <input type="text" placeholder="2 Người Lớn, 0 Trẻ em" readonly style="cursor: pointer;">
                        </div>
                    </div>

                    <button class="btn btn-primary btn-reserve">Đặt Ngay Bây Giờ</button>
                    <p class="booking-note">Bạn sẽ được chuyển đến trang thanh toán an toàn</p>

                    <div class="trust-badges" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 30px; border-top: 1px solid var(--border-color); padding-top: 20px;">
                        <div style="font-size: 0.75rem; color: var(--text-muted); display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-check-circle" style="color: var(--blue);"></i> Hủy bỏ miễn phí
                        </div>
                        <div style="font-size: 0.75rem; color: var(--text-muted); display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-check-circle" style="color: var(--blue);"></i> Đảm bảo giá tốt nhất
                        </div>
                    </div>
                </div>
            </div>
        <!-- Similar Rooms Section -->
        <section class="similar-rooms" style="margin-top: 80px; border-top: 1px solid var(--border-color); padding-top: 60px;">
            <div class="section-header-row" style="margin-bottom: 40px;">
                <div class="section-intro">
                    <span class="subtitle-gold">GỢI Ý DÀNH CHO BẠN</span>
                    <h2 class="section-title">Các Loại Phòng Tương Tự</h2>
                </div>
                <div class="section-actions">
                    <a href="/rooms" class="btn-explore">Xem Tất Cả &rarr;</a>
                </div>
            </div>

            <div class="stays-grid">
                <!-- Similar Room 1 -->
                <div class="stay-card">
                    <div class="stay-image">
                        <img src="{{ asset('img/room-suite.png') }}" alt="Executive Suite">
                    </div>
                    <div class="stay-content">
                        <span class="stay-badge category-blue">HẠNG SUITE</span>
                        <h3 class="stay-title">Phòng Suite Thương Gia</h3>
                        <p class="stay-description">
                            Thiết kế lý tưởng cho công việc và nghỉ dưỡng với phòng khách riêng và tiện ích cao cấp.
                        </p>
                        <div class="stay-footer">
                            <div class="stay-price-wrapper">
                                <span class="price-label">Từ</span>
                                <span class="price-amount">450.000 VNĐ</span>
                                <span class="price-unit">/ đêm</span>
                            </div>
                            <a href="#" class="btn-book-ghost">Xem chi tiết</a>
                        </div>
                    </div>
                </div>

                <!-- Similar Room 2 -->
                <div class="stay-card">
                    <div class="stay-image">
                        <img src="{{ asset('img/room-penthouse.png') }}" alt="Urban Penthouse">
                        <span class="top-pick-badge">SANG TRỌNG NHẤT</span>
                    </div>
                    <div class="stay-content">
                        <span class="stay-badge category-blue">HẠNG PENTHOUSE</span>
                        <h3 class="stay-title">Penthouse Sang Trọng</h3>
                        <p class="stay-description">
                            Đỉnh cao của sự xa hoa với tầm nhìn toàn cảnh, sân thượng riêng và dịch vụ quản gia.
                        </p>
                        <div class="stay-footer">
                            <div class="stay-price-wrapper">
                                <span class="price-label">Từ</span>
                                <span class="price-amount">1.200.000 VNĐ</span>
                                <span class="price-unit">/ đêm</span>
                            </div>
                            <a href="#" class="btn-book-ghost">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

