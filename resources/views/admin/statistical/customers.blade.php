@extends('admin.layouts.master')

@section('title', 'Thống kê Khách hàng | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/statistical.css')
    @vite('resources/css/admin/statisical-customers.css')
@endpush

@section('content')
<div class="admin-layout">

    {{-- SIDEBAR --}}
    @include('admin.layouts.sidebar')

    {{-- CONTENT --}}
    <main class="admin-main">

         {{-- HEADER --}}
        <header class="admin-header">
            <div class="admin-header-left">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012-2h10a2 2 0 012 2v14M9 21v-6h6v6"/></svg>
                16819 &middot; Urban Luxe Hotel
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
            <div class="admin-header-right">
                <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-right: 20px; letter-spacing: 0.5px;">Ngày làm việc: 24 tháng 03, 2024</div>
                <button class="admin-header-notification">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg>
                    <span class="admin-header-notification-dot"></span>
                </button>
                <div class="admin-header-divider" style="margin: 0 5px;"></div>
                <div class="admin-header-user">
                    <img src="https://ui-avatars.com/api/?name=Admin+Duc&background=f0642f&color=fff&size=80" class="admin-header-user-avatar" alt="Admin">
                </div>
            </div>
        </header>

        {{-- MAIN CONTENT --}}
        <div class="admin-content">

            <div class="stats-title-group" style="display:flex; justify-content:space-between; align-items:flex-end;">
                <div>
                    <h1 class="stats-title">Thống kê Khách hàng</h1>
                    <p class="stats-date" style="text-transform: none; letter-spacing: 0;">Xem báo cáo chi tiết và tình hình khách hàng trong kỳ.</p>
                </div>
                
                {{-- FILTERS --}}
                
            </div>

            {{-- NAV TABS --}}
            <nav class="stats-tabs">
                <a href="{{ route('admin.statistical.index') }}" class="stats-tab {{ request()->routeIs('admin.statistical.index') ? 'active' : '' }}" style="text-decoration: none;">Tổng quan</a>
                <a href="{{ route('admin.statistical.revenue') }}" class="stats-tab {{ request()->routeIs('admin.statistical.revenue') ? 'active' : '' }}" style="text-decoration: none;">Doanh thu</a>
                <a href="{{ route('admin.statistical.room-efficiency') }}" class="stats-tab {{ request()->routeIs('admin.statistical.room-efficiency') ? 'active' : '' }}" style="text-decoration: none;">Hiệu suất phòng</a>
                <a href="{{ route('admin.statistical.customers') }}" class="stats-tab {{ request()->routeIs('admin.statistical.customers') ? 'active' : '' }}" style="text-decoration: none;">Khách hàng</a>
            </nav>
            <div class="cust-filters">
                    <input type="date" class="cust-filter-input" value="2024-03-24">
                    <select class="cust-filter-input">
                        <option>Tất cả loại khách</option>
                        <option>Khách hàng VIP</option>
                        <option>Khách hàng Thường</option>
                    </select>
                    <button class="cust-btn-filter">Lọc kết quả</button>
                </div>

            {{-- STATS CARDS --}}
            <div class="cust-stats-grid">
                <div class="cust-card">
                    <div class="cust-card-title">Tổng lượt khách</div>
                    <div class="cust-card-val">1,284</div>
                    <div class="cust-card-trend up">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" style="vertical-align: middle; margin-right: 4px;"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                        +12% so với tháng trước
                    </div>
                </div>

                <div class="cust-card">
                    <div class="cust-card-title">Khách hàng mới</div>
                    <div class="cust-card-val">342</div>
                    <div class="cust-card-trend up">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" style="vertical-align: middle; margin-right: 4px;"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                        +8.5% từ quý trước
                    </div>
                </div>

                <div class="cust-card">
                    <div class="cust-card-title">Tỉ lệ quay lại</div>
                    <div class="cust-card-val">28.4%</div>
                    <div class="cust-card-trend stable">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" style="vertical-align: middle; margin-right: 4px;"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        Ổn định trong năm
                    </div>
                </div>

                <div class="cust-card">
                    <div class="cust-card-title">Đánh giá TB</div>
                    <div class="cust-card-val">4.8/5.0</div>
                    <div class="cust-card-trend stable">
                        Dựa trên 550 đánh giá
                    </div>
                </div>
            </div>

            {{-- LOYAL CUSTOMERS TABLE --}}
            <div class="loyal-card">
                <div class="loyal-header">
                    <h3>Khách hàng Thân thiết (Loyal Customers)</h3>
                    <a href="#" style="font-size: 13px; font-weight: 700; color: #2a3f8a; text-decoration: none;">Xem tất cả</a>
                </div>
                <table class="loyal-table">
                    <thead>
                        <tr>
                            <th>Khách hàng</th>
                            <th>Lượt đến</th>
                            <th>Tổng chi tiêu (VND)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="cust-info-cell">
                                    <img src="https://ui-avatars.com/api/?name=Nguyen+Van+An&background=0284c7&color=fff" class="cust-avatar">
                                    <div class="cust-details">
                                        <div class="cust-name">Nguyễn Văn An</div>
                                        <div class="cust-email">an.nguyen@email.com</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="visit-count">12 lượt</span></td>
                            <td><span class="spending-val">45,200,000</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="cust-info-cell">
                                    <img src="https://ui-avatars.com/api/?name=Le+Thi+Mai&background=db2777&color=fff" class="cust-avatar">
                                    <div class="cust-details">
                                        <div class="cust-name">Lê Thị Mai</div>
                                        <div class="cust-email">mai.le@email.com</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="visit-count">8 lượt</span></td>
                            <td><span class="spending-val">32,150,000</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="cust-info-cell">
                                    <img src="https://ui-avatars.com/api/?name=Tran+Minh+Tam&background=10b981&color=fff" class="cust-avatar">
                                    <div class="cust-details">
                                        <div class="cust-name">Trần Minh Tâm</div>
                                        <div class="cust-email">tam.tran@email.com</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="visit-count">7 lượt</span></td>
                            <td><span class="spending-val">28,420,000</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="cust-info-cell">
                                    <img src="https://ui-avatars.com/api/?name=Pham+Hoang+Nam&background=4f46e5&color=fff" class="cust-avatar">
                                    <div class="cust-details">
                                        <div class="cust-name">Phạm Hoàng Nam</div>
                                        <div class="cust-email">nam.pham@email.com</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="visit-count">5 lượt</span></td>
                            <td><span class="spending-val">19,450,000</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="cust-info-cell">
                                    <img src="https://ui-avatars.com/api/?name=Dang+Thu+Thao&background=f0642f&color=fff" class="cust-avatar">
                                    <div class="cust-details">
                                        <div class="cust-name">Đặng Thu Thảo</div>
                                        <div class="cust-email">thao.dang@email.com</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="visit-count">5 lượt</span></td>
                            <td><span class="spending-val">15,600,000</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

             {{-- FOOTER --}}
            @include('admin.layouts.footer')

        </div>

    </main>
</div>
@endsection
