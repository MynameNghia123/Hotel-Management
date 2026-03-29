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
                MÃ ĐẶT PHÒNG <b>#12345</b>
                <i class="far fa-copy"></i>
            </div>
        </div>
    </header>

    <!-- Main Summary Card -->
    <section class="summary-main-card">
        <!-- Top Toolbar -->
        <div class="card-top-actions">
            <div>
                <h2 class="summary-title-main">Tóm tắt đơn hàng</h2>
                <p class="summary-email-note">Thông tin xác nhận đã được gửi tới <b>thomas.anderson@example.com</b></p>
            </div>
            <div class="action-buttons-group">
                <button class="btn-mini-action"><i class="fas fa-print"></i> In đơn</button>
                <button class="btn-mini-action"><i class="far fa-envelope"></i> Gửi Email</button>
            </div>
        </div>

        <!-- Info Grid -->
        <div class="reservation-info-grid">
            <div class="info-item">
                <span class="info-box-label">NHẬN PHÒNG</span>
                <span class="info-box-val">24 Th10, 2024</span>
                <span class="info-box-sub">Sau 15:00</span>
            </div>
            <div class="info-item">
                <span class="info-box-label">TRẢ PHÒNG</span>
                <span class="info-box-val">27 Th10, 2024</span>
                <span class="info-box-sub">Trước 11:00</span>
            </div>
            <div class="info-item">
                <span class="info-box-label">SỐ LƯỢNG KHÁCH</span>
                <span class="info-box-val">20 Người lớn</span>
                <span class="info-box-sub">3 Đêm</span>
            </div>
            <div class="info-item">
                <span class="info-box-label">TRẠNG THÁI</span>
                <span class="status-pill">• Đã xác nhận</span>
                <span class="info-box-sub" style="color: #16a34a; font-weight: 700;">Đã thanh toán hết</span>
            </div>
        </div>

        <!-- Room Details Block -->
        <div class="room-details-block">
            <div class="rd-header">
                <h3 class="rd-title">Chi tiết phòng</h3>
                <a href="#" class="view-policy-link">Chính sách hủy phòng</a>
            </div>

            <div class="room-main-summary-row">
                <img src="{{ asset('img/room-deluxe.png') }}" alt="Room" class="rd-thumb-large">
                
                <div class="rd-main-info">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <h4>Tổng cộng 10 phòng</h4>
                            <p>Tên khách chính: Thomas Anderson</p>
                        </div>
                        <div class="rd-total-price">200,000,000 đ</div>
                    </div>

                    <div class="sub-rooms-grid">
                        <div class="sub-room-card">
                            <div class="src-key">
                                <i class="fas fa-bed"></i>
                                <span>6x King Deluxe</span>
                            </div>
                            <span class="src-tag">Hướng Biển</span>
                        </div>
                        <div class="sub-room-card">
                            <div class="src-key">
                                <i class="fas fa-bed"></i>
                                <span>4x Executive Suite</span>
                            </div>
                            <span class="src-tag">Hướng Thành Phố</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Final Buttons -->
        <div class="final-actions-row">
            <button class="btn-success-main btn-primary-blue">
                <i class="fas fa-download"></i>
                Tải hóa đơn
            </button>
            <button class="btn-success-main btn-outline-gray">
                <i class="far fa-calendar-alt"></i>
                Quản lý đặt phòng
            </button>
        </div>

        <!-- Footer Security -->
        <div class="security-footer-small">
            <i class="fas fa-shield-alt"></i>
            Giao dịch được xử lý an toàn vào ngày 24 tháng 10 năm 2024 lúc 14:30
        </div>
    </section>
</main>
@endsection
