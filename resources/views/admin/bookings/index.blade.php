@extends('admin.layouts.master')

@section('title', 'Quản lý đặt lịch | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/bookings.css')
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

        {{-- MAIN CONTENT --}}
        <div style="flex:1; overflow-y:auto; padding:28px 32px; display:flex; flex-direction:column; background:#f8fafc;">
            
            <div class="bk-container">
                <div class="bk-header">
                    <div>
                        <h1 class="bk-title">Quản lý đặt lịch</h1>
                        <p class="bk-subtitle">Hệ thống quản trị khách sạn Urban Luxe - Quản lý đặt lịch khách hàng.</p>
                    </div>
                    <a href="{{ route('admin.bookings.create') }}" style="text-decoration: none;">
                        <button class="bk-btn-primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                            Tạo đặt phòng mới
                        </button>
                    </a>
                </div>

                <div class="bk-toolbar">
                    <div class="bk-search">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <input type="text" placeholder="Tìm theo Tên khách / Mã đặt phòng...">
                    </div>
                    <div class="bk-filters">
                        <select class="bk-select">
                            <option>Tất cả trạng thái</option>
                            <option>Đã xác nhận</option>
                            <option>Đang ở</option>
                            <option>Đã hủy</option>
                            <option>Chờ xác nhận</option>
                        </select>
                        <button class="bk-btn-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                        </button>
                    </div>
                </div>

                <div class="bk-table-wrapper">
                    <table class="bk-table">
                        <thead>
                            <tr>
                                <th>MÃ ĐẶT PHÒNG</th>
                                <th>KHÁCH HÀNG</th>
                                <th>LOẠI PHÒNG</th>
                                <th>CHECK-IN</th>
                                <th>CHECK-OUT</th>
                                <th>TỔNG TIỀN</th>
                                <th>TRẠNG THÁI</th>
                                <th>THAO TÁC</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="bk-id">#UL-280424</td>
                                <td>
                                    <div class="bk-customer-name">Nguyễn Văn An</div>
                                    <div class="bk-customer-phone">090xxxx123</div>
                                </td>
                                <td class="bk-room-type">Urban Suite King</td>
                                <td class="bk-date">25/05/2024</td>
                                <td class="bk-date">27/05/2024</td>
                                <td class="bk-price">5,000,000 đ</td>
                                <td><span class="bk-badge confirmed">Đã xác nhận</span></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="bk-id">#UL-280425</td>
                                <td>
                                    <div class="bk-customer-name">Trần Thị Bích</div>
                                    <div class="bk-customer-phone">091xxxx456</div>
                                </td>
                                <td class="bk-room-type">Urban Deluxe Twin</td>
                                <td class="bk-date">24/05/2024</td>
                                <td class="bk-date">26/05/2024</td>
                                <td class="bk-price">3,600,000 đ</td>
                                <td><span class="bk-badge staying">Đang ở</span></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="bk-id">#UL-280426</td>
                                <td>
                                    <div class="bk-customer-name">Lê Hoàng Nam</div>
                                    <div class="bk-customer-phone">093xxxx789</div>
                                </td>
                                <td class="bk-room-type">Luxe Executive</td>
                                <td class="bk-date">20/05/2024</td>
                                <td class="bk-date">22/05/2024</td>
                                <td class="bk-price">6,400,000 đ</td>
                                <td><span class="bk-badge cancelled">Đã hủy</span></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="bk-id">#UL-280427</td>
                                <td>
                                    <div class="bk-customer-name">Phạm Minh Tuấn</div>
                                    <div class="bk-customer-phone">098xxxx555</div>
                                </td>
                                <td class="bk-room-type">Urban Family Studio</td>
                                <td class="bk-date">26/05/2024</td>
                                <td class="bk-date">28/05/2024</td>
                                <td class="bk-price">13,500,000 đ</td>
                                <td><span class="bk-badge pending">Chờ xác nhận</span></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="bk-footer">
                    <div class="bk-footer-text">
                        Hiển thị 1 đến 4 trên 48 đặt lịch
                    </div>
                    <div class="bk-pagination">
                        <button class="bk-page-btn border disabled">&lt;</button>
                        <button class="bk-page-btn active">1</button>
                        <button class="bk-page-btn">2</button>
                        <button class="bk-page-btn">3</button>
                        <button class="bk-page-btn border">&gt;</button>
                    </div>
                </div>
            </div>

        </div>
    </main>
</div>
@include('admin.layouts.footer') 
@endsection
