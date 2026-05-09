@extends('client.layouts.master')

@section('title', 'Urban Luxe | Khách sạn Nghỉ dưỡng Sang trọng Trung tâm Thành phố')
@section('meta_description', 'Khám phá Urban Luxe - Khách sạn 5 sao với thiết kế thanh lịch, tiện nghi đẳng cấp và dịch vụ nghỉ dưỡng thượng lưu ngay tại trung tâm thành phố.')

@push('styles')
@vite(['resources/js/client/homepage.js'])
@endpush

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
                Trải nghiệm sự xa hoa chốn thành thị với thiết kế thanh lịch và tiện nghi. Điểm<br>dừng chân hoàn hảo dành riêng cho những tín đồ xê dịch hiện đại.
            </p>
        </div>

        <!-- === Widget Đặt Phòng === -->
        <div class="booking-widget">
            <form class="booking-form js-home-booking-form" action="{{ route('search') }}" method="GET">
                
                <!-- CHECK IN -->
                <div class="form-group">
                    <label>NHẬN PHÒNG</label>
                    <div class="input-wrapper js-date-trigger" data-picker="checkin">
                        <!-- Calendar Icon -->
                        <svg class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        <input type="text" id="homeCheckinDisplay" placeholder="Chọn Ngày" class="input-field" readonly style="cursor: pointer;">
                        <input type="date" id="homeCheckinPicker" name="checkin" class="native-date-picker" tabindex="-1" aria-hidden="true">
                    </div>
                </div>

                <!-- CHECK OUT -->
                <div class="form-group">
                    <label>TRẢ PHÒNG</label>
                    <div class="input-wrapper js-date-trigger" data-picker="checkout">
                        <!-- Calendar Icon -->
                        <svg class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        <input type="text" id="homeCheckoutDisplay" placeholder="Chọn Ngày" class="input-field" readonly style="cursor: pointer;">
                        <input type="date" id="homeCheckoutPicker" name="checkout" class="native-date-picker" tabindex="-1" aria-hidden="true">
                    </div>
                </div>

                <!-- GUESTS -->
                <div class="form-group guest-group">
                    <label>SỐ KHÁCH</label>
                    <div class="input-wrapper js-guest-trigger" style="cursor: pointer;">
                        <!-- User Icon -->
                        <svg class="icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <input type="text" id="homeGuestsDisplay" value="2 Người lớn, 0 Trẻ em, 1 Phòng" class="input-field" readonly style="cursor: pointer;">
                        <!-- Down Chevron -->
                        <svg class="icon-right" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </div>

                    <div class="guest-dropdown" id="homeGuestDropdown" hidden>
                        <div class="guest-control-row">
                            <div class="guest-control-label">
                                <strong>Người lớn</strong>
                                <small>Từ 13 tuổi</small>
                            </div>
                            <div class="guest-stepper">
                                <button type="button" class="guest-step-btn" data-guest-target="adults" data-action="decrease">-</button>
                                <span class="guest-count" data-count-for="adults">2</span>
                                <button type="button" class="guest-step-btn" data-guest-target="adults" data-action="increase">+</button>
                            </div>
                        </div>

                        <div class="guest-control-row">
                            <div class="guest-control-label">
                                <strong>Trẻ em</strong>
                                <small>0 - 12 tuổi</small>
                            </div>
                            <div class="guest-stepper">
                                <button type="button" class="guest-step-btn" data-guest-target="children" data-action="decrease">-</button>
                                <span class="guest-count" data-count-for="children">0</span>
                                <button type="button" class="guest-step-btn" data-guest-target="children" data-action="increase">+</button>
                            </div>
                        </div>

                        <div class="guest-control-row">
                            <div class="guest-control-label">
                                <strong>Phòng</strong>
                                <small>Số lượng phòng</small>
                            </div>
                            <div class="guest-stepper">
                                <button type="button" class="guest-step-btn" data-guest-target="rooms" data-action="decrease">-</button>
                                <span class="guest-count" data-count-for="rooms">1</span>
                                <button type="button" class="guest-step-btn" data-guest-target="rooms" data-action="increase">+</button>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="adults" id="homeAdults" value="2">
                    <input type="hidden" name="children" id="homeChildren" value="0">
                    <input type="hidden" name="rooms" id="homeRooms" value="1">
                </div>

                <!-- NÚT SUBMIT -->
                <div class="form-group submit-group">
                    <button type="submit" class="btn btn-primary submit-btn">
                        <!-- Search Icon -->
                        <svg class="icon-search" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
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
                    <a href="{{ route('amenities') }}" class="btn-explore">Khám Phá Tất Cả &rarr;</a>
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
                @forelse($featuredRoomTypes as $index => $roomType)
                    @php
                        $firstImage = $roomType->images->first();
                        $imagePath = $firstImage?->image_url ? ltrim($firstImage->image_url, '/') : 'img/room-deluxe.png';
                        $description = $roomType->description ?: 'Không gian nghỉ dưỡng tinh tế với tiện nghi hiện đại và dịch vụ chuẩn cao cấp.';
                    @endphp

                    <div class="stay-card">
                        <div class="stay-image">
                            <img src="{{ asset($imagePath) }}" alt="{{ $roomType->name }}">
                            @if($index === 0)
                                <span class="top-pick-badge">LỰA CHỌN TỐT NHẤT</span>
                            @endif
                        </div>
                        <div class="stay-content">
                            <span class="stay-badge category-blue">{{ $roomType->code ? 'HẠNG ' . $roomType->code : 'HẠNG PHÒNG' }}</span>
                            <h3 class="stay-title">{{ $roomType->name }}</h3>
                            <p class="stay-description">
                                {{ \Illuminate\Support\Str::limit(strip_tags((string) $description), 130) }}
                            </p>
                            <div class="stay-footer">
                                <div class="stay-price-wrapper">
                                    <span class="price-label">Từ</span>
                                    <span class="price-amount">{{ number_format((float) $roomType->daily_price, 0, ',', '.') }} VNĐ</span>
                                    <span class="price-unit">/ đêm</span>
                                </div>
                                <a href="{{ route('search', ['room_type' => $roomType->id]) }}" class="{{ $index === 0 ? 'btn btn-primary btn-book-solid' : 'btn-book-ghost' }}">Đặt ngay</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="stay-card">
                        <div class="stay-image">
                            <img src="{{ asset('img/room-deluxe.png') }}" alt="Phòng nghỉ">
                        </div>
                        <div class="stay-content">
                            <span class="stay-badge category-blue">URBAN LUXE</span>
                            <h3 class="stay-title">Không gian nghỉ dưỡng đẳng cấp</h3>
                            <p class="stay-description">
                                Dữ liệu hạng phòng đang được cập nhật. Vui lòng quay lại sau hoặc khám phá danh sách phòng hiện có.
                            </p>
                            <div class="stay-footer">
                                <div class="stay-price-wrapper">
                                    <span class="price-label">Từ</span>
                                    <span class="price-amount">Liên hệ</span>
                                </div>
                                <a href="{{ route('room') }}" class="btn-book-ghost">Xem phòng</a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- === Testimonial Section (Full Width Image) === -->
    <section class="section testimonial-image-section" style="padding: 0;">
        <img src="{{ asset('img/Section.png') }}" alt="Section Review" style="width: 100%; display: block;">
    </section>
@endsection
