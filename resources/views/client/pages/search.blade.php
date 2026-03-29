@extends ('client.layouts.master')
@section('title', 'Tìm Kiếm Phòng Nghỉ | Urban Luxe Hotel')
@section('meta_description', 'Tìm kiếm phòng nghỉ tại Urban Luxe Hotel với các loại phòng Deluxe, Suite và Penthouse sang trọng bậc nhất.')
@push('styles')
@vite(['resources/css/client/search.css'])
@endpush
@section('content')
<main class="search-page">
    <!-- Header Search Bar -->
    <section class="search-header-container" style="background-image: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.8)), url('{{ asset('img/backgroundhomepage.png') }}');">
        <div class="search-bar-inline">
            <div class="sb-item">
                <span class="sb-label">Check In</span>
                <div class="sb-input-group">
                    <i class="far fa-calendar-alt"></i>
                    <span>Oct 24, 2024</span>
                </div>
            </div>
            <div class="sb-item">
                <span class="sb-label">Check Out</span>
                <div class="sb-input-group">
                    <i class="far fa-calendar-alt"></i>
                    <span>Oct 27, 2024</span>
                </div>
            </div>
            <div class="sb-item">
                <span class="sb-label">Guests</span>
                <div class="sb-input-group">
                    <i class="fas fa-users"></i>
                    <span>2 Adults, 0 Children, 2 rooms</span>
                </div>
            </div>
            <button class="btn-update-search">
                <i class="fas fa-search"></i>
                Update Search
            </button>
        </div>
    </section>

    <!-- Results Section -->
    <section class="results-container">
        <div class="results-header">
            <div class="results-title">
                <h2>Hãy chọn phòng</h2>
                <p>Hiện có 3 phòng phù hợp với bạn</p>
            </div>
            <div class="results-actions">
                <button class="btn-action-outline"><i class="fas fa-sliders-h"></i> Filter</button>
                <button class="btn-action-outline"><i class="fas fa-sort-amount-down"></i> Sort</button>
            </div>
        </div>

        <!-- Room List Table -->
        <div class="room-result-table">
            <!-- Table Header -->
            <div class="table-header">
                <div class="th-label">Thông tin phòng</div>
                <div class="th-label">Tiện nghi</div>
                <div class="th-label">Sức chứa</div>
                <div class="th-label">Giá & Giá trị</div>
                <div class="th-label">Đặt phòng</div>
            </div>

            <!-- Room 1: King Deluxe Room -->
            <div class="room-row">
                <div class="col-info">
                    <img src="{{ asset('img/room-deluxe.png') }}" alt="King Deluxe Room" class="room-thumb-small">
                    <div>
                        <h3 class="room-name-small">King Deluxe Room</h3>
                        <div class="room-meta-small">
                            <span><i class="fas fa-expand"></i> 35 m² / 376 ft²</span>
                            <span><i class="fas fa-user-friends"></i> Max 2 adults</span>
                            <span><i class="fas fa-bed"></i> 1 King bed</span>
                        </div>
                        <a href="#" class="link-photos">See photos <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-amenities">
                    <div class="amenity-mini"><i class="fas fa-wifi"></i> Wi-Fi Miễn phí</div>
                    <div class="amenity-mini"><i class="fas fa-snowflake"></i> Điều hòa</div>
                    <div class="amenity-mini"><i class="fas fa-shower"></i> Tắm riêng</div>
                    <div class="amenity-mini"><i class="fas fa-wind"></i> Máy sấy tóc</div>
                    <div class="amenity-mini"><i class="fas fa-wine-bottle"></i> Mini bar</div>
                    <div class="amenity-mini"><i class="fas fa-glass-whiskey"></i> Nước uống</div>
                </div>
                <div class="col-capacity">
                    <i class="fas fa-user"></i> <i class="fas fa-user"></i>
                </div>
                <div class="col-price">
                    <div class="price-main">6,200,000 đ</div>
                    <div class="price-sub">mỗi đêm</div>
                    <div class="badge-tag badge-best"><i class="fas fa-check"></i> Giá tốt nhất</div>
                    <div class="badge-tag badge-suggest"><i class="fas fa-thumbs-up"></i> Được đề xuất</div>
                </div>
                <div class="col-booking">
                    <span class="sb-label">Số lượng</span>
                    <select class="select-qty">
                        <option>1</option>
                        <option>2</option>
                    </select>
                </div>
            </div>

            <!-- Room 2: Executive Suite -->
            <div class="room-row">
                <div class="col-info">
                    <img src="{{ asset('img/room-suite.png') }}" alt="Executive Suite" class="room-thumb-small">
                    <div>
                        <h3 class="room-name-small">Executive Suite</h3>
                        <div class="room-meta-small">
                            <span><i class="fas fa-expand"></i> 55 m² / 592 ft²</span>
                            <span><i class="fas fa-user-friends"></i> Max 3 adults</span>
                            <span><i class="fas fa-bed"></i> 1 King + Sofa</span>
                        </div>
                        <a href="#" class="link-photos">See photos <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-amenities">
                    <div class="amenity-mini"><i class="fas fa-wifi"></i> Wi-Fi Miễn phí</div>
                    <div class="amenity-mini"><i class="fas fa-snowflake"></i> Điều hòa</div>
                    <div class="amenity-mini"><i class="fas fa-mug-hot"></i> Espresso</div>
                    <div class="amenity-mini"><i class="fas fa-hot-tub"></i> Bồn tắm</div>
                    <div class="amenity-mini"><i class="fas fa-shower"></i> Rain Shower</div>
                </div>
                <div class="col-capacity">
                    <i class="fas fa-user"></i> <i class="fas fa-user"></i> <i class="fas fa-user-plus"></i>
                </div>
                <div class="col-price">
                    <div class="price-main">11,500,000 đ</div>
                    <div class="price-sub">mỗi đêm</div>
                    <div class="badge-tag badge-couple"><i class="fas fa-heart"></i> Lựa chọn của cặp đôi</div>
                </div>
                <div class="col-booking">
                    <span class="sb-label">Số lượng</span>
                    <select class="select-qty">
                        <option>0</option>
                        <option>1</option>
                    </select>
                </div>
            </div>

            <!-- Room 3: Urban Penthouse -->
            <div class="room-row">
                <div class="col-info">
                    <img src="{{ asset('img/room-penthouse.png') }}" alt="Urban Penthouse" class="room-thumb-small">
                    <div>
                        <h3 class="room-name-small">Urban Penthouse</h3>
                        <div class="room-meta-small">
                            <span><i class="fas fa-expand"></i> 120 m² / 1291 ft²</span>
                            <span><i class="fas fa-user-friends"></i> Max 4 adults</span>
                            <span><i class="fas fa-bed"></i> 2 King beds</span>
                        </div>
                        <a href="#" class="link-photos">See photos <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-amenities">
                    <div class="amenity-mini"><i class="fas fa-swimmer"></i> Hồ bơi riêng</div>
                    <div class="amenity-mini"><i class="fas fa-spa"></i> Spa tại phòng</div>
                    <div class="amenity-mini"><i class="fas fa-glass-cheers"></i> Quầy bar</div>
                    <div class="amenity-mini"><i class="fas fa-couch"></i> Ban công</div>
                </div>
                <div class="col-capacity">
                    <i class="fas fa-user"></i> <i class="fas fa-user"></i> <i class="fas fa-user"></i> <i class="fas fa-user"></i>
                </div>
                <div class="col-price">
                    <div class="price-main">29,900,000 đ</div>
                    <div class="price-sub">mỗi đêm</div>
                    <div class="badge-tag badge-suggest"><i class="fas fa-star"></i> Top Rated</div>
                </div>
                <div class="col-booking">
                    <span class="sb-label">Số lượng</span>
                    <select class="select-qty">
                        <option>0</option>
                        <option>1</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- COMPACT BOOKING SUMMARY CARD -->
        <div class="booking-summary-wrapper">
            <div class="booking-summary-card">
                <span class="summary-total-label">TỔNG GIÁ (3 ĐÊM)</span>
                <span class="summary-total-value">18,600,000 đ</span>
                <a href="{{ route('payment') }}" style="text-decoration: none; width: 100%;">
                    <button class="btn-book-now-final">
                        Đặt phòng ngay
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </a>
            </div>
        </div>
    </section>
</main>
@endsection