@php
    $paperMode = request('paper') === 'k80' ? 'k80' : 'a4';
@endphp

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn #INV-{{ $booking->id ?? 'N/A' }}</title>
    
    {{-- Nếu hệ thống không tìm thấy font Inter, dùng Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    @vite('resources/css/admin/invoice.css')
    
    <script>
        // Tự động mở hộp thoại in sau khi trang load xong hoàn tất
        window.addEventListener('load', () => {
             // window.print(); // Bỏ comment để tự in khi vào trang
        });
    </script>
</head>
<body class="invoice-paper-{{ $paperMode }}">

    <div class="inv-screen-actions">
        <a href="{{ route('admin.room-map.index') }}" class="inv-back-map">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            Về sơ đồ phòng
        </a>
        <button type="button" class="inv-print-action" onclick="window.print()">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9V2h12v7"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><path d="M6 14h12v8H6z"/></svg>
            In hóa đơn {{ strtoupper($paperMode) }}
        </button>
    </div>

    <div class="inv-wrapper {{ $paperMode === 'k80' ? 'inv-wrapper-k80' : '' }}">
        
        {{-- HEADER HÓA ĐƠN --}}
        <div class="inv-header">
            <div class="inv-company">
                <div class="inv-logo">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 21v-6h6v6"/></svg>
                    URBAN LUXE HOTEL
                </div>
                <div class="inv-address">
                    123 Đường Ven Biển, Quận Sơn Trà,<br>
                    TP. Đà Nẵng, Việt Nam<br>
                    Tel: +84 236 123 4567<br>
                    Tax ID: 0123456789
                </div>
            </div>

            <div class="inv-title-box">
                <div class="inv-title-text">HÓA ĐƠN</div>
                <div class="inv-id">#INV-{{ $booking->id ?? 'N/A' }}</div>
                <div class="inv-date">Ngày: {{ $generatedAt->format('d/m/Y') }}</div>
            </div>
        </div>

        {{-- THÔNG TIN KHÁCH HÀNG & LƯU TRÚ --}}
        <div class="inv-info-section">
            <div class="inv-info-block">
                <div class="inv-info-label">KHÁCH HÀNG</div>
                <div class="inv-customer-name">{{ $customerName }}</div>
                <div class="inv-customer-sub">Phòng: {{ $invoiceStaySummary['room_names'] ?? ($room->name ?? '--') }}</div>
                <div class="inv-customer-sub">SĐT: {{ $booking?->customer?->phone_number ?? 'N/A' }}</div>
            </div>
            
            <div class="inv-info-block" style="text-align: right;">
                <div class="inv-info-label">THÔNG TIN LƯU TRÚ</div>
                <div class="inv-stay-row">
                    <span class="inv-stay-label">Check-in:</span> {{ $invoiceStaySummary['checkin_at'] ?? '--' }}
                </div>
                <div class="inv-stay-row">
                    <span class="inv-stay-label">Check-out:</span> {{ $invoiceStaySummary['checkout_at'] ?? '--' }}
                </div>
                <div class="inv-stay-row">
                    <span class="inv-stay-label">Thời gian:</span> {{ $invoiceStaySummary['duration_text'] ?? '--' }}
                </div>
            </div>
        </div>

        {{-- BẢNG DỊCH VỤ --}}
        <table class="inv-table">
            <thead>
                <tr>
                    <th class="inv-th">MÔ TẢ / DỊCH VỤ</th>
                    <th class="inv-th right" style="width: 120px;">ĐƠN GIÁ</th>
                    <th class="inv-th center" style="width: 60px;">SL</th>
                    <th class="inv-th right" style="width: 140px;">THÀNH TIỀN</th>
                </tr>
            </thead>
            <tbody>
                @forelse(($invoiceRooms ?? []) as $invoiceRoom)
                    <tr>
                        <td class="inv-td">
                            <div class="inv-room-name">Phòng {{ $invoiceRoom['room_name'] ?? '--' }} - {{ $invoiceRoom['room_type_name'] ?? 'N/A' }}</div>
                            <div class="inv-sub-item">Lưu trú {{ $invoiceRoom['duration_text'] ?? '--' }} <span>{{ $invoiceRoom['checkin_at'] ?? '--' }} - {{ $invoiceRoom['checkout_at'] ?? '--' }}</span></div>
                            @forelse(($invoiceRoom['service_items'] ?? []) as $serviceItem)
                                <div class="inv-sub-item">{{ $serviceItem['name'] ?? 'Dịch vụ' }} x{{ $serviceItem['quantity'] ?? 0 }} <span>{{ number_format((float) ($serviceItem['line_total'] ?? 0), 0, ',', '.') }}đ</span></div>
                            @empty
                                @if ((float) ($invoiceRoom['service_amount'] ?? 0) > 0)
                                    <div class="inv-sub-item">Dịch vụ phát sinh <span>{{ number_format((float) ($invoiceRoom['service_amount'] ?? 0), 0, ',', '.') }}đ</span></div>
                                @endif
                            @endforelse
                            @if ((float) ($invoiceRoom['surcharge_amount'] ?? 0) > 0)
                                <div class="inv-sub-item red">Phụ phí <span>{{ number_format((float) ($invoiceRoom['surcharge_amount'] ?? 0), 0, ',', '.') }}đ</span></div>
                            @endif
                        </td>
                        <td class="inv-td right" style="vertical-align: top;">{{ number_format((float) ($invoiceRoom['room_amount'] ?? 0), 0, ',', '.') }}đ</td>
                        <td class="inv-td center" style="vertical-align: top;">1</td>
                        <td class="inv-td right" style="vertical-align: top; font-weight:800;">{{ number_format((float) ($invoiceRoom['line_total'] ?? 0), 0, ',', '.') }}đ</td>
                    </tr>
                @empty
                    <tr>
                        <td class="inv-td" colspan="4">Chưa có dữ liệu phòng thanh toán.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- SUMMARY (TỔNG KẾT) --}}
        <div class="inv-summary">
            <div class="inv-summary-box">
                <div class="inv-sum-row">
                    <span>Cộng tiền phòng:</span>
                    <span>{{ number_format((float) ($invoiceTotals['room_amount'] ?? 0), 0, ',', '.') }}đ</span>
                </div>
                <div class="inv-sum-row">
                    <span>Dịch vụ:</span>
                    <span>{{ number_format((float) ($invoiceTotals['service_amount'] ?? 0), 0, ',', '.') }}đ</span>
                </div>
                <div class="inv-sum-row">
                    <span>Phụ phí:</span>
                    <span>{{ number_format((float) ($invoiceTotals['surcharge_amount'] ?? 0), 0, ',', '.') }}đ</span>
                </div>
                <div class="inv-sum-row">
                    <span>VAT (10%):</span>
                    <span>{{ number_format((float) ($invoiceTotals['vat_amount'] ?? 0), 0, ',', '.') }}đ</span>
                </div>
                
                <div class="inv-sum-total">
                    <span>TỔNG CỘNG:</span>
                    <span class="inv-sum-total-val">{{ number_format((float) ($invoiceTotals['grand_total'] ?? 0), 0, ',', '.') }}đ</span>
                </div>
            </div>
        </div>

        {{-- FOOTER --}}
        <div class="inv-footer">
            Cảm ơn quý khách đã sử dụng dịch vụ của Urban Luxe!<br>
            <span style="font-weight: 500;">Hẹn gặp lại quý khách.</span>
        </div>

    </div>

</body>
</html>
