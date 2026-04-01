@extends('admin.layouts.master')
@section('title', 'Tạo đặt phòng mới | Urban Luxe')

@section('content')
<div style="display:flex; height:100vh; background:#f8fafc; overflow:scroll;">

    @include('admin.layouts.sidebar')

    <main style="flex:1; display:flex; flex-direction:column;">

        {{-- HEADER CHUNG --}}
        <header style="height:64px; background:#fff; border-bottom:1px solid #f1f3f7; padding:0 32px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <div style="display:flex; align-items:center; gap:8px; font-size:14px; font-weight:600; color:#1e293b;">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 21v-6h6v6"/></svg>
                16819 · Urban Luxe Hotel
            </div>
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="text-align:right;">
                    <div style="font-size:13px; font-weight:700; color:#1e293b;">Admin Đức</div>
                    <div style="font-size:11px; color:#94a3b8;">Quản lý cấp cao</div>
                </div>
                <img src="https://ui-avatars.com/api/?name=Admin+Duc&background=2a3f8a&color=fff" style="width:36px; height:36px; border-radius:50%;">
            </div>
        </header>

        <div class="bc-container">
            
            <div class="bc-left-col">
                
                <div>
                    <a href="{{ route('admin.bookings.index') }}" class="bc-back-link">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                        Trở lại
                    </a>
                    <h1 style="font-size:24px; font-weight:900; color:#0f172a; margin:0;">Tạo đặt phòng mới</h1>
                </div>

                {{-- THÔNG TIN KHÁCH HÀNG --}}
                <div class="bc-card">
                    <div class="bc-card-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Thông tin khách hàng
                    </div>
                    
                    <div class="bc-form-group">
                        <label class="bc-label">Email khách hàng</label>
                        <div class="bc-input-row">
                            <input type="email" id="customerEmail" class="bc-input" placeholder="nhapemail@gmail.com">
                            <button type="button" class="bc-btn-verify" onclick="verifyCustomer()">Xác thực</button>
                        </div>
                        
                        {{-- Vùng hiển thị kết quả xác thực --}}
                        <div id="verifyResult" style="margin-top: 12px; display: none;">
                            
                            {{-- TH1: Khách hàng quay lại (Chào mừng + Tên) --}}
                            <div id="existingCustomer" style="display: none;">
                                <div style="display: flex; align-items: center; gap: 12px; padding: 14px; background: #f0fdf4; border-radius: 12px; border: 1px solid #bbf7d0;">
                                    <div style="width: 34px; height: 34px; background: #22c55e; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 8px rgba(34,197,94,0.2);">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                    </div>
                                    <div>
                                        <div style="font-size: 14px; font-weight: 800; color: #166534;">Chào mừng quay trở lại, <span id="customerName"></span>!</div>
                                        <div style="font-size: 11px; color: #15803d; font-weight: 600;">Thông tin và hạng thành viên của bạn đã được áp dụng.</div>
                                    </div>
                                </div>
                            </div>

                            {{-- TH2: Khách hàng mới (Yêu cầu nhập tên, sdt) --}}
                            <div id="newCustomer" style="display: none;">
                                <div style="margin-bottom: 20px; padding: 14px; background: #fffbeb; border-radius: 12px; border: 1px solid #fef3c7; display: flex; align-items: center; gap: 10px;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#92400e" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    <div>
                                        <div style="font-size: 13px; font-weight: 800; color: #92400e;">Khách hàng mới</div>
                                        <div style="font-size: 11px; color: #b45309; font-weight: 600;">Email lần đầu sử dụng. Vui lòng hoàn thiện thông tin bên dưới.</div>
                                    </div>
                                </div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                                    <div class="bc-form-group">
                                        <label class="bc-label">Họ và tên khách hàng</label>
                                        <input type="text" class="bc-input" placeholder="Ví dụ: Nguyễn Văn Hải">
                                    </div>
                                    <div class="bc-form-group">
                                        <label class="bc-label">Số điện thoại liên hệ</label>
                                        <input type="text" class="bc-input" placeholder="Ví dụ: 0905 123 456">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CHỌN PHÒNG --}}
                <div class="bc-card">
                    <div class="bc-card-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        Chọn phòng lưu trú
                        <button type="button" onclick="openRoomModal()" style="margin-left:auto; background:transparent; border:none; color:#2a3f8a; font-size:12px; font-weight:800; cursor:pointer;">+ Thêm phòng</button>
                    </div>

                    <div class="bc-room-list">
                        <div class="bc-room-item" style="background:#f0f7ff; border-color:#e0f2fe;">
                            <div class="bc-room-num-badge" style="background:#bfdbfe; color:#1e40af;">301</div>
                            <div class="bc-room-info">
                                <div class="bc-room-name">Urban Deluxe Twin</div>
                                <div class="bc-room-detail">Tầng 3 · View phố hướng Bắc</div>
                            </div>
                        </div>

                        <div class="bc-room-item" style="background:#fff7ed; border-color:#ffedd5;">
                            <div class="bc-room-num-badge" style="background:#fed7aa; color:#9a3412;">501</div>
                            <div class="bc-room-info">
                                <div class="bc-room-name">Exclusive Suite</div>
                                <div class="bc-room-detail">Tầng 5 · Toàn cảnh View biển</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- THỜI GIAN LƯU TRÚ --}}
                <div class="bc-card">
                    <div class="bc-card-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Thời gian lưu trú
                    </div>

                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                        <div class="bc-form-group">
                            <label class="bc-label">Ngày nhận phòng (Check-in)</label>
                            <input type="date" class="bc-input" value="2024-05-25">
                        </div>
                        <div class="bc-form-group">
                            <label class="bc-label">Ngày trả phòng (Check-out)</label>
                            <input type="date" class="bc-input" value="2024-05-27">
                        </div>
                    </div>
                </div>

            </div>

            <div class="bc-right-col">
                <div class="bc-card" style="position: sticky; top: 20px;">
                    <div class="bc-card-title">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        Chi tiết thanh toán
                    </div>

                    <div class="bc-summary-list" style="margin-bottom:20px;">
                        <div class="bc-summary-item">
                            <span>Urban Deluxe (x2 đêm)</span>
                            <span style="color:#0f172a; font-weight:800;">2,400,000 đ</span>
                        </div>
                        <div class="bc-summary-item">
                            <span>Executive Suite (x2 đêm)</span>
                            <span style="color:#0f172a; font-weight:800;">4,000,000 đ</span>
                        </div>
                        <div class="bc-summary-item" style="color:#1e293b; font-weight:800; border-top:1px solid #f1f5f9; padding-top:12px;">
                            <span>Tổng tiền phòng</span>
                            <span>6,400,000 đ</span>
                        </div>
                        <div class="bc-summary-item">
                            <span>Phí dịch vụ khách sạn</span>
                            <span style="color:#0f172a; font-weight:700;">30,000 đ</span>
                        </div>
                        <div class="bc-summary-item">
                            <span>Thuế VAT (8%)</span>
                            <span style="color:#ef4444; font-weight:700;">514,400 đ</span>
                        </div>
                    </div>

                    <div class="bc-grand-total">
                        <div class="bc-total-label">TỔNG CỘNG TẠM TÍNH</div>
                        <div class="bc-total-value">6,944,400 đ</div>
                        <div style="font-size:11px; color:#94a3b8; font-weight:600; text-align:right;">Đã bao gồm VAT & Phí dịch vụ</div>
                    </div>

                    <div class="bc-actions">
                        <button class="bc-btn-confirm">Xác nhận đặt phòng</button>
                        <button class="bc-btn-cancel">Hủy bỏ giao dịch</button>
                    </div>
                </div>
            </div>

        </div>

        {{-- MODAL CHỌN PHÒNG --}}
        <div id="roomModal" class="bc-modal-overlay">
            <div class="bc-modal">
                <div class="bc-modal-header">
                    <div>
                        <h2 class="bc-modal-title">Chọn phòng trống</h2>
                        <p class="bc-modal-subtitle">Danh sách các phòng đang trống có thể thêm vào đơn đặt</p>
                    </div>
                    <button type="button" class="bc-modal-close" onclick="closeRoomModal()">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>

                <div class="bc-modal-filter-row">
                    <div class="bc-filter-search">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" placeholder="Tìm số phòng...">
                    </div>
                    <select class="bc-select" style="min-width: 160px; padding: 8px 12px; height: 40px;">
                        <option>Tất cả loại phòng</option>
                        <option>Urban Deluxe</option>
                        <option>Family Studio</option>
                        <option>Executive Suite</option>
                    </select>
                    <select class="bc-select" style="min-width: 140px; padding: 8px 12px; height: 40px;">
                        <option>Tất cả tầng</option>
                        <option>Tầng 1</option>
                        <option>Tầng 2</option>
                        <option>Tầng 3</option>
                        <option>Tầng 4</option>
                    </select>
                </div>

                <div class="bc-modal-body">
                    <div class="bc-room-grid-modal">
                        {{-- Mock Data --}}
                        @php
                            $mockRooms = [
                                ['num' => '101', 'type' => 'URBAN DELUXE', 'price' => '1,200,000 đ'],
                                ['num' => '102', 'type' => 'URBAN DELUXE', 'price' => '1,200,000 đ', 'selected' => true],
                                ['num' => '205', 'type' => 'EXECUTIVE SUITE', 'price' => '2,000,000 đ'],
                                ['num' => '206', 'type' => 'EXECUTIVE SUITE', 'price' => '2,000,000 đ'],
                                ['num' => '301', 'type' => 'FAMILY STUDIO', 'price' => '3,500,000 đ'],
                                ['num' => '302', 'type' => 'FAMILY STUDIO', 'price' => '3,500,000 đ'],
                                ['num' => '405', 'type' => 'URBAN DELUXE', 'price' => '1,200,000 đ'],
                                ['num' => '501', 'type' => 'PENTHOUSE', 'price' => '5,500,000 đ'],
                            ];
                        @endphp

                        @foreach($mockRooms as $room)
                            <div class="bc-room-card-select {{ isset($room['selected']) ? 'is-selected' : '' }}" onclick="this.classList.toggle('is-selected')">
                                <span class="bc-rcs-num">{{ $room['num'] }}</span>
                                <span class="bc-rcs-type">{{ $room['type'] }}</span>
                                <div class="bc-rcs-status">
                                    <span class="bc-rcs-dot"></span> Trống
                                </div>
                                <span class="bc-rcs-price">{{ $room['price'] }}</span>
                                <div class="bc-rcs-check">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4"><polyline points="20 6 9 17 4 12"/></svg>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bc-modal-footer">
                    <button type="button" class="bc-btn-modal-cancel" onclick="closeRoomModal()">Hủy</button>
                    <button type="button" class="bc-btn-modal-confirm">Xác nhận</button>
                </div>
            </div>
        </div>

    </main>
</div>

@vite(['resources/css/admin/booking-create.css', 'resources/js/admin/booking-create.js'])
@endsection