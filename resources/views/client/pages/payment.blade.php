@extends('client.layouts.master')
@section('title', 'Thanh Toán Đặt Phòng | Urban Luxe Hotel')

@push('styles')
@vite(['resources/css/client/payment.css'])
@endpush

@section('content')
<main class="payment-page">
    <!-- Header Section (Sync with Checkout) -->
    <header class="payment-header" style="background-image: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.8)), url('{{ asset('img/backgroundhomepage.png') }}');">
        <div class="container">
            <span class="step-indicator">• BƯỚC 3 TRÊN 3</span>
            <h1>Phương thức thanh toán</h1>
            <p>Vui lòng chọn phương thức thanh toán an toàn để hoàn tất việc giữ phòng cá nhân.</p>
        </div>
    </header>

    <div class="payment-content-grid">
        <!-- Left: Payment Options -->
        <div class="options-column">
            <div class="payment-option-card">
                <div class="card-title">Chọn cách thức trả tiền</div>
                
                <div class="payment-methods-list">
                    <!-- Credit Card -->
                    <label class="method-item active">
                        <input type="radio" name="payment_type" checked>
                        <div class="method-box">
                            <div class="method-main">
                                <i class="fas fa-credit-card"></i>
                                <span>Thẻ Tín Dụng / Ghi Nợ</span>
                            </div>
                            <div class="card-icons">
                                <i class="fab fa-cc-visa"></i>
                                <i class="fab fa-cc-mastercard"></i>
                                <i class="fab fa-cc-jcb"></i>
                            </div>
                        </div>
                    </label>

                    <!-- Bank Transfer -->
                    <label class="method-item">
                        <input type="radio" name="payment_type">
                        <div class="method-box">
                            <div class="method-main">
                                <i class="fas fa-university"></i>
                                <span>Chuyển Khoản Ngân Hàng</span>
                            </div>
                            <span class="badget-info">Xử lý trong 24h</span>
                        </div>
                    </label>

                    <!-- E-Wallet -->
                    <label class="method-item">
                        <input type="radio" name="payment_type">
                        <div class="method-box">
                            <div class="method-main">
                                <i class="fas fa-wallet"></i>
                                <span>Ví Điện Tử (Momo / ZaloPay)</span>
                            </div>
                        </div>
                    </label>
                </div>

                <!-- Card Details Form (Visible for Credit Card) -->
                <div class="card-details-section">
                    <div class="form-group-full">
                        <label>TÊN TRÊN THẺ <span>*</span></label>
                        <input type="text" placeholder="VD: NGUYEN VAN AN" class="form-control-luxe">
                    </div>
                    <div class="form-group-full">
                        <label>SỐ THẺ <span>*</span></label>
                        <div class="input-with-icon">
                            <input type="text" placeholder="0000 0000 0000 0000" class="form-control-luxe">
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>
                    <div class="form-row-payment">
                        <div class="form-col">
                            <label>HẠN SỬ DỤNG <span>*</span></label>
                            <input type="text" placeholder="MM / YY" class="form-control-luxe">
                        </div>
                        <div class="form-col">
                            <label>CVV <span>*</span></label>
                            <input type="password" placeholder="***" class="form-control-luxe">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Stay Summary (Detailed from Checkout) -->
        <aside class="summary-column">
            <div class="stay-summary-card">
                <div class="summary-header">
                    <span class="summary-title">Tóm tắt kỳ nghỉ</span>
                    <a href="{{ route('checkout') }}" class="link-edit">Chỉnh sửa</a>
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
                <a href="{{ route('success') }}" style="text-decoration: none;">
                    <button class="btn-pay-now" style="width: 100%;">
                        <i class="fas fa-shield-alt"></i>
                        XÁC NHẬN THANH TOÁN
                    </button>
                </a>
                
                <p class="secure-text">
                    <i class="fas fa-lock"></i>
                    Bảo mật thanh toán chuẩn 256-bit SSL.
                </p>
            </div>
        </aside>
    </div>
</main>
@endsection
