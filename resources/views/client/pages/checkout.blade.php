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

    @if(session('error'))
        <div style="max-width: 1200px; margin: 20px auto; padding: 15px; background-color: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); color: #ef4444; border-radius: 8px;">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
        @csrf
        <div class="guest-content-grid">
            <!-- Left: Details Form -->
            <div class="details-column">
                <div class="details-form-card">
                    <div class="card-title">
                        Nhập thông tin của bạn
                        <span class="required-note">Các trường có dấu (*) là bắt buộc</span>
                    </div>

                    @if(!$user)
                    <!-- Verify Email section -->
                    <div class="verify-email-box">
                        <label class="verify-label">Bạn đã có tài khoản?</label>
                        <p class="verify-note" style="color: #64748b; margin-top: 5px;">
                            <a href="{{ route('login') }}" style="color: #2563eb; text-decoration: underline;">Đăng nhập ngay</a> để tự động điền thông tin và tích lũy điểm thưởng.
                        </p>
                    </div>
                    @endif

                    <!-- Personal Info Form -->
                    <div class="form-row">
                        <div class="form-col">
                            <label>HỌ <span>*</span></label>
                            <input type="text" name="last_name" value="{{ old('last_name', $user ? $user->last_name : '') }}" placeholder="VD: Nguyễn" class="form-control-custom" required {{ $user ? 'readonly' : '' }}>
                        </div>
                        <div class="form-col">
                            <label>TÊN <span>*</span></label>
                            <input type="text" name="first_name" value="{{ old('first_name', $user ? $user->first_name : '') }}" placeholder="VD: Văn An" class="form-control-custom" required {{ $user ? 'readonly' : '' }}>
                        </div>
                    </div>

                    <div class="form-group-full" style="margin-top: 15px;">
                        <label>ĐỊA CHỈ EMAIL <span>*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user ? $user->email : '') }}" placeholder="email@example.com" class="form-control-custom" required {{ $user ? 'readonly' : '' }}>
                    </div>

                    <div class="form-group-full" style="margin-top: 15px;">
                        <label>SỐ ĐIỆN THOẠI <span>*</span></label>
                        <input type="text" name="phone" value="{{ old('phone', $user ? $user->phone_number : '') }}" placeholder="Nhập số điện thoại của bạn" class="form-control-custom" required>
                    </div>
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
                        @foreach($roomDetails as $detail)
                        <div class="summary-room-item">
                            @php
                                $imageUrl = asset('img/room-deluxe.png');
                                if ($detail['roomType']->images && $detail['roomType']->images->count() > 0) {
                                    $imageUrl = asset('storage/' . $detail['roomType']->images->first()->image_path);
                                }
                            @endphp
                            <img src="{{ $imageUrl }}" alt="Room" class="room-mini-thumb">
                            <div class="room-item-details">
                                <div class="room-item-name">
                                    {{ $detail['roomType']->name }}
                                    <span>{{ number_format($detail['subTotal'], 0, ',', '.') }} đ</span>
                                </div>
                                <div class="room-item-meta">{{ $detail['roomType']->width * $detail['roomType']->height }}m² (x{{ $detail['qty'] }})</div>
                                <span class="room-tag-green">GIÁ TỐT NHẤT</span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Stay Details Info -->
                    <div class="stay-dates-summary">
                        <div class="date-box">
                            <span class="date-label">NGÀY NHẬN</span>
                            <span class="date-val">{{ $checkin->format('d/m/Y') }}</span>
                        </div>
                        <div class="date-box">
                            <span class="date-label">NGÀY TRẢ</span>
                            <span class="date-val">{{ $checkout->format('d/m/Y') }}</span>
                        </div>
                    </div>

                    <div class="extra-info-small">
                        <span>{{ $nights }} Đêm • {{ collect($roomDetails)->sum('qty') }} Phòng</span>
                    </div>

                    <!-- Pricing Breakdown -->
                    <div class="pricing-breakdown">
                        <div class="p-total-line">
                            <div class="p-item" style="margin-top: 15px;">
                                <span style="font-weight: 700; color: #0f172a;">TỔNG THANH TOÁN</span>
                                <span class="total-amount-val">{{ number_format($totalAmount, 0, ',', '.') }} đ</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <button type="submit" class="btn-continue-long" style="width: 100%; border: none; cursor: pointer;">
                        XÁC NHẬN ĐẶT PHÒNG
                        <i class="fas fa-chevron-right"></i>
                    </button>

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
                        Liên hệ đội ngũ hỗ trợ 24/7 của chúng tôi tại 1900 1234
                    </div>
                </div>
            </aside>
        </div>
    </form>
</main>
@endsection
