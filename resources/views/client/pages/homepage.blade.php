@extends('client.layouts.master')

@section('title', 'Urban Luxe | Khách sạn Nghỉ dưỡng Sang trọng Trung tâm Thành phố')
@section('meta_description', 'Khám phá Urban Luxe - Khách sạn 5 sao với thiết kế thanh lịch, tiện nghi đẳng cấp và dịch vụ nghỉ dưỡng thượng lưu ngay tại trung tâm thành phố.')

@section('content')
    <section class="hero" style="background-image: url('{{ asset('img/backgroundhomepage.png') }}');">
        <!-- Lớp phủ tối cho phần ảnh nền từ bên trái mờ dần -->
        <div class="hero-overlay"></div>

        <div class="hero-container">

            <!-- === Nội Dung Chữ === -->
            <div class="hero-content">
                <!-- Badge: Điểm nhấn, Now open -->
                <div class="hero-badge">
                    <span class="dot"></span>
                    <span>NAY ĐÃ CÓ MẶT TẠI TRUNG TÂM</span>
                </div>

                <h1 class="hero-title">Chốn Bình Yên<br>Giữa Lòng Thành Phố.</h1>

                <p class="hero-description">
                    Trải nghiệm sự xa hoa chốn thành thị với thiết kế thanh lịch và tiện nghi. Điểm<br>dừng chân hoàn hảo
                    dành riêng cho những tín đồ xê dịch hiện đại.
                </p>
            </div>

            <!-- === Widget Đặt Phòng === -->
            <div class="booking-widget">
                <form action="{{ route('search') }}" method="GET" class="booking-form">

                    <!-- CHECK IN -->
                    <div class="form-group">
                        <label>NHẬN PHÒNG</label>
                        <div class="input-wrapper">
                            <!-- Calendar Icon -->
                            <svg class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <input type="date" name="checkin" value="{{ now()->format('Y-m-d') }}"
                                min="{{ now()->format('Y-m-d') }}" class="input-field date-input-custom"
                                style="cursor: pointer;">
                        </div>
                    </div>

                    <!-- CHECK OUT -->
                    <div class="form-group">
                        <label>TRẢ PHÒNG</label>
                        <div class="input-wrapper">
                            <!-- Calendar Icon -->
                            <svg class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <input type="date" name="checkout" value="{{ now()->addDay()->format('Y-m-d') }}"
                                min="{{ now()->addDay()->format('Y-m-d') }}" class="input-field date-input-custom"
                                style="cursor: pointer;">
                        </div>
                    </div>

                    <!-- GUESTS -->
                    <div class="form-group">
                        <label>SỐ KHÁCH</label>
                        <div class="input-wrapper" style="cursor: pointer;">
                            <!-- User Icon -->
                            <svg class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <input type="number" name="guests" value="1" min="1" class="input-field"
                                style="cursor: pointer;">
                        </div>
                    </div>

                    <style>
                        /* Ẩn icon lịch mặc định của trình duyệt để dùng SVG icon có sẵn */
                        .date-input-custom::-webkit-calendar-picker-indicator {
                            opacity: 0;
                            cursor: pointer;
                            position: absolute;
                            right: 0;
                            width: 100%;
                            height: 100%;
                        }

                        .date-input-custom {
                            position: relative;
                            color: var(--text-white);
                            /* Giữ text màu sáng */
                        }
                    </style>

                    <!-- NÚT SUMBIT -->
                    <div class="form-group submit-group">
                        <button type="submit" class="btn btn-primary submit-btn">
                            <!-- Search Icon -->
                            <svg class="icon-search" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            Kiểm Tra Phòng
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </section>

    <!-- === Amenities Section (Dark Theme) === -->
    <section class="section amenities-section">
        <div class="container">
            <!-- Section Header Layout -->
            <div class="section-header-row">
                <div class="section-intro">
                    <span class="subtitle-gold reveal reveal-left">TIỆN NGHI CAO CẤP</span>
                    <h2 class="section-title reveal reveal-up">Tiện Ích Đẳng Cấp Thế Giới</h2>
                    <p class="section-desc reveal reveal-up delay-200">
                        Tận hưởng hàng loạt dịch vụ thượng lưu được thiết kế để nâng tầm kỳ nghỉ của bạn,<br>
                        từ thư giãn tinh khiết cho đến chăm sóc thể chất toàn diện.
                    </p>
                </div>
                <div class="section-actions">
                    <a href="#" class="btn-explore">Khám Phá Tất Cả &rarr;</a>
                </div>
            </div>

            <!-- Grid -->
            <div class="amenities-grid">
                <!-- Card 1 -->
                <div class="amenity-card">
                    <img src="{{ asset('img/amenity-1.png') }}" alt="Elite Spa & Wellness" loading="lazy">
                </div>

                <!-- Card 2 -->
                <div class="amenity-card">
                    <img src="{{ asset('img/amenity-2.png') }}" alt="Skyline Infinity Pool" loading="lazy">
                </div>

                <!-- Card 3 -->
                <div class="amenity-card">
                    <img src="{{ asset('img/amenity-3.png') }}" alt="State-of-the-Art Fitness" loading="lazy">
                </div>

                <!-- Card 4 -->
                <div class="amenity-card">
                    <img src="{{ asset('img/amenity-4.png') }}" alt="24/7 Bespoke Concierge" loading="lazy">
                </div>
            </div>
        </div>

    </section>

    <hr class="section-divider">

    <!-- === Curated Stays Section (Dark Theme) === -->
    <section class="section stays-section">
        <div class="container">
            <div class="section-header reveal reveal-up">
                <h2 class="section-title">Lựa Chọn Nghỉ Dưỡng</h2>
                <p class="section-desc">Khám phá không gian hoàn hảo dành cho bạn ngay giữa trung tâm thành phố.</p>
            </div>

            <div class="stays-grid">
                <!-- Card 1: Deluxe Room -->
                <div class="stay-card">
                    <div class="stay-image">
                        <img src="{{ asset('img/room-deluxe.png') }}" alt="Deluxe Room">
                    </div>
                    <div class="stay-content">
                        <span class="stay-badge category-blue">HƯỚNG THÀNH PHỐ</span>
                        <h3 class="stay-title">Phòng Deluxe Cao Cấp</h3>
                        <p class="stay-description">
                            Không gian rộng 35m² với giường cỡ lớn, bàn làm việc và tầm nhìn thành phố tuyệt đẹp.
                        </p>
                        <div class="stay-footer">
                            <div class="stay-price-wrapper">
                                <span class="price-label">Từ</span>
                                <span class="price-amount">VNĐ 500.000</span>
                                <span class="price-unit">/ đêm</span>
                            </div>
                            <a href="#" class="btn-book-ghost">Đặt ngay</a>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Executive Suite -->
                <div class="stay-card">
                    <div class="stay-image">
                        <img src="{{ asset('img/room-suite.png') }}" alt="The Executive Suite">
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
                                <span class="price-amount">$450</span>
                                <span class="price-unit">/ đêm</span>
                            </div>
                            <a href="#" class="btn-book-ghost">Đặt ngay</a>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Urban Penthouse -->
                <div class="stay-card">
                    <div class="stay-image">
                        <img src="{{ asset('img/room-penthouse.png') }}" alt="The Urban Penthouse">
                        <span class="top-pick-badge">LỰA CHỌN TỐT NHẤT</span>
                    </div>
                    <div class="stay-content">
                        <span class="stay-badge category-blue">HẠNG PENTHOUSE</span>
                        <h3 class="stay-title">Penthouse Sang Trọng</h3>
                        <p class="stay-description">
                            Đỉnh cao của sự xa hoa với tầm nhìn panorama toàn cảnh, sân thượng riêng và dịch vụ quản gia.
                        </p>
                        <div class="stay-footer">
                            <div class="stay-price-wrapper">
                                <span class="price-label">Từ</span>
                                <span class="price-amount">$1200</span>
                                <span class="price-unit">/ đêm</span>
                            </div>
                            <a href="#" class="btn btn-primary btn-book-solid">Đặt ngay</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- === Testimonial Section (Full Width Image) === -->
    <section class="section testimonial-image-section" style="padding: 0;">
        <img src="{{ asset('img/Section.png') }}" alt="Section Review" style="width: 100%; display: block;">
    </section>
@endsection