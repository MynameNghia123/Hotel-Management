@extends('client.layouts.master')

@section('title', 'Hồ Sơ Cá Nhân | Urban Luxe Hotel')
@section('meta_description', 'Quản lý thông tin cá nhân và lịch sử đặt phòng của bạn tại Urban Luxe.')

@push('styles')
@vite(['resources/css/client/profile.css', 'resources/js/client/profile.js'])
@endpush

@section('content')
<!-- Hero Section -->
<section class="profile-hero" style="background-image: linear-gradient(rgba(15, 22, 36, 0.85), rgba(15, 22, 36, 0.85)), url('{{ asset('img/backgroundhomepage.png') }}');">
    <div class="container">
        <div class="member-badge">KHU VỰC THÀNH VIÊN</div>
        <h1>Hồ Sơ Của Tôi</h1>
        <p>Quản lý thông tin cá nhân và xem lịch sử đặt phòng của bạn.</p>
    </div>
</section>

<!-- Main Content -->
<section class="profile-content">
    <div class="profile-container">

        <!-- Sidebar Navigation -->
        <aside class="profile-sidebar">
            <!-- Avatar Block -->
            <div class="sidebar-avatar-block">
                <div class="sidebar-avatar">
                    {{ strtoupper(substr($customer->first_name ?: $customer->email, 0, 1)) }}
                </div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">{{ $customer->full_name ?: 'Khách' }}</div>
                    <div class="sidebar-user-email">{{ $customer->email }}</div>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a href="#" class="sidebar-nav-item active" id="tab-profile">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M8.5 7a4 4 0 110-8 4 4 0 010 8z"/>
                    </svg>
                    Hồ Sơ
                </a>
                <a href="#" class="sidebar-nav-item" id="tab-bookings">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Lịch Đặt Phòng
                    @if($bookings->count() > 0)
                        <span class="booking-count-badge">{{ $bookings->count() }}</span>
                    @endif
                </a>
            </nav>
        </aside>

        <!-- Main Area -->
        <div class="profile-main-area">

            <!-- Flash Message -->
            @if(session('success'))
                <div class="flash-success" id="flashMessage">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- ── Tab: Hồ Sơ ── -->
            <div class="tab-panel" id="section-profile">
                <div class="profile-card">
                    <div class="card-header">
                        <div>
                            <h2>Hồ Sơ Của Tôi</h2>
                            <p class="card-subtitle">Cập nhật thông tin cá nhân của bạn</p>
                        </div>
                        <span class="required-text">Các trường có dấu <span>*</span> là bắt buộc</span>
                    </div>

                    <form action="{{ route('profile.update') }}" method="POST" id="profileForm">
                        @csrf
                        <div class="profile-form-grid">
                            <!-- Họ -->
                            <div class="form-group">
                                <label>HỌ <span>*</span></label>
                                <input type="text" name="last_name" class="profile-input @error('last_name') input-error @enderror"
                                    value="{{ old('last_name', $customer->last_name) }}" placeholder="Nhập họ">
                                @error('last_name')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Tên -->
                            <div class="form-group">
                                <label>TÊN <span>*</span></label>
                                <input type="text" name="first_name" class="profile-input @error('first_name') input-error @enderror"
                                    value="{{ old('first_name', $customer->first_name) }}" placeholder="Nhập tên">
                                @error('first_name')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email (readonly) -->
                            <div class="form-group full-width">
                                <label>EMAIL</label>
                                <div class="input-with-icon">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <input type="email" class="profile-input" value="{{ $customer->email }}" readonly>
                                    <span class="verified-badge">
                                       
                                        Đã xác thực
                                    </span>
                                </div>
                            </div>

                            <!-- Số điện thoại -->
                            <div class="form-group full-width">
                                <label>SỐ ĐIỆN THOẠI</label>
                                <input type="text" name="phone_number" class="profile-input"
                                    value="{{ old('phone_number', $customer->phone_number) }}" placeholder="Nhập số điện thoại">
                            </div>

                            <!-- Quốc gia -->
                            <div class="form-group full-width">
                                <label>QUỐC GIA / KHU VỰC</label>
                                <div style="position: relative;">
                                    <select name="country" class="profile-input" style="appearance: none; cursor: pointer;">
                                        <option value="">-- Chọn quốc gia --</option>
                                        <option value="Việt Nam" {{ old('country', $customer->country) == 'Việt Nam' ? 'selected' : '' }}>🇻🇳 Việt Nam</option>
                                        <option value="Hoa Kỳ" {{ old('country', $customer->country) == 'Hoa Kỳ' ? 'selected' : '' }}>🇺🇸 Hoa Kỳ</option>
                                        <option value="Anh Quốc" {{ old('country', $customer->country) == 'Anh Quốc' ? 'selected' : '' }}>🇬🇧 Anh Quốc</option>
                                        <option value="Pháp" {{ old('country', $customer->country) == 'Pháp' ? 'selected' : '' }}>🇫🇷 Pháp</option>
                                        <option value="Đức" {{ old('country', $customer->country) == 'Đức' ? 'selected' : '' }}>🇩🇪 Đức</option>
                                        <option value="Nhật Bản" {{ old('country', $customer->country) == 'Nhật Bản' ? 'selected' : '' }}>🇯🇵 Nhật Bản</option>
                                        <option value="Hàn Quốc" {{ old('country', $customer->country) == 'Hàn Quốc' ? 'selected' : '' }}>🇰🇷 Hàn Quốc</option>
                                        <option value="Trung Quốc" {{ old('country', $customer->country) == 'Trung Quốc' ? 'selected' : '' }}>🇨🇳 Trung Quốc</option>
                                        <option value="Thái Lan" {{ old('country', $customer->country) == 'Thái Lan' ? 'selected' : '' }}>🇹🇭 Thái Lan</option>
                                        <option value="Singapore" {{ old('country', $customer->country) == 'Singapore' ? 'selected' : '' }}>🇸🇬 Singapore</option>
                                        <option value="Khác" {{ old('country', $customer->country) == 'Khác' ? 'selected' : '' }}>🌍 Khác</option>
                                    </select>
                                    <div style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #64748b;">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-save">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            Lưu Thay Đổi
                        </button>
                    </form>
                </div>
            </div>

            <!-- ── Tab: Lịch Đặt Phòng ── -->
            <div class="tab-panel" id="section-bookings" style="display: none;">
                <div class="profile-card">
                    <div class="card-header">
                        <div>
                            <h2>Lịch Đặt Phòng</h2>
                            <p class="card-subtitle">Lịch sử các lần đặt phòng của bạn</p>
                        </div>
                        <span class="booking-total-badge">{{ $bookings->count() }} đặt phòng</span>
                    </div>

                    @if($bookings->isEmpty())
                        <div class="empty-bookings">
                            <svg width="56" height="56" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p>Bạn chưa có lần đặt phòng nào.</p>
                            <a href="{{ route('room') }}" class="btn-save" style="margin-top: 0; width: auto; padding: 0 32px; text-decoration: none;">Khám Phá Phòng Nghỉ</a>
                        </div>
                    @else
                        <div class="bookings-list">
                            @foreach($bookings as $booking)
                                <div class="booking-item">
                                    <div class="booking-item-header">
                                        <div class="booking-id">
                                            <span class="booking-id-label">MÃ ĐẶT PHÒNG</span>
                                            <span class="booking-id-value">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</span>
                                        </div>
                                        <span class="booking-status status-{{ $booking->status }}">
                                            @if($booking->status == 'pending') Chờ xác nhận
                                            @elseif($booking->status == 'checked_in') Đang lưu trú
                                            @elseif($booking->status == 'checked_out') Đã hoàn thành
                                            @elseif($booking->status == 'cancelled') Đã huỷ
                                            @else {{ $booking->status }}
                                            @endif
                                        </span>
                                    </div>

                                    <div class="booking-item-body">
                                        <div class="booking-meta">
                                            <div class="booking-meta-item">
                                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <span>Ngày đặt: {{ $booking->booking_date?->format('d/m/Y') ?? 'N/A' }}</span>
                                            </div>
                                            @if($booking->bookingDetails->isNotEmpty())
                                                <div class="booking-meta-item">
                                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                                    </svg>
                                                    <span>{{ $booking->bookingDetails->count() }} phòng</span>
                                                </div>
                                            @endif
                                            @if($booking->final_amount)
                                                <div class="booking-meta-item">
                                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span>{{ number_format($booking->final_amount, 0, ',', '.') }}₫</span>
                                                </div>
                                            @endif
                                        </div>

                                        @if($booking->bookingDetails->isNotEmpty())
                                            <div class="booking-rooms">
                                                @foreach($booking->bookingDetails->take(2) as $detail)
                                                    <div class="booking-room-chip">
                                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                                        </svg>
                                                        {{ $detail->room->roomType->name ?? 'Phòng ' . $detail->room_id }}
                                                        @if($detail->checkin_date && $detail->checkout_date)
                                                            · {{ $detail->checkin_date->format('d/m') }} – {{ $detail->checkout_date->format('d/m/Y') }}
                                                        @endif
                                                    </div>
                                                @endforeach
                                                @if($booking->bookingDetails->count() > 2)
                                                    <span class="booking-room-more">+{{ $booking->bookingDetails->count() - 2 }} phòng khác</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div><!-- /.profile-main-area -->
    </div>
</section>


@endsection
