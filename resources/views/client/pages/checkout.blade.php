@extends('client.layouts.master')
@section('title', 'Thông Tin Khách Hàng | Urban Luxe Hotel')

@push('styles')
@vite(['resources/css/client/checkout.css'])
@endpush

@section('content')
<main class="guest-info-page">
    <!-- Header Section -->
    <header class="guest-header" style="background-image: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.8)), url('{{ asset('img/backgroundhomepage.png') }}');">
        <div class="container">
            <span class="step-indicator">• BƯỚC 2 TRÊN 3</span>
            <h1>Thông tin khách hàng</h1>
            <p>Vui lòng hoàn tất thông tin cá nhân để hoàn tất việc giữ chỗ.</p>
        </div>
    </header>

    <div class="guest-content-grid">
        <!-- Left: Details Form -->
        <div class="details-column">
            <div class="details-form-card">
                <div class="card-title">
                    Nhập thông tin của bạn
                    <span class="required-note">Các trường có dấu (*) là bắt buộc</span>
                </div>

                <!-- Verify Email section -->
                <div class="verify-email-box">
                    <label class="verify-label">Xác nhận email để tự động điền thông tin</label>
                    <div class="input-with-button">
                        <input type="email" placeholder="Nhập địa chỉ email của bạn" class="form-control-custom">
                        <button class="btn-verify">Xác nhận Email</button>
                    </div>
                    <p class="verify-note" style="color: #64748b;">
                        <i class="fas fa-info-circle"></i>
                        Không tìm thấy tài khoản? Vui lòng nhập thông tin bên dưới để tạo tài khoản mới.
                    </p>
                </div>

                <!-- Personal Info Form -->
                <form action="#" method="POST">
                    <div class="form-row">
                        <div class="form-col">
                            <label>HỌ <span>*</span></label>
                            <input type="text" placeholder="VD: Nguyễn" class="form-control-custom">
                        </div>
                        <div class="form-col">
                            <label>TÊN <span>*</span></label>
                            <input type="text" placeholder="VD: Văn An" class="form-control-custom">
                        </div>
                    </div>

                    <div class="form-group-full">
                        <label>QUỐC GIA / VÙNG LÃNH THỔ <span>*</span></label>
                        <select class="form-control-custom">
                            <option value="VN">Việt Nam</option>
                            <option value="US">Hoa Kỳ</option>
                            <option value="JP">Nhật Bản</option>
                        </select>
                    </div>

                    <div class="form-group-full">
                        <label>SỐ ĐIỆN THOẠI <span>*</span></label>
                        <div class="phone-input-group">
                            <select class="form-control-custom">
                                <option value="+84">VN +84</option>
                                <option value="+1">US +1</option>
                                <option value="+44">UK +44</option>
                            </select>
                            <input type="text" placeholder="Nhanh số thoại của bạn" class="form-control-custom">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: Stay Summary (Sticky) -->
        <aside class="summary-column">
            <div class="stay-summary-card">
                <div class="summary-header">
                    <span class="summary-title">Tóm tắt kỳ nghỉ</span>
                    <a href="{{ route('search') }}" class="link-edit">Chỉnh sửa</a>
                </div>

                <!-- Selected Rooms List -->
                <div class="summary-rooms-list">
                    <!-- Room 1 -->
                    <div class="summary-room-item">
                        <img src="{{ asset('img/room-deluxe.png') }}" alt="Room" class="room-mini-thumb">
                        <div class="room-item-details">
                            <div class="room-item-name">
                                King Deluxe Room
                                <span>12.4M</span>
                            </div>
                            <div class="room-item-meta">Hướng Phố • 35m² (x2)</div>
                            <span class="room-tag-green">GIÁ TỐT NHẤT</span>
                        </div>
                    </div>

                    <!-- Room 2 -->
                    <div class="summary-room-item">
                        <img src="{{ asset('img/room-suite.png') }}" alt="Room" class="room-mini-thumb">
                        <div class="room-item-details">
                            <div class="room-item-name">
                                Executive Suite
                                <span>18.2M</span>
                            </div>
                            <div class="room-item-meta">Hướng Biển • 52m² (x2)</div>
                            <span class="room-tag-green">BAO GỒM BỮA SÁNG</span>
                        </div>
                    </div>
                </div>

                <!-- Stay Details Info -->
                <div class="stay-dates-summary">
                    <div class="date-box">
                        <span class="date-label">NGÀY NHẬN</span>
                        <span class="date-val">24 Th10</span>
                    </div>
                    <div class="date-box">
                        <span class="date-label">NGÀY TRẢ</span>
                        <span class="date-val">27 Th10</span>
                    </div>
                </div>

                <div class="extra-info-small">
                    <span><i class="fas fa-users"></i> 8 Người lớn, 2 Trẻ em</span>
                    <span>3 Đêm • 5 Phòng</span>
                </div>

                <!-- Pricing Breakdown -->
                <div class="pricing-breakdown">
                    <div class="p-total-line">
                        <div class="p-item">
                            <span>Tạm tính (3 đêm)</span>
                            <span>75.600.000 đ</span>
                        </div>
                        <div class="p-item">
                            <span>Thuế & Phí (10%)</span>
                            <span>7.560.000 đ</span>
                        </div>
                        <div class="p-item" style="margin-top: 15px;">
                            <span style="font-weight: 700; color: #0f172a;">TỔNG THANH TOÁN</span>
                            <span class="total-amount-val">79.380.000 đ</span>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <a href="{{ route('payment') }}" style="text-decoration: none;">
                    <button class="btn-continue-long">
                        TIẾP TỤC THANH TOÁN
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </a>

                <div class="security-footer">
                    <i class="fas fa-lock"></i>
                    Đặt phòng an toàn • Mã hóa SSL
                </div>
            </div>

            <!-- Assistance Box -->
            <div class="assistance-card">
                <div class="assistance-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <div class="assistance-text">
                    <strong>Bạn cần hỗ trợ?</strong>
                    Liên hệ đội ngũ hỗ trợ 24/7 của chúng tôi tại +1 (800) 123-4567
                </div>
            </div>
        </aside>
    </div>
</main>
@endsection
