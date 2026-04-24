@extends('admin.layouts.master')
@section('title', 'Chi tiết đặt phòng | Urban Luxe')

@section('content')
@php
    $statusEnum = \App\Enums\BookingStatus::from($booking->status);
    $badgeColor = match($statusEnum->value) {
        'pending'   => ['bg' => '#fef3c7', 'border' => '#fde68a', 'text' => '#92400e', 'label' => 'Chờ xác nhận'],
        'confirmed' => ['bg' => '#f0fdf4', 'border' => '#bbf7d0', 'text' => '#15803d', 'label' => 'Đã xác nhận'],
        'occupied'  => ['bg' => '#dbeafe', 'border' => '#bfdbfe', 'text' => '#1e40af', 'label' => 'Đang ở'],
        'cancelled' => ['bg' => '#fee2e2', 'border' => '#fecaca', 'text' => '#991b1b', 'label' => 'Đã hủy'],
        default     => ['bg' => '#f1f5f9', 'border' => '#e2e8f0', 'text' => '#475569', 'label' => 'Không rõ'],
    };
    $allowedTransitions = $statusEnum->allowedTransitions();
@endphp

<div style="display:flex; height:100vh; background:#f8fafc; overflow:scroll;">

    @include('admin.layouts.sidebar')

    <main style="flex:1; display:flex; flex-direction:column;">

        {{-- HEADER CHUNG --}}
        @include('admin.layouts.header')

        <div class="bc-container">
            <div class="bc-left-col">
                <div>
                    <a href="{{ route('admin.bookings.index') }}" class="bc-back-link">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                        Trở lại
                    </a>
                    <div style="display:flex; align-items:center; gap:12px; margin-top:8px;">
                        <h1 style="font-size:24px; font-weight:900; color:#0f172a; margin:0;">Chi tiết đặt phòng #{{ $booking->id }}</h1>
                        <span style="display:inline-flex; align-items:center; gap:6px; padding:6px 12px; background:{{ $badgeColor['bg'] }}; border:1px solid {{ $badgeColor['border'] }}; border-radius:8px; font-size:12px; font-weight:700; color:{{ $badgeColor['text'] }};">
                            <span style="width:8px; height:8px; background:currentColor; border-radius:50%;"></span>
                            {{ $statusEnum->label() }}
                        </span>
                    </div>
                </div>

                {{-- THÔNG TIN KHÁCH HÀNG --}}
                <div class="bc-card">
                    <div class="bc-card-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Thông tin khách hàng
                    </div>
                    
                    <div class="bc-form-group">
                        <label class="bc-label">Mã đặt phòng</label>
                        <div style="padding:10px 14px; background:#f1f5f9; border:1px solid #e2e8f0; border-radius:8px; color:#1e293b; font-weight:600;">
                            #{{ $booking->id }}
                        </div>
                    </div>

                    <div class="bc-form-group">
                        <label class="bc-label">Tên khách hàng</label>
                        <div style="padding:10px 14px; background:#f1f5f9; border:1px solid #e2e8f0; border-radius:8px; color:#1e293b; font-weight:600;">
                        {{ trim($booking->customer->last_name . ' ' . $booking->customer->first_name) ?: 'N/A' }}
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                        <div class="bc-form-group">
                            <label class="bc-label">Email</label>
                            <div style="padding:10px 14px; background:#f1f5f9; border:1px solid #e2e8f0; border-radius:8px; color:#1e293b; font-weight:600;">
                                {{ $booking->customer->email }}
                            </div>
                        </div>
                        <div class="bc-form-group">
                            <label class="bc-label">Số điện thoại</label>
                            <div style="padding:10px 14px; background:#f1f5f9; border:1px solid #e2e8f0; border-radius:8px; color:#1e293b; font-weight:600;">
                                {{ $booking->customer->phone_number ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- PHÒNG ĐƯỢC ĐẶT --}}
                <div class="bc-card">
                    <div class="bc-card-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        Phòng lưu trú
                    </div>

                    <div class="bc-room-list">
                        @forelse ($bookingDetails as $detail)
                            <div class="bc-room-item" style="background:#f0f7ff; border-color:#e0f2fe; cursor:default;">
                                <div class="bc-room-num-badge" style="background:#bfdbfe; color:#1e40af;">{{ $detail->room->name }}</div>
                                <div class="bc-room-info">
                                    <div class="bc-room-name">{{ $detail->room->roomType->name ?? 'N/A' }}</div>
                                    <div class="bc-room-detail">{{ $detail->room->floor->name ?? 'N/A' }}</div>
                                </div>
                            </div>
                        @empty
                            <p style="color: #94a3b8; text-align: center; padding: 20px;">Chưa có phòng nào được chọn</p>
                        @endforelse
                    </div>
                </div>

                {{-- THỜI GIAN LƯU TRÚ --}}
                <div class="bc-card">
                    <div class="bc-card-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Thời gian lưu trú
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                        <div class="bc-form-group">
                            <label class="bc-label">Ngày nhận phòng (Check-in)</label>
                            <div style="padding:10px 14px; background:#f1f5f9; border:1px solid #e2e8f0; border-radius:8px; color:#1e293b; font-weight:600;">
                                @if ($bookingDetails->first())
                                    {{ $bookingDetails->first()->checkin_date->format('d/m/Y - H:i') }}
                                @else
                                    N/A
                                @endif
                            </div>
                        </div>
                        <div class="bc-form-group">
                            <label class="bc-label">Ngày trả phòng (Check-out)</label>
                            <div style="padding:10px 14px; background:#f1f5f9; border:1px solid #e2e8f0; border-radius:8px; color:#1e293b; font-weight:600;">
                                @if ($bookingDetails->first())
                                    {{ $bookingDetails->first()->checkout_date->format('d/m/Y - H:i') }}
                                @else
                                    N/A
                                @endif
                            </div>
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-top:16px;">
                        <div class="bc-form-group">
                            <label class="bc-label">Tổng số đêm</label>
                            <div style="padding:10px 14px; background:#f1f5f9; border:1px solid #e2e8f0; border-radius:8px; color:#1e293b; font-weight:600;">
                                @if ($bookingDetails->first())
                                    {{ $bookingDetails->first()->checkin_date->diffInDays($bookingDetails->first()->checkout_date) }} đêm
                                @else
                                    N/A
                                @endif
                            </div>
                        </div>
                        <div class="bc-form-group">
                            <label class="bc-label">Ngày đặt phòng</label>
                            <div style="padding:10px 14px; background:#f1f5f9; border:1px solid #e2e8f0; border-radius:8px; color:#1e293b; font-weight:600;">
                                {{ $booking->booking_date->format('d/m/Y - H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bc-right-col">
                <div class="bc-card" style="position:sticky; top:20px;">
                    <div class="bc-card-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        Chi tiết thanh toán
                    </div>

                    <div class="bc-summary-list" style="margin-bottom:20px;">
                        <div class="bc-summary-item">
                            <span>Tổng tiền phòng</span>
                            <span style="color:#0f172a; font-weight:800;">{{ number_format($booking->total_room_amount, 0, ',', '.') }} đ</span>
                        </div>
                        <div class="bc-summary-item">
                            <span>Phí dịch vụ</span>
                            <span style="color:#0f172a; font-weight:700;">{{ number_format($booking->total_service_amount, 0, ',', '.') }} đ</span>
                        </div>
                        <div class="bc-summary-item">
                            <span>Phụ phí bổ sung</span>
                            <span style="color:#0f172a; font-weight:700;">{{ number_format($booking->surcharge_amount, 0, ',', '.') }} đ</span>
                        </div>
                    </div>

                    <div class="bc-grand-total">
                        <div class="bc-total-label">TỔNG CỘNG</div>
                        <div class="bc-total-value">{{ number_format($booking->final_amount, 0, ',', '.') }} đ</div>
                    </div>

                    {{-- STATUS TRANSITION FORM --}}
                    @if (!empty($allowedTransitions))
                        <form method="POST" action="{{ route('admin.bookings.updateStatus', $booking->id) }}" style="margin-top:20px;">
                            @csrf
                            @method('PATCH')
                            
                            <label class="bc-label" style="margin-bottom: 8px; display: block;">Cập nhật trạng thái</label>
                            <div style="display: grid; gap: 8px;">
                                @foreach ($allowedTransitions as $nextStatus)
                                    <button type="submit" name="status" value="{{ $nextStatus->value }}" 
                                        style="padding:10px 14px; background:{{ $badgeColor['bg'] }}; border:1px solid {{ $badgeColor['border'] }}; border-radius:8px; color:{{ $badgeColor['text'] }}; font-weight:700; cursor:pointer; text-align:left;">
                                        → {{ $nextStatus->label() }}
                                    </button>
                                @endforeach
                            </div>
                        </form>
                    @endif

                    {{-- ACTIONS --}}
                    <div class="bc-actions" style="margin-top:20px;">
                        <a href="{{ route('admin.bookings.index') }}" class="bc-btn-cancel" style="text-decoration:none; text-align:center; display:block; padding:12px 16px;">
                            ← Quay lại danh sách
                        </a>
                    </div>

                    {{-- INFO BOX --}}
                    <div style="margin-top:16px; padding:12px; background:#fffbeb; border:1px solid #fef3c7; border-radius:8px;">
                        <div style="display:flex; gap:8px; font-size:12px; color:#92400e;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0; margin-top:2px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                            <span>Bạn có thể thay đổi trạng thái đặt phòng bằng các nút bên trên.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

@vite(['resources/css/admin/booking-create.css'])
@endsection

