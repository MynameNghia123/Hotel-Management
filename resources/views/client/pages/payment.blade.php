@extends('client.layouts.master')
@section('title', 'Thanh Toán Đặt Phòng | Urban Luxe Hotel')

@push('styles')
@vite(['resources/css/client/payment.css'])
@endpush

@section('content')
<main class="payment-page">
    <header class="payment-header" style="background-image: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.8)), url('{{ asset('img/backgroundhomepage.png') }}');">
        <div class="container">
            <span class="step-indicator">• BƯỚC 3 TRÊN 3</span>
            <h1>Phương thức thanh toán</h1>
            <p>Vui lòng chọn phương thức thanh toán an toàn để hoàn tất việc giữ phòng cá nhân.</p>
        </div>
    </header>

    <form action="{{ route('payment.process') }}" method="POST">
        @csrf
        <div class="payment-content-grid">
            <!-- Left: Payment Options -->
            <div class="options-column">
                <div class="payment-option-card">
                    <div class="card-title">Chọn cách thức trả tiền</div>
                    
                    <div class="payment-methods-list">
                        <!-- Pay at Hotel -->
                        <label class="method-item active">
                            <input type="radio" name="payment_type" value="pay_at_hotel" checked>
                            <div class="method-box">
                                <div class="method-main">
                                    <i class="fas fa-concierge-bell"></i>
                                    <span>Thanh toán tại quầy</span>
                                </div>
                                <span class="badget-info">Tiện lợi</span>
                            </div>
                        </label>

                        <!-- VNPAY -->
                        <label class="method-item">
                            <input type="radio" name="payment_type" value="vnpay">
                            <div class="method-box">
                                <div class="method-main">
                                    <i class="fas fa-credit-card"></i>
                                    <span>Thanh toán qua VNPAY</span>
                                </div>
                                <span class="badget-info" style="color: #2563eb; background: rgba(37, 99, 235, 0.1);">Khuyên dùng</span>
                            </div>
                        </label>

                        <!-- Bank Transfer -->
                        <label class="method-item">
                            <input type="radio" name="payment_type" value="bank_transfer">
                            <div class="method-box">
                                <div class="method-main">
                                    <i class="fas fa-university"></i>
                                    <span>Chuyển Khoản Ngân Hàng</span>
                                </div>
                                <span class="badget-info">Xử lý trong 24h</span>
                            </div>
                        </label>
                    </div>

                    <div style="margin-top: 20px; padding: 15px; background: rgba(37, 99, 235, 0.1); border-left: 4px solid #2563eb; border-radius: 8px; font-size: 0.9rem; color: #94a3b8; line-height: 1.5;">
                        <i class="fas fa-info-circle" style="color: #60a5fa; margin-right: 5px;"></i>
                        Vui lòng chuẩn bị sẵn thẻ ATM/Visa hoặc ứng dụng Mobile Banking có hỗ trợ VNPAY-QR để thanh toán nhanh chóng.
                    </div>
                </div>
            </div>

            <!-- Right: Stay Summary -->
            <aside class="summary-column">
                <div class="stay-summary-card">
                    <div class="summary-header">
                        <span class="summary-title">Mã đặt phòng: #{{ $booking->id }}</span>
                    </div>

                    <!-- Selected Rooms List -->
                    <div class="summary-rooms-list">
                        @foreach($booking->bookingDetails as $detail)
                        <div class="summary-room-item">
                            @php
                                $imageUrl = asset('img/room-deluxe.png');
                                if ($detail->room->roomType->images && $detail->room->roomType->images->count() > 0) {
                                    $imageUrl = asset('storage/' . $detail->room->roomType->images->first()->image_path);
                                }
                            @endphp
                            <img src="{{ $imageUrl }}" alt="Room" class="room-mini-thumb">
                            <div class="room-item-details">
                                <div class="room-item-name">
                                    {{ $detail->room->name }} - {{ $detail->room->roomType->name }}
                                </div>
                                <div class="room-item-meta">{{ $detail->checkin_date->format('d/m/Y') }} - {{ $detail->checkout_date->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pricing Breakdown -->
                    <div class="pricing-breakdown">
                        <div class="p-total-line">
                            <div class="p-item" style="margin-top: 15px;">
                                <span style="font-weight: 700; color: #0f172a;">TỔNG THANH TOÁN</span>
                                <span class="total-amount-val">{{ number_format($booking->final_amount, 0, ',', '.') }} đ</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <button type="submit" class="btn-pay-now" style="width: 100%; border: none; cursor: pointer;">
                        <i class="fas fa-shield-alt"></i>
                        XÁC NHẬN THANH TOÁN
                    </button>
                    
                    <p class="secure-text">
                        <i class="fas fa-lock"></i>
                        Thông tin được bảo mật tuyệt đối.
                    </p>
                </div>
            </aside>
        </div>
    </form>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const methodItems = document.querySelectorAll('.method-item');
        const radioInputs = document.querySelectorAll('input[name="payment_type"]');

        radioInputs.forEach(input => {
            input.addEventListener('change', function() {
                // Remove active class from all
                methodItems.forEach(item => item.classList.remove('active'));
                
                // Add active class to the parent label of the checked radio
                if (this.checked) {
                    this.closest('.method-item').classList.add('active');
                }
            });
        });
    });
</script>
@endpush
