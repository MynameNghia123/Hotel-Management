@extends('admin.layouts.master')

@section('title', 'Xem / Chỉnh sửa khách hàng | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/customer-edit.css')
@endpush

@section('content')
<div style="display:flex; height:100vh; background:#f5f6fa;">

    {{-- SIDEBAR --}}
    @include('admin.layouts.sidebar')

    {{-- CONTENT --}}
    <main style="flex:1; display:flex; flex-direction:column; overflow:hidden;">

        {{-- HEADER --}}
        <header style="height:64px; background:#fff; border-bottom:1px solid #f1f3f7; padding:0 32px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0; box-shadow:0 1px 4px rgba(0,0,0,.04);">
            <div style="display:flex; align-items:center; gap:8px; font-size:14px; font-weight:600; color:#1e293b; cursor:pointer;">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 21v-6h6v6"/></svg>
                16819 &middot; Urban Luxe Hotel
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
            <div style="display:flex; align-items:center; gap:18px;">
                <button style="position:relative; width:36px; height:36px; border:none; background:transparent; cursor:pointer; display:flex; align-items:center; justify-content:center; border-radius:10px; color:#94a3b8;">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg>
                    <span style="position:absolute; top:6px; right:6px; width:8px; height:8px; background:#ef4444; border-radius:50%; border:2px solid #fff;"></span>
                </button>
                <div style="width:1px; height:28px; background:#f1f3f7;"></div>
                <div style="display:flex; align-items:center; gap:10px; cursor:pointer;">
                    <div style="text-align:right;">
                        <div style="font-size:13px; font-weight:700; color:#1e293b; line-height:1.2;">Admin Đức</div>
                        <div style="font-size:11px; color:#94a3b8; font-weight:500;">Quản lý cấp cao</div>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=Admin+Duc&background=2a3f8a&color=fff&size=80" style="width:36px; height:36px; border-radius:50%; border:2px solid rgba(42,63,138,.2);" alt="Admin">
                </div>
            </div>
        </header>

        {{-- MAIN CONTENT AREA --}}
        <div style="flex:1; overflow-y:auto; padding:28px 32px; background:#f8fafc;">
            
            <div class="ce-container">
                {{-- Header Section --}}
                <div class="ce-header">
                    <a href="{{ route('admin.customers') }}" class="ce-back" style="text-decoration: none;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        Quay lại danh sách
                    </a>
                    <h1 class="ce-title">Xem / Chỉnh sửa khách hàng</h1>
                    <p class="ce-subtitle">Cập nhật thông tin chi tiết và lịch sử khách hàng Urban Luxe</p>
                </div>

                {{-- Detail Card --}}
                <div class="ce-card">
                    <form action="#" method="POST">
                        @csrf
                        {{-- 1. THÔNG TIN CÁ NHÂN --}}
                        <div class="ce-section-header">
                            <h2 class="ce-section-title">THÔNG TIN CÁ NHÂN</h2>
                        </div>
                        <div class="ce-form-body">
                            <div class="ce-form-grid">
                                <div class="ce-form-group">
                                    <label class="ce-label">Họ</label>
                                    <input type="text" class="ce-input" value="Nguyen" placeholder="Nhập họ">
                                </div>
                                <div class="ce-form-group">
                                    <label class="ce-label">Email</label>
                                    <input type="email" class="ce-input" value="minhanh.vn@gmail.com" placeholder="example@email.com">
                                </div>
                                <div class="ce-form-group">
                                    <label class="ce-label">Tên</label>
                                    <input type="text" class="ce-input" value="Minh Anh" placeholder="Nhập tên">
                                </div>
                                <div class="ce-form-group">
                                    <label class="ce-label">Quốc gia</label>
                                    <select class="ce-input ce-select">
                                        <option value="Vietnam" selected>Việt Nam</option>
                                        <option value="USA">Hoa Kỳ</option>
                                        <option value="Japan">Nhật Bản</option>
                                    </select>
                                </div>
                                <div class="ce-form-group full-width">
                                    <label class="ce-label">Số điện thoại</label>
                                    <input type="text" class="ce-input" value="0901234567" placeholder="VD: 0901234567">
                                </div>
                            </div>
                        </div>

                        {{-- 2. LỊCH SỬ ĐẶT PHÒNG --}}
                        <div class="ce-section-header" style="border-top:1px solid #f1f3f7; margin-top:10px;">
                            <h2 class="ce-section-title">LỊCH SỬ ĐẶT PHÒNG</h2>
                        </div>
                        <div class="ce-table-container">
                            <table class="ce-table">
                                <thead>
                                    <tr>
                                        <th>MÃ ĐẶT PHÒNG</th>
                                        <th>NGÀY ĐẾN</th>
                                        <th>NGÀY ĐI</th>
                                        <th>TIỀN PHÒNG</th>
                                        <th>TIỀN DỊCH VỤ</th>
                                        <th>TỔNG TIỀN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><a href="#" class="ce-booking-id">#BK-9752</a></td>
                                        <td>22/03/2024</td>
                                        <td>24/03/2024</td>
                                        <td>2,750,000 đ</td>
                                        <td>250,550 đ</td>
                                        <td><span class="ce-total-price">3,450,000 đ</span></td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" class="ce-booking-id">#BK-6451</a></td>
                                        <td>10/01/2024</td>
                                        <td>12/01/2024</td>
                                        <td>3,850,000 đ</td>
                                        <td>430,000 đ</td>
                                        <td><span class="ce-total-price">4,280,000 đ</span></td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" class="ce-booking-id">#BK-7112</a></td>
                                        <td>05/12/2023</td>
                                        <td>06/12/2023</td>
                                        <td>850,000 đ</td>
                                        <td>30,000 đ</td>
                                        <td><span class="ce-total-price">880,000 đ</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        {{-- Footer Buttons --}}
                        <div class="ce-footer">
                            <button type="button" class="ce-btn ce-btn-cancel">Hủy</button>
                            <button type="submit" class="ce-btn ce-btn-save">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px;"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                                Lưu thông tin
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Copyright --}}
                <div style="text-align:center; margin-top:40px; font-size:12px; color:#94a3b8; font-weight:500;">
                    &copy; 2024 Urban Luxe Management System. All rights reserved.
                </div>
            </div>

        </div>
    </main>
</div>
@endsection
