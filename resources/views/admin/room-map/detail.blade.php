@extends('admin.layouts.master')
@section('title', 'Chi tiết hóa đơn | Urban Luxe')

@section('content')
<div style="display:flex; height:100vh; background:#f5f6fa; overflow:hidden;">
    @include('admin.layouts.sidebar')

    <main style="flex:1; display:flex; flex-direction:column; overflow:hidden;">
        @include('admin.layouts.header')

        <div class="rd-wrapper">
            <div class="rd-header">
                @if(session('success'))
                    <div style="margin-bottom:12px; padding:10px 12px; border-radius:8px; background:#f0fdf4; color:#166534; border:1px solid #bbf7d0;">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div style="margin-bottom:12px; padding:10px 12px; border-radius:8px; background:#fef2f2; color:#991b1b; border:1px solid #fecaca;">
                        {{ session('error') }}
                    </div>
                @endif
                <a href="{{ route('admin.room-map.index') }}" class="rd-back">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    Quay lại danh sách
                </a>
                <h1 class="rd-title">Chi tiết phòng {{ $room->name ?? '--' }} - {{ $room->roomType->name ?? 'N/A' }}</h1>
                <p class="rd-desc">Thông tin lưu trú và thanh toán theo phòng bạn đã chọn.</p>
                <div class="rd-customer">
                    <span style="color:#64748b; margin-right:6px; font-weight:500;">Khách hàng:</span> {{ $customerName }}
                </div>
            </div>

            <div class="rd-grid">
                <div class="rd-panel">
                    <div class="rd-panel-header">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 21v-6h6v6"/></svg>
                            THÔNG TIN PHÒNG
                        </div>
                        <div style="font-size:11px; font-weight:500; color:#94a3b8; text-transform:none;">
                            Bắt đầu tính lưu trú từ: {{ $billingAnchorAt ?? '--' }}
                        </div>
                    </div>

                    @forelse(($bookingRooms ?? []) as $bookingRoomItem)
                        @php
                            $isRoomPaid = ($bookingRoomItem['payment_status'] ?? 'unpaid') === 'paid';
                        @endphp
                        <div class="rd-room-item {{ $isRoomPaid ? 'rd-room-item-paid' : '' }}">
                            <div class="rd-room-main">
                                <div class="rd-room-icon icon-orange">{{ $bookingRoomItem['room_name'] ?? '--' }}</div>
                                <div class="rd-room-info">
                                    <div class="rd-room-title-row">
                                        <div class="rd-room-name">P.{{ $bookingRoomItem['room_name'] ?? '--' }}</div>
                                        <div class="rd-room-price">{{ number_format((float) ($bookingRoomItem['display_room_amount'] ?? $bookingRoomItem['room_amount'] ?? 0), 0, ',', '.') }}đ</div>
                                    </div>
                                    <div>
                                        <div class="rd-room-type">{{ $bookingRoomItem['room_type_name'] ?? 'N/A' }}</div>
                                        <div class="rd-room-checkout">Check-in: {{ $bookingRoomItem['checkin_at'] ?? '--' }} | Check-out: {{ $bookingRoomItem['checkout_at'] ?? '--' }}</div>
                                        <div style="font-size:11px; color:#475569; margin-top:4px;">
                                            Giá giờ: {{ number_format((float) ($bookingRoomItem['hourly_price'] ?? 0), 0, ',', '.') }}đ | Giá ngày: {{ number_format((float) ($bookingRoomItem['daily_price'] ?? 0), 0, ',', '.') }}đ
                                        </div>
                                        <div style="font-size:11px; color:#64748b; margin-top:4px;">
                                            Tạm tính theo {{ ($bookingRoomItem['display_pricing_mode'] ?? 'daily') === 'hourly' ? 'giờ' : 'ngày' }}: {{ $bookingRoomItem['display_pricing_units'] ?? 1 }} {{ ($bookingRoomItem['display_pricing_mode'] ?? 'daily') === 'hourly' ? 'giờ' : 'ngày' }}
                                        </div>
                                        @if ($isRoomPaid)
                                            <div class="rd-paid-note">Đã thanh toán lúc: {{ $bookingRoomItem['paid_at'] ?? '--' }}</div>
                                        @else
                                            <label class="rd-room-check-label">
                                                <input
                                                    type="checkbox"
                                                    class="rd-checkout-room-checkbox"
                                                    form="checkoutSelectedRoomsForm"
                                                    name="selected_room_ids[]"
                                                    value="{{ $bookingRoomItem['room_id'] }}"
                                                    {{ !empty($bookingRoomItem['is_selected_room']) ? 'checked' : '' }}
                                                >
                                                Chọn phòng này để thanh toán
                                            </label>
                                        @endif
                                        @if (!empty($bookingRoomItem['is_selected_room']))
                                            <div class="rd-current-room-note">Phòng bạn đang mở chi tiết</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="rd-room-add-service">
                                @if ($isRoomPaid)
                                    <div class="rd-service-locked">
                                        <span class="rd-service-lock-icon">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="11" width="16" height="9" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
                                        </span>
                                        Phòng đã thanh toán, không thể thêm dịch vụ mới.
                                    </div>
                                @else
                                    <form method="POST" action="{{ route('admin.room-map.detail-add-service', ['id' => $bookingRoomItem['room_id'] ?? 0]) }}" class="rd-service-form">
                                        @csrf
                                        <span class="rd-service-title">Thêm dịch vụ cho phòng {{ $bookingRoomItem['room_name'] ?? '--' }}</span>
                                        <select name="service_id" class="rd-service-select" required>
                                            <option value="">Chọn dịch vụ</option>
                                            @foreach($serviceCatalog as $serviceItem)
                                                <option value="{{ $serviceItem['id'] }}">{{ $serviceItem['name'] }} ({{ number_format((float) $serviceItem['unit_price'], 0, ',', '.') }}đ)</option>
                                            @endforeach
                                        </select>
                                        <input type="number" name="quantity" min="1" value="1" class="rd-service-qty" required>
                                        <button type="submit" class="rd-add-serv-btn">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                                            Thêm
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="rd-room-item">
                            <div class="rd-room-main">
                                <div class="rd-room-icon icon-orange">--</div>
                                <div class="rd-room-info">
                                    <div class="rd-room-title-row">
                                        <div class="rd-room-name">Chưa có phòng trong booking</div>
                                        <div class="rd-room-price">0đ</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforelse

                    <div class="rd-room-item">
                        <div class="rd-room-services">
                            <div class="rd-serv-header">
                                <span>- DỊCH VỤ SỬ DỤNG (PHÒNG ĐANG CHỌN)</span>
                            </div>
                            @forelse($selectedRoomServiceUsageHistory ?? [] as $usageItem)
                                <div class="rd-serv-row">
                                    <span>{{ $usageItem['service_name'] }} (x{{ $usageItem['quantity'] }})</span>
                                    <span>{{ number_format((float) $usageItem['line_total'], 0, ',', '.') }}đ</span>
                                </div>
                                <div style="font-size:11px; color:#94a3b8; margin-top:-6px; margin-bottom:8px;">
                                    {{ $usageItem['created_at'] ?? '' }}
                                </div>
                            @empty
                                <div class="rd-serv-row">
                                    <span>Chưa có lịch sử dịch vụ</span>
                                    <span>0đ</span>
                                </div>
                            @endforelse

                            <div class="rd-serv-header" style="margin-top:14px;">
                                <span>- LỊCH SỬ DỊCH VỤ TOÀN BOOKING</span>
                            </div>
                            @forelse($serviceUsageHistory as $usageItem)
                                <div class="rd-serv-row">
                                    <span>P.{{ $usageItem['room_name'] }} - {{ $usageItem['service_name'] }} (x{{ $usageItem['quantity'] }})</span>
                                    <span>{{ number_format((float) $usageItem['line_total'], 0, ',', '.') }}đ</span>
                                </div>
                                <div style="font-size:11px; color:#94a3b8; margin-top:-6px; margin-bottom:8px;">
                                    {{ $usageItem['created_at'] ?? '' }}
                                </div>
                            @empty
                                <div class="rd-serv-row">
                                    <span>Chưa có lịch sử dịch vụ toàn booking</span>
                                    <span>0đ</span>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="rd-panel" id="checkoutBillPanel" data-preview-url="{{ route('admin.room-map.detail-checkout-preview', ['id' => $room->id ?? 0]) }}">
                    <div class="rd-panel-header">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                            HÓA ĐƠN TỔNG
                        </div>
                    </div>
                    <div class="rd-bill-preview-message" data-bill-message></div>

                    <div class="rd-bill-section">
                        <div class="rd-bill-label">TIỀN PHÒNG</div>
                        <div data-bill-room-lines>
                            @forelse(($bookingRooms ?? []) as $bookingRoomItem)
                                <div class="rd-bill-row">
                                    <span>- P.{{ $bookingRoomItem['room_name'] ?? '--' }} ({{ $bookingRoomItem['room_type_name'] ?? 'N/A' }})</span>
                                    <span>{{ number_format((float) ($bookingRoomItem['display_room_amount'] ?? $bookingRoomItem['room_amount'] ?? 0), 0, ',', '.') }}đ</span>
                                </div>
                                @if ((float) ($bookingRoomItem['surcharge_amount'] ?? 0) > 0)
                                    <div class="rd-bill-row">
                                        <span>&nbsp;&nbsp;+ Phụ thu checkout sớm (P.{{ $bookingRoomItem['room_name'] ?? '--' }})</span>
                                        <span>{{ number_format((float) ($bookingRoomItem['surcharge_amount'] ?? 0), 0, ',', '.') }}đ</span>
                                    </div>
                                @endif
                            @empty
                                <div class="rd-bill-row"><span>- Chưa có phòng</span><span>0đ</span></div>
                            @endforelse
                        </div>
                    </div>

                    <div class="rd-bill-section">
                        <div class="rd-bill-label">DỊCH VỤ</div>
                        <div class="rd-bill-row"><span>Dịch vụ phát sinh</span><span data-bill-service-amount>{{ number_format((float) ($invoiceTotals['service_amount'] ?? 0), 0, ',', '.') }}đ</span></div>
                    </div>

                    <div class="rd-bill-section">
                        <div class="rd-bill-label">PHỤ PHÍ</div>
                        <div class="rd-bill-row-red">
                            <span>Phụ phí khác</span>
                            <span data-bill-surcharge-amount>{{ number_format((float) ($invoiceTotals['surcharge_amount'] ?? 0), 0, ',', '.') }}đ</span>
                        </div>
                    </div>

                    <div class="rd-bill-divider"></div>

                    <div class="rd-bill-row" style="font-weight:800; color:#0f172a;">
                        <span>Tạm tính:</span>
                        <span data-bill-subtotal>{{ number_format((float) ($invoiceTotals['subtotal'] ?? 0), 0, ',', '.') }}đ</span>
                    </div>

                    <div class="rd-bill-row">
                        <span>VAT (10%):</span>
                        <span data-bill-vat-amount>{{ number_format((float) ($invoiceTotals['vat_amount'] ?? 0), 0, ',', '.') }}đ</span>
                    </div>

                    <div class="rd-bill-divider"></div>

                    <div class="rd-bill-total">
                        TỔNG CẦN<br>THANH TOÁN
                        <div style="font-size:24px; line-height:1; margin-top:4px;" data-bill-grand-total>{{ number_format((float) ($invoiceTotals['grand_total'] ?? 0), 0, ',', '.') }}đ</div>
                        <div class="rd-bill-total-sub">(Đã bao gồm 10% VAT)</div>
                    </div>
                </div>
            </div>

            <div class="rd-bottom-bar">
                <a href="{{ route('admin.room-map.index') }}" class="rd-btn-close" style="text-decoration:none; display:inline-flex; align-items:center;">Đóng</a>
                <div class="rd-action-right">
                    <form id="checkoutSelectedRoomsForm" method="POST" action="{{ route('admin.room-map.detail-checkout-selected', ['id' => $room->id ?? 0]) }}" style="display:flex; align-items:center; gap:8px;">
                        @csrf
                        <select name="pricing_mode" id="checkoutPricingMode" style="height:36px; border:1px solid #cbd5e1; border-radius:8px; padding:0 10px;">
                            <option value="hourly">Tính theo giờ</option>
                            <option value="daily">Tính theo ngày</option>
                        </select>
                        <button class="rd-btn-checkout" type="submit">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                            THANH TOÁN PHÒNG ĐÃ CHỌN
                        </button>
                    </form>
                    <div class="rd-final-price">
                        <span style="font-size:13px; font-weight:600; color:#64748b;">Tổng cần thanh toán:</span>
                        <span data-final-grand-total>{{ number_format((float) ($invoiceTotals['grand_total'] ?? 0), 0, ',', '.') }}đ</span>
                    </div>
                </div>
            </div>
        </div>

        @php
            $checkoutSuccess = session('checkout_success');
            $checkoutInvoiceRoomId = $checkoutSuccess['invoice_room_id'] ?? ($room->id ?? null);
            $checkoutInvoiceRoomIds = collect($checkoutSuccess['processed_room_ids'] ?? [$checkoutInvoiceRoomId])
                ->filter()
                ->unique()
                ->implode(',');
            $checkoutInvoiceNumber = $booking?->id ? '#INV-' . $booking->id : '#INV-N/A';
            $checkoutTotal = (float) ($checkoutSuccess['grand_total'] ?? ($invoiceTotals['grand_total'] ?? 0));
        @endphp

        <div class="rd-modal-overlay {{ $checkoutSuccess ? 'active' : '' }}" id="checkoutSuccessModal" data-auto-open="{{ $checkoutSuccess ? '1' : '0' }}">
            <div class="rd-modal-success">
                <div class="rs-success-icon">
                    <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                </div>
                <div class="rs-success-title">Thanh toán & Check-out thành công!</div>
                <div class="rs-success-desc">Giao dịch đã được ghi nhận vào hệ thống Urban Luxe.</div>

                <div class="rs-success-box">
                    <div class="rs-success-row">
                        <span class="rs-success-label">Mã hóa đơn</span>
                        <span class="rs-success-val">{{ $checkoutInvoiceNumber }}</span>
                    </div>
                    <div class="rs-success-row">
                        <span class="rs-success-label">Khách hàng</span>
                        <span class="rs-success-val">{{ $customerName }}</span>
                    </div>
                    <div class="rs-success-row">
                        <span class="rs-success-label">Tổng tiền</span>
                        <span class="rs-success-total">{{ number_format($checkoutTotal, 0, ',', '.') }}đ</span>
                    </div>
                </div>

                <div class="rs-success-print">
                    <a href="{{ route('admin.room-map.invoice', ['id' => $checkoutInvoiceRoomId, 'room_ids' => $checkoutInvoiceRoomIds, 'paper' => 'a4']) }}" target="_blank" class="rs-btn-print" style="text-decoration:none;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><path d="M6 14h12v8H6z"/></svg>
                        In hóa đơn (A4)
                    </a>
                    <a href="{{ route('admin.room-map.invoice', ['id' => $checkoutInvoiceRoomId, 'room_ids' => $checkoutInvoiceRoomIds, 'paper' => 'k80']) }}" target="_blank" class="rs-btn-print" style="text-decoration:none;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2h12v20l-3-2-3 2-3-2-3 2V2z"/><path d="M9 7h6"/><path d="M9 11h6"/><path d="M9 15h4"/></svg>
                        In hóa đơn (K80)
                    </a>
                </div>
                <a href="{{ route('admin.room-map.index') }}" class="rs-btn-home" style="text-decoration:none;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    Về sơ đồ phòng
                </a>
            </div>
        </div>
    </main>
</div>

@vite(['resources/css/admin/room-detail.css', 'resources/js/admin/room-detail.js'])
@endsection
