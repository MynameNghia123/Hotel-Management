@extends('client.layouts.master')

@section('title', 'Đặt Phòng Thành Công | Urban Luxe Hotel')

@push('styles')
@vite(['resources/css/client/success.css'])
@endpush

@section('content')
<main class="success-page">
    <!-- Header with Background Overlay -->
    <header class="success-header" style="background-image: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.85)), url('{{ asset('img/backgroundhomepage.png') }}');">
        <div class="container">
            <div class="check-icon-wrapper">
                <i class="fas fa-check"></i>
            </div>
            <h1>Đặt phòng thành công!</h1>
            <p>Chào mừng bạn đến với Urban Luxe. Yêu cầu đặt phòng của bạn đã được hệ thống xác nhận an toàn.</p>
            
            <div class="booking-id-pill">
                MÃ ĐẶT PHÒNG <b>#{{ $booking->id }}</b>
            </div>
        </div>
    </header>

    <!-- Main Summary Card -->
    <section class="summary-main-card">
        <!-- Top Toolbar -->
        <div class="card-top-actions">
            <div>
                <h2 class="summary-title-main">Tóm tắt đơn hàng</h2>
                <p class="summary-email-note">Thông tin xác nhận đã được gửi tới <b>{{ $booking->customer->email ?? '' }}</b></p>
            </div>
        </div>

        <!-- Info Grid -->
        <div class="reservation-info-grid">
            <div class="info-item">
                <span class="info-box-label">NHẬN PHÒNG</span>
                <span class="info-box-val">{{ $booking->bookingDetails->first()->checkin_date->format('d/m/Y') }}</span>
                <span class="info-box-sub">Sau 14:00</span>
            </div>
            <div class="info-item">
                <span class="info-box-label">TRẢ PHÒNG</span>
                <span class="info-box-val">{{ $booking->bookingDetails->first()->checkout_date->format('d/m/Y') }}</span>
                <span class="info-box-sub">Trước 12:00</span>
            </div>
            <div class="info-item">
                <span class="info-box-label">SỐ LƯỢNG PHÒNG</span>
                <span class="info-box-val">{{ $booking->bookingDetails->count() }} Phòng</span>
                <span class="info-box-sub">{{ $booking->bookingDetails->first()->checkin_date->diffInDays($booking->bookingDetails->first()->checkout_date) }} Đêm</span>
            </div>
            <div class="info-item">
                <span class="info-box-label">TRẠNG THÁI</span>
                <span class="status-pill">• {{ $booking->status }}</span>
                @if($booking->payments->isNotEmpty())
                    <span class="info-box-sub" style="color: #16a34a; font-weight: 700;">Đã thanh toán (VNPAY)</span>
                @else
                    <span class="info-box-sub" style="color: #ea580c; font-weight: 700;">Chưa thanh toán</span>
                @endif
            </div>
        </div>

        <!-- Room Details Block -->
        <div class="room-details-block">
            <div class="rd-header">
                <h3 class="rd-title">Chi tiết phòng</h3>
            </div>

            <div class="room-main-summary-row">
                <img src="{{ asset('img/room-deluxe.png') }}" alt="Room" class="rd-thumb-large">
                
                <div class="rd-main-info">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <h4>Tổng cộng {{ $booking->bookingDetails->count() }} phòng</h4>
                            <p>Tên khách chính: {{ $booking->customer->first_name ?? '' }} {{ $booking->customer->last_name ?? '' }}</p>
                        </div>
                        <div class="rd-total-price">{{ number_format($booking->final_amount, 0, ',', '.') }} đ</div>
                    </div>

                    <div class="sub-rooms-grid">
                        @php
                            // Gom nhóm các phòng cùng loại lại để hiển thị
                            $groupedRooms = $booking->bookingDetails->groupBy(function($detail) {
                                return $detail->room->roomType->name;
                            });
                        @endphp

                        @foreach($groupedRooms as $roomTypeName => $details)
                        <div class="sub-room-card">
                            <div class="src-key">
                                <i class="fas fa-bed"></i>
                                <span>{{ $details->count() }}x {{ $roomTypeName }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Final Buttons -->
        <div class="final-actions-row">
            <a href="{{ route('home') }}" style="text-decoration: none;">
                <button class="btn-success-main btn-primary-blue">
                    <i class="fas fa-home"></i>
                    Về trang chủ
                </button>
            </a>
            <a href="{{ route('profile') }}" style="text-decoration: none;">
                <button class="btn-success-main btn-outline-gray">
                    <i class="far fa-user"></i>
                    Quản lý đặt phòng
                </button>
            </a>
        </div>

        <!-- Footer Security -->
        <div class="security-footer-small">
            <i class="fas fa-shield-alt"></i>
            Giao dịch được xử lý an toàn vào ngày {{ now()->format('d/m/Y') }} lúc {{ now()->format('H:i') }}
        </div>
    </section>
</main>
@endsection
