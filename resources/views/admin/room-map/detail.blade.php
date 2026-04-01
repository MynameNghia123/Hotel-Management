@extends('admin.layouts.master')
@section('title', 'Chi tiết hóa đơn | Urban Luxe')

@section('content')
<div style="display:flex; height:100vh; background:#f5f6fa; overflow:hidden;">

    {{-- SIDEBAR --}}
    @include('admin.layouts.sidebar')

    {{-- MAIN CONTENT --}}
    <main style="flex:1; display:flex; flex-direction:column; overflow:hidden;">

        {{-- HEADER (Dùng chung như các trang khác) --}}
        <header style="height:64px; background:#fff; border-bottom:1px solid #f1f3f7; padding:0 32px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <div style="display:flex; align-items:center; gap:8px; font-size:14px; font-weight:600; color:#1e293b;">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 21v-6h6v6"/></svg>
                16819 · Urban Luxe Hotel
            </div>
            <div style="display:flex; align-items:center; gap:18px;">
                <button style="position:relative; width:36px; height:36px; border:none; background:transparent; display:flex; align-items:center; justify-content:center; color:#94a3b8; cursor:pointer;">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg>
                    <span style="position:absolute; top:6px; right:6px; width:8px; height:8px; background:#ef4444; border-radius:50%; border:2px solid #fff;"></span>
                </button>
                <div style="display:flex; align-items:center; gap:10px;">
                    <div style="text-align:right;">
                        <div style="font-size:13px; font-weight:700; color:#1e293b;">Admin Đức</div>
                        <div style="font-size:11px; color:#94a3b8;">Quản lý cấp cao</div>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=Admin+Duc&background=2a3f8a&color=fff" style="width:36px; height:36px; border-radius:50%;">
                </div>
            </div>
        </header>

        {{-- CHI TIẾT HÓA ĐƠN WRAPPER --}}
        <div class="rd-wrapper">

            {{-- Tiêu đề trang & Header --}}
            <div class="rd-header">
                <a href="{{ route('admin.room-map.index') }}" class="rd-back">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    Quay lại danh sách
                </a>
                <h1 class="rd-title">Chi tiết hóa đơn</h1>
                <p class="rd-desc">Cung cấp thông tin chi tiết để thực hiện thanh toán đoàn Urban Luxe hiệu quả hơn.</p>
                <div class="rd-customer">
                    <span style="color:#64748b; margin-right:6px; font-weight:500;">Thanh toán đoàn - Khách hàng:</span> Hoàng Gia Bảo
                </div>
            </div>

            {{-- Khung 2 cột --}}
            <div class="rd-grid">
                
                {{-- Cột Trái (Danh sách phòng) --}}
                <div class="rd-panel">
                    <div class="rd-panel-header">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 21v-6h6v6"/></svg>
                            DANH SÁCH PHÒNG
                        </div>
                        <div style="font-size:11px; font-weight:500; color:#94a3b8; text-transform:none;">Check-in: 30/05/2024</div>
                    </div>

                    {{-- Phòng 504 --}}
                    <div class="rd-room-item">
                        <div class="rd-room-main">
                            <div class="rd-room-icon icon-orange">504</div>
                            <div class="rd-room-info">
                                <div class="rd-room-title-row">
                                    <div class="rd-room-name">
                                        P.504 <span class="rd-badge badge-red">QUÁ GIỜ</span>
                                    </div>
                                    <div class="rd-room-price">5,000,000đ</div>
                                </div>
                                <div style="display:flex; justify-content:space-between; align-items:flex-end;">
                                    <div>
                                        <div class="rd-room-type">Suite King</div>
                                        <div class="rd-room-checkout">Check-out: 12:30 31/05/2024</div>
                                    </div>
                                    <button style="background:transparent; border:none; cursor:pointer; color:#2a3f8a;">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="8 12 12 16 16 12"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="rd-room-services">
                            <div class="rd-serv-header">
                                <span>- DỊCH VỤ SỬ DỤNG</span>
                                <button class="rd-add-serv-btn">+ Thêm dịch vụ</button>
                            </div>
                            <div class="rd-serv-row">
                                <span>Mini bar (Nước suối, Snack)</span>
                                <span>150,000đ</span>
                            </div>
                            <div class="rd-serv-row">
                                <span>Giặt là (Áo sơ mi x2)</span>
                                <span>250,000đ</span>
                            </div>
                        </div>
                    </div>

                    {{-- Phòng 505 --}}
                    <div class="rd-room-item">
                        <div class="rd-room-main">
                            <div class="rd-room-icon icon-blue">505</div>
                            <div class="rd-room-info">
                                <div class="rd-room-title-row">
                                    <div class="rd-room-name">P.505</div>
                                    <div class="rd-room-price">3,200,000đ</div>
                                </div>
                                <div style="display:flex; justify-content:space-between; align-items:flex-end;">
                                    <div>
                                        <div class="rd-room-type">Deluxe</div>
                                        <div class="rd-room-checkout">Check-out: 09:22 31/05/2024</div>
                                    </div>
                                    <button style="background:transparent; border:none; cursor:pointer; color:#cbd5e1;">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="8 12 12 16 16 12"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="rd-room-services" style="display:none;">
                            {{-- Trạng thái đóng không hiện dịch vụ --}}
                        </div>
                        {{-- Hiển thị tạm nếu mở, trong hình thứ 2 là có 2 dịch vụ --}}
                        <div class="rd-room-services">
                             <div class="rd-serv-header">
                                <span>- DỊCH VỤ SỬ DỤNG</span>
                                <button class="rd-add-serv-btn">+ Thêm dịch vụ</button>
                            </div>
                            <div class="rd-serv-row">
                                <span>Ăn sáng tại phòng</span>
                                <span>250,000đ</span>
                            </div>
                            <div class="rd-serv-row">
                                <span>Đồ uống (2 chai Coca)</span>
                                <span>40,000đ</span>
                            </div>
                        </div>
                    </div>

                    {{-- Phòng 506 --}}
                    <div class="rd-room-item">
                        <div class="rd-room-main">
                            <div class="rd-room-icon icon-green">506</div>
                            <div class="rd-room-info">
                                <div class="rd-room-title-row">
                                    <div class="rd-room-name">
                                        P.506 <span class="rd-badge badge-green">ĐÃ THANH TOÁN</span>
                                    </div>
                                    <div class="rd-room-price" style="color:#94a3b8; text-decoration:line-through;">2,100,000đ</div>
                                </div>
                                <div style="display:flex; justify-content:space-between; align-items:flex-end;">
                                    <div>
                                        <div class="rd-room-type">Standard</div>
                                        <div class="rd-room-checkout">Check-out: 17:33 30/05/2024</div>
                                    </div>
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                </div>
                            </div>
                        </div>
                        <div class="rd-room-services">
                             <div class="rd-serv-header">
                                <span>- DỊCH VỤ SỬ DỤNG</span>
                                <button class="rd-add-serv-btn">+ Thêm dịch vụ</button>
                            </div>
                            <div class="rd-serv-row">
                                <span>Giặt là</span>
                                <span>150,000đ</span>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Cột Phải (Hóa đơn tổng) --}}
                <div class="rd-panel">
                    <div class="rd-panel-header">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            HÓA ĐƠN TỔNG
                        </div>
                    </div>

                    {{-- Tiền phòng --}}
                    <div class="rd-bill-section">
                        <div class="rd-bill-label">TIỀN PHÒNG</div>
                        <div class="rd-bill-row"><span>- P.504 (Suite King)</span><span>5,000,000đ</span></div>
                        <div class="rd-bill-row"><span>- P.505 (Deluxe)</span><span>3,200,000đ</span></div>
                        <div class="rd-bill-row"><span>- P.506 (Standard)</span><span>2,100,000đ</span></div>
                    </div>

                    {{-- Dịch vụ --}}
                    <div class="rd-bill-section">
                        <div class="rd-bill-label">DỊCH VỤ</div>
                        <div class="rd-bill-row"><span>Mini bar & ăn uống</span><span>190,000đ</span></div>
                        <div class="rd-bill-row"><span>Giặt ủi & lo vú</span><span>300,000đ</span></div>
                        <div class="rd-bill-row"><span>Ăn sáng tại phòng</span><span>250,000đ</span></div>
                    </div>

                    {{-- Phụ phí --}}
                    <div class="rd-bill-section">
                        <div class="rd-bill-label">PHỤ PHÍ</div>
                        <div class="rd-bill-row-red">
                            <span>10 Phí quá giờ (P.504)</span>
                            <span>250,000đ</span>
                        </div>
                    </div>

                    <div class="rd-bill-divider"></div>

                    <div class="rd-bill-row" style="font-weight:800; color:#0f172a;">
                        <span>Tổng tiền dịch vụ:</span>
                        <span>11,290,000đ</span>
                    </div>

                    <div class="rd-payment-success">
                        <span>ĐÃ THANH TOÁN</span>
                        <span>- 5,500,000đ</span>
                    </div>

                    <div class="rd-bill-divider"></div>

                    <div class="rd-bill-total">
                        TỔNG CẦN<br>THANH TOÁN
                        <div style="font-size:24px; line-height:1; margin-top:4px;">4,539,950đ</div>
                        <div class="rd-bill-total-sub">(Đã bao gồm 10% VAT & phí PV)</div>
                    </div>

                </div>

            </div>
            
            {{-- BOTTOM ACTION BAR --}}
            <div class="rd-bottom-bar">
                <button class="rd-btn-close">Đóng</button>
                <div class="rd-action-right">
                    <div class="rd-final-price">
                        <span style="font-size:13px; font-weight:600; color:#64748b;">Còn lại:</span>
                        4,539,950đ
                    </div>
                    <button class="rd-btn-checkout">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg>
                        CHECK-OUT & THANH TOÁN TẤT CẢ
                    </button>
                </div>
            </div>

        </div>

        {{-- MODAL THÊM DỊCH VỤ --}}
        <div class="rd-modal-overlay" id="addServiceModal">
            <div class="rd-modal">
                <div class="rd-modal-header">
                    <div class="rd-modal-title">THÊM DỊCH VỤ</div>
                    <button class="rd-modal-close" id="closeServiceModal">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
                <div class="rd-modal-body">
                    <div class="rd-modal-search">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <input type="text" placeholder="Tìm kiếm dịch vụ (Mini bar, Giặt là, Spa...)">
                    </div>
                    <div class="rd-serv-list">
                        {{-- Dịch vụ 1 --}}
                        <div class="rd-serv-item">
                            <div class="rd-serv-item-left">
                                <div class="rd-serv-icon-box">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                </div>
                                <div>
                                    <div class="rd-serv-info-name">Nước suối Lavie 500ml</div>
                                    <div class="rd-serv-info-price">20,000đ</div>
                                </div>
                            </div>
                            <div class="rd-serv-stepper">
                                <button class="rd-serv-step-btn btn-down">-</button>
                                <span class="rd-serv-step-val">1</span>
                                <button class="rd-serv-step-btn btn-up">+</button>
                            </div>
                        </div>

                        {{-- Dịch vụ 2 --}}
                        <div class="rd-serv-item">
                            <div class="rd-serv-item-left">
                                <div class="rd-serv-icon-box">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="16" rx="2" ry="2"/><circle cx="12" cy="12" r="3"/><line x1="9" y1="4" x2="9" y2="20"/><line x1="15" y1="4" x2="15" y2="20"/></svg>
                                </div>
                                <div>
                                    <div class="rd-serv-info-name">Giặt là (kg)</div>
                                    <div class="rd-serv-info-price">50,000đ</div>
                                </div>
                            </div>
                            <div class="rd-serv-stepper">
                                <button class="rd-serv-step-btn btn-down">-</button>
                                <span class="rd-serv-step-val">0</span>
                                <button class="rd-serv-step-btn btn-up">+</button>
                            </div>
                        </div>

                        {{-- Dịch vụ 3 --}}
                        <div class="rd-serv-item">
                            <div class="rd-serv-item-left">
                                <div class="rd-serv-icon-box">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>
                                </div>
                                <div>
                                    <div class="rd-serv-info-name">Mì ly</div>
                                    <div class="rd-serv-info-price">25,000đ</div>
                                </div>
                            </div>
                            <div class="rd-serv-stepper">
                                <button class="rd-serv-step-btn btn-down">-</button>
                                <span class="rd-serv-step-val">2</span>
                                <button class="rd-serv-step-btn btn-up">+</button>
                            </div>
                        </div>

                        {{-- Dịch vụ 4 --}}
                        <div class="rd-serv-item">
                            <div class="rd-serv-item-left">
                                <div class="rd-serv-icon-box">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22A10 10 0 0 0 12 2a10 10 0 0 0 0 20z"/><path d="M12 11a4 4 0 0 1 0-8 4 4 0 0 1 0 8z"/><path d="M12 22a4 4 0 0 1 0-8 4 4 0 0 1 0 8z"/><path d="M12 11c2.5 0 4-2 4-5s-1.5-4-4-4-4 1-4 4 1.5 5 4 5z"/></svg>
                                </div>
                                <div>
                                    <div class="rd-serv-info-name">Gói Spa Thư Giãn 60p</div>
                                    <div class="rd-serv-info-price">350,000đ</div>
                                </div>
                            </div>
                            <div class="rd-serv-stepper">
                                <button class="rd-serv-step-btn btn-down">-</button>
                                <span class="rd-serv-step-val">1</span>
                                <button class="rd-serv-step-btn btn-up">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="rd-modal-footer">
                    <button class="rd-mod-btn-cancel" id="cancelServiceModal">HỦY</button>
                    <button class="rd-mod-btn-submit">
                        XÁC NHẬN
                        <span style="font-size:10px; font-weight:600; opacity:0.8;">THÊM</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- MODAL CHECKOUT THÀNH CÔNG --}}
        <div class="rd-modal-overlay" id="checkoutSuccessModal">
            <div class="rd-modal-success">
                <div class="rs-success-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <div class="rs-success-title">Thanh toán & Check-out thành công!</div>
                <div class="rs-success-desc">Giao dịch đã được ghi nhận vào hệ thống Urban Luxe.</div>
                
                <div class="rs-success-box">
                    <div class="rs-success-row">
                        <span class="rs-success-label">Mã hóa đơn</span>
                        <span class="rs-success-val">#INV-20231024</span>
                    </div>
                    <div class="rs-success-row">
                        <span class="rs-success-label">Khách hàng</span>
                        <span class="rs-success-val">Nguyễn Văn A</span>
                    </div>
                    <div class="rs-success-row">
                        <span class="rs-success-label">Tổng tiền</span>
                        <span class="rs-success-total">13,039,950đ</span>
                    </div>
                </div>

                <div class="rs-success-print">
                    <a href="{{ route('admin.room-map.invoice') }}" target="_blank" class="rs-btn-print" style="text-decoration:none;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                        In hóa đơn (A4)
                    </a>
                    <button class="rs-btn-print">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 22h16V2H4v20z"/><path d="M14 2v4h4"/><path d="M8 12h8"/><path d="M8 16h8"/></svg>
                        In hóa đơn (K80)
                    </button>
                </div>

                <a href="{{ route('admin.room-map.index') }}" class="rs-btn-home" style="text-decoration:none;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    Về sơ đồ phòng
                </a>
            </div>
        </div>

    </main>
</div>

@vite(['resources/css/admin/room-detail.css', 'resources/js/admin/room-detail.js'])

@endsection
