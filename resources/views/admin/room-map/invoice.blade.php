<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn #INV-0520-003</title>
    
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
<body>

    <div class="inv-wrapper">
        
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
                <div class="inv-id">#INV-0520-003</div>
                <div class="inv-date">Ngày: 20/05/2024</div>
            </div>
        </div>

        {{-- THÔNG TIN KHÁCH HÀNG & LƯU TRÚ --}}
        <div class="inv-info-section">
            <div class="inv-info-block">
                <div class="inv-info-label">KHÁCH HÀNG</div>
                <div class="inv-customer-name">Hoàng Gia Bảo</div>
                <div class="inv-customer-sub">Đại diện đoàn: 3 phòng</div>
                <div class="inv-customer-sub">SĐT: 098****123</div>
            </div>
            
            <div class="inv-info-block" style="text-align: right;">
                <div class="inv-info-label">THÔNG TIN LƯU TRÚ</div>
                <div class="inv-stay-row">
                    <span class="inv-stay-label">Check-in:</span> 18/05/2024
                </div>
                <div class="inv-stay-row">
                    <span class="inv-stay-label">Check-out:</span> 20/05/2024
                </div>
                <div class="inv-stay-row">
                    <span class="inv-stay-label">Thời gian:</span> 2 Đêm
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
                
                {{-- Phòng 504 --}}
                <tr>
                    <td class="inv-td">
                        <div class="inv-room-name">Phòng 504 - Suite King</div>
                        <div class="inv-sub-item">Mini bar (Nước suối, Snack) <span>150,000đ</span></div>
                        <div class="inv-sub-item">Giặt là (Áo sơ mi x2) <span>200,000đ</span></div>
                        <div class="inv-sub-item red">Phí quá giờ (1 tiếng) <span>250,000đ</span></div>
                    </td>
                    <td class="inv-td right" style="vertical-align: top;">2,500,000đ</td>
                    <td class="inv-td center" style="vertical-align: top;">2</td>
                    <td class="inv-td right" style="vertical-align: top; font-weight:800;">5,000,000đ</td>
                </tr>

                {{-- Phòng 505 --}}
                <tr>
                    <td class="inv-td">
                        <div class="inv-room-name">Phòng 505 - Deluxe</div>
                        <div class="inv-sub-item">Ăn sáng tại phòng <span>250,000đ</span></div>
                        <div class="inv-sub-item">Đồ uống (Coca) <span>40,000đ</span></div>
                    </td>
                    <td class="inv-td right" style="vertical-align: top;">1,600,000đ</td>
                    <td class="inv-td center" style="vertical-align: top;">2</td>
                    <td class="inv-td right" style="vertical-align: top; font-weight:800;">3,200,000đ</td>
                </tr>

                {{-- Phòng 506 --}}
                <tr>
                    <td class="inv-td" style="border-bottom: 2px solid #0f172a;">
                        <div class="inv-room-name">Phòng 506 - Standard</div>
                        <div class="inv-sub-item">Giặt ủi <span style="color:#0f172a;">100,000đ</span></div>
                    </td>
                    <td class="inv-td right" style="vertical-align: top; border-bottom: 2px solid #0f172a;">1,050,000đ</td>
                    <td class="inv-td center" style="vertical-align: top; border-bottom: 2px solid #0f172a;">2</td>
                    <td class="inv-td right" style="vertical-align: top; font-weight:800; border-bottom: 2px solid #0f172a;">2,100,000đ</td>
                </tr>
            </tbody>
        </table>

        {{-- SUMMARY (TỔNG KẾT) --}}
        <div class="inv-summary">
            <div class="inv-summary-box">
                <div class="inv-sum-row">
                    <span>Cộng tiền phòng:</span>
                    <span>11,290,000đ</span>
                </div>
                <div class="inv-sum-row">
                    <span>Phí dịch vụ (5%):</span>
                    <span>564,500đ</span>
                </div>
                <div class="inv-sum-row">
                    <span>VAT (10%):</span>
                    <span>1,185,450đ</span>
                </div>
                
                <div class="inv-sum-total">
                    <span>TỔNG CỘNG:</span>
                    <span class="inv-sum-total-val">13,039,950đ</span>
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
