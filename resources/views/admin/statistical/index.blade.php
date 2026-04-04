@extends('admin.layouts.master')

@section('title', 'Thống kê tổng quan | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/statistical.css')
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
                <button class="admin-header-notification">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg>
                    <span class="admin-header-notification-dot"></span>
                </button>
                <div class="admin-header-divider"></div>
                <div class="admin-header-user">
                    <div class="admin-header-user-info">
                        <div class="admin-header-user-name">Admin Đức</div>
                        <div class="admin-header-user-role">Quản lý cấp cao</div>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=Admin+Duc&background=2a3f8a&color=fff&size=80" class="admin-header-user-avatar" alt="Admin">
                </div>
            </div>
        </header>

        {{-- MAIN CONTENT --}}
        <div class="admin-content">

            <div class="stats-title-group">
                <h1 class="stats-title">Thống kê Tổng quan</h1>
                <p class="stats-date">Dữ liệu tính đến 24 tháng 03, 2024</p>
            </div>

            {{-- NAV TABS --}}
            <nav class="stats-tabs">
                <a href="{{ route('admin.statistical.index') }}" class="stats-tab {{ request()->routeIs('admin.statistical.index') ? 'active' : '' }}" style="text-decoration: none;">Tổng quan</a>
                <a href="{{ route('admin.statistical.revenue') }}" class="stats-tab {{ request()->routeIs('admin.statistical.revenue') ? 'active' : '' }}" style="text-decoration: none;">Doanh thu</a>
                <a href="{{ route('admin.statistical.room-efficiency') }}" class="stats-tab {{ request()->routeIs('admin.statistical.room-efficiency') ? 'active' : '' }}" style="text-decoration: none;">Hiệu suất phòng</a>
                <a href="{{ route('admin.statistical.customers') }}" class="stats-tab {{ request()->routeIs('admin.statistical.customers') ? 'active' : '' }}" style="text-decoration: none;">Khách hàng</a>
            </nav>

            {{-- QUICK STATS --}}
            <div class="stats-grid">
                <div class="stat-card revenue">
                    <div class="stat-label">Tổng doanh thu/tháng</div>
                    <div class="stat-value-group">
                        <div class="stat-value">1.2B VNĐ</div>
                        <div class="stat-trending up">+12.5%</div>
                    </div>
                </div>

                <div class="stat-card occupancy">
                    <div class="stat-label">Công suất phòng TB</div>
                    <div class="stat-value-group">
                        <div class="stat-value">85%</div>
                        <div class="stat-trending up">+5.2%</div>
                    </div>
                </div>

                <div class="stat-card guests">
                    <div class="stat-label">Tổng lượt khách</div>
                    <div class="stat-value-group">
                        <div class="stat-value">1,240</div>
                        <div class="stat-trending up">+8.1%</div>
                    </div>
                </div>

                <div class="stat-card rating">
                    <div class="stat-label">Đánh giá trung bình</div>
                    <div class="stat-value-group">
                        <div class="stat-value">4.8/5</div>
                        <div class="stat-trending up">+0.2%</div>
                    </div>
                    <div class="stat-rating-stars">
                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                </div>
            </div>

            {{-- CHARTS ROW --}}
            <div class="charts-row">
                <div class="chart-card">
                    <div class="chart-header">
                        <div class="chart-title-group">
                            <h3>Doanh thu & Chi phí</h3>
                            <p>Thống kê số tiền thực tế trong 30 ngày qua</p>
                        </div>
                        <div class="chart-legend">
                            <div class="legend-item"><span class="legend-dot" style="background:#f0642f;"></span> Doanh thu</div>
                            <div class="legend-item"><span class="legend-dot" style="background:#94a3b8;"></span> Chi phí</div>
                        </div>
                    </div>
                    {{-- SVG CHART MOCK --}}
                    <div class="chart-mock" style="height: 250px; position:relative; margin-top:20px;">
                        <svg width="100%" height="100%" viewBox="0 0 600 200" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="gradRevenue" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" style="stop-color:#f0642f;stop-opacity:0.2" />
                                    <stop offset="100%" style="stop-color:#f0642f;stop-opacity:0" />
                                </linearGradient>
                            </defs>
                            <path d="M0,150 Q75,150 100,120 T200,140 T300,80 T400,140 T500,120 T600,60" fill="transparent" stroke="#f0642f" stroke-width="3" />
                            <path d="M0,150 Q75,150 100,120 T200,140 T300,80 T400,140 T500,120 T600,60 L600,200 L0,200 Z" fill="url(#gradRevenue)" />
                            <path d="M0,180 Q75,170 150,175 T300,165 T450,170 T600,160" fill="transparent" stroke="#cbd5e1" stroke-width="2" stroke-dasharray="4" />
                        </svg>
                        <div style="display:flex; justify-content:space-between; margin-top:10px; font-size:11px; color:#94a3b8;">
                            <span>01/3</span>
                            <span>07/3</span>
                            <span>14/3</span>
                            <span>21/3</span>
                            <span>28/3</span>
                            <span>31/3</span>
                        </div>
                    </div>
                </div>

                <div class="chart-card">
                    <div class="chart-header">
                        <div class="chart-title-group">
                            <h3>Cơ cấu doanh thu</h3>
                        </div>
                    </div>
                    <div class="doughnut-wrapper">
                        <svg class="doughnut-svg" width="180" height="180" viewBox="0 0 100 100">
                            <!-- Green: Food/Bev (10%) -->
                            <circle class="donut-ring" cx="50" cy="50" r="40" fill="transparent" stroke="#10b981" stroke-width="12" stroke-dasharray="25.1 226"/>
                            <!-- Blue: Service (15%) -->
                            <circle class="donut-ring" cx="50" cy="50" r="40" fill="transparent" stroke="#4f46e5" stroke-width="12" stroke-dasharray="37.7 213.4" stroke-dashoffset="-25.1"/>
                            <!-- Orange: Rooms (75%) -->
                            <circle class="donut-ring" cx="50" cy="50" r="40" fill="transparent" stroke="#f0642f" stroke-width="12" stroke-dasharray="188.4 62.8" stroke-dashoffset="-62.8"/>
                        </svg>
                        <div class="doughnut-center">
                            <span class="doughnut-percent">100%</span>
                            <span class="doughnut-label">Total</span>
                        </div>
                    </div>
                    <div class="revenue-mix-list">
                        <div class="mix-item">
                            <div class="mix-label-group"><span class="legend-dot" style="background:#f0642f;"></span> Đặt phòng (Room)</div>
                            <div class="mix-val">75%</div>
                        </div>
                        <div class="mix-item">
                            <div class="mix-label-group"><span class="legend-dot" style="background:#4f46e5;"></span> Dịch vụ (FB)</div>
                            <div class="mix-val">15%</div>
                        </div>
                        <div class="mix-item">
                            <div class="mix-label-group"><span class="legend-dot" style="background:#10b981;"></span> Khác (Other)</div>
                            <div class="mix-val">10%</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RECENT ACTIVITIES --}}
            <div class="activities-card">
                <div class="activities-header">
                    <h3>Hoạt động gần đây</h3>
                    <a href="#" class="btn-view-all">Xem tất cả</a>
                </div>
                <div class="activities-list">
                    <div class="activity-item">
                        <div class="activity-icon" style="background:rgba(240,100,47,0.1); color:#f0642f;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                        </div>
                        <div class="activity-info">
                            <div class="activity-title">Phòng 102 - Out/Check out</div>
                            <div class="activity-desc">Khách hàng: Nguyễn Lâm Anh</div>
                        </div>
                        <div class="activity-time">Vừa mới đây</div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon" style="background:rgba(16,185,129,0.1); color:#10b981;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="8.5" cy="7" r="4"/><path d="M20 8v6M23 11h-6"/></svg>
                        </div>
                        <div class="activity-info">
                            <div class="activity-title">Đơn đặt phòng mới - Suite 101</div>
                            <div class="activity-desc">Thời gian: 10/05 - 12/05</div>
                        </div>
                        <div class="activity-time">15 phút trước</div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon" style="background:rgba(79,70,229,0.1); color:#4f46e5;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        </div>
                        <div class="activity-info">
                            <div class="activity-title">Yêu cầu dọn phòng - Deluxe 203</div>
                            <div class="activity-desc">Từ: Trần Văn Hoàng</div>
                        </div>
                        <div class="activity-time">1 giờ trước</div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon" style="background:rgba(168,85,247,0.1); color:#a855f7;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 10V7a4 4 0 00-8 0v3h8z"/><rect x="4" y="10" width="16" height="11" rx="2"/><circle cx="12" cy="15" r="2"/></svg>
                        </div>
                        <div class="activity-info">
                            <div class="activity-title">Dịch vụ Spa - Phòng 302</div>
                            <div class="activity-desc">Khách hàng: Thảo Vy</div>
                        </div>
                        <div class="activity-time">2 giờ trước</div>
                    </div>
                </div>
            </div>

             {{-- FOOTER --}}
            @include('admin.layouts.footer')

        </div>

    </main>
</div>
@endsection