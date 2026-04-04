@extends('admin.layouts.master')

@section('title', 'Thống kê Doanh thu | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/statistical.css')
    @vite('resources/css/admin/statisical-revenue.css')
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

            <div class="stats-title-group">
                <h1 class="stats-title">Thống kê Doanh thu</h1>
                <p class="stats-date">Dữ liệu tính đến 24 tháng 03, 2024</p>
            </div>

            {{-- NAV TABS --}}
            <nav class="stats-tabs">
                <a href="{{ route('admin.statistical.index') }}" class="stats-tab {{ request()->routeIs('admin.statistical.index') ? 'active' : '' }}" style="text-decoration: none;">Tổng quan</a>
                <a href="{{ route('admin.statistical.revenue') }}" class="stats-tab {{ request()->routeIs('admin.statistical.revenue') ? 'active' : '' }}" style="text-decoration: none;">Doanh thu</a>
                <a href="{{ route('admin.statistical.room-efficiency') }}" class="stats-tab {{ request()->routeIs('admin.statistical.room-efficiency') ? 'active' : '' }}" style="text-decoration: none;">Hiệu suất phòng</a>
                <a href="{{ route('admin.statistical.customers') }}" class="stats-tab {{ request()->routeIs('admin.statistical.customers') ? 'active' : '' }}" style="text-decoration: none;">Khách hàng</a>
            </nav>

            {{-- FILTERS BAR --}}
            <div class="filters-card">
                <div class="filter-group">
                    <span class="filter-label">Thời gian</span>
                    <div class="filter-btns">
                        <button class="filter-btn-sub active">Hôm nay</button>
                        <button class="filter-btn-sub">Tuần này</button>
                        <button class="filter-btn-sub">Tháng này</button>
                    </div>
                </div>

                <div class="filter-group">
                    <span class="filter-label">Nguồn doanh thu</span>
                    <select class="filter-select">
                        <option>Tất cả các nguồn</option>
                        <option>Đặt phòng trực tuyến</option>
                        <option>Trực tiếp (Walk-in)</option>
                    </select>
                </div>

                <div class="filter-group">
                    <span class="filter-label">Trạng thái hóa đơn</span>
                    <select class="filter-select">
                        <option>Đã Thanh Toán</option>
                        <option>Chưa Thanh Toán</option>
                        <option>Hoàn Tiền</option>
                    </select>
                </div>

                <button class="btn-apply">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="7 13 12 18 17 13"></polyline><polyline points="7 6 12 11 17 6"></polyline></svg>
                    Áp dụng
                </button>
            </div>

            {{-- STATS CARDS --}}
            <div class="rev-stats-grid">
                <div class="rev-stat-card">
                    <div class="rev-stat-icon icon-blue">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                    </div>
                    <div class="rev-stat-info">
                        <h4>TỔNG DOANH THU</h4>
                        <p>125.450.000<span class="rev-stat-currency">₫</span></p>
                    </div>
                </div>

                <div class="rev-stat-card">
                    <div class="rev-stat-icon icon-purple">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21v-4a2 2 0 012-2h14a2 2 0 012 2v4"/><path d="M5 7h14a2 2 0 012 2v2H3V9a2 2 0 012-2z"/></svg>
                    </div>
                    <div class="rev-stat-info">
                        <h4>TIỀN PHÒNG</h4>
                        <p>85.300.000<span class="rev-stat-currency">₫</span></p>
                    </div>
                </div>

                <div class="rev-stat-card">
                    <div class="rev-stat-icon icon-green">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"></polyline></svg>
                    </div>
                    <div class="rev-stat-info">
                        <h4>DỊCH VỤ</h4>
                        <p>32.150.000<span class="rev-stat-currency">₫</span></p>
                    </div>
                </div>

                <div class="rev-stat-card">
                    <div class="rev-stat-icon icon-orange">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8l4 4-4 4M8 12h8"/></svg>
                    </div>
                    <div class="rev-stat-info">
                        <h4>PHỤ THU</h4>
                        <p>8.000.000<span class="rev-stat-currency">₫</span></p>
                    </div>
                </div>
            </div>

            {{-- CHARTS ROW --}}
            <div class="charts-row">
                {{-- TREND CHART --}}
                <div class="chart-card">
                    <div class="chart-header" style="margin-bottom: 20px;">
                        <div class="chart-title-group">
                            <h3 style="font-size: 16px; font-weight: 800; color: #1e293b;">Xu hướng doanh thu</h3>
                        </div>
                        <div class="trend-legend">
                            <div class="legend-dot-group"><span class="dot" style="background:#3b82f6;"></span> Năm nay</div>
                            <div class="legend-dot-group"><span class="dot" style="background:#cbd5e1;"></span> Năm trước</div>
                        </div>
                    </div>
                    
                    <div class="chart-area" style="height: 320px; position:relative; margin-left: 40px; margin-top: 10px;">
                        <div class="y-axis">
                            <span>150M</span>
                            <span>120M</span>
                            <span>90M</span>
                            <span>60M</span>
                            <span>30M</span>
                            <span>0</span>
                        </div>
                        <svg width="100%" height="100%" viewBox="0 0 800 300" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="trendGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" style="stop-color:#3b82f6;stop-opacity:0.08" />
                                    <stop offset="100%" style="stop-color:#3b82f6;stop-opacity:0" />
                                </linearGradient>
                            </defs>
                            {{-- Previous Year (Dashed) --}}
                            <path d="M0,230 Q70,220 130,240 T260,200 T390,220 T520,180 T650,200 T800,160" fill="transparent" stroke="#cbd5e1" stroke-width="2" stroke-dasharray="6,4" />
                            {{-- Current Year --}}
                            <path d="M0,180 Q70,195 130,165 T260,150 T390,120 T520,140 T650,90 T800,60" fill="transparent" stroke="#3b82f6" stroke-width="3" />
                            <path d="M0,180 Q70,195 130,165 T260,150 T390,120 T520,140 T650,90 T800,60 L800,300 L0,300 Z" fill="url(#trendGrad)" />
                            
                            {{-- Points --}}
                            <circle cx="0" cy="180" r="4" fill="#fff" stroke="#3b82f6" stroke-width="2" />
                            <circle cx="130" cy="165" r="4" fill="#fff" stroke="#3b82f6" stroke-width="2" />
                            <circle cx="260" cy="150" r="4" fill="#fff" stroke="#3b82f6" stroke-width="2" />
                            <circle cx="390" cy="120" r="4" fill="#fff" stroke="#3b82f6" stroke-width="2" />
                            <circle cx="520" cy="140" r="4" fill="#fff" stroke="#3b82f6" stroke-width="2" />
                            <circle cx="650" cy="90" r="4" fill="#fff" stroke="#3b82f6" stroke-width="2" />
                            <circle cx="800" cy="60" r="6" fill="#fff" stroke="#3b82f6" stroke-width="4" />
                        </svg>
                        <div class="x-axis">
                            <span>Tháng 1</span>
                            <span>Tháng 2</span>
                            <span>Tháng 3</span>
                            <span>Tháng 4</span>
                            <span>Tháng 5</span>
                            <span>Tháng 6</span>
                            <span>Tháng 7</span>
                            <span>Tháng 8</span>
                            <span>Tháng 9</span>
                            <span>Tháng 10</span>
                            <span>Tháng 11</span>
                            <span>Tháng 12</span>
                        </div>
                    </div>
                </div>

                {{-- DOUGHNUT CHART --}}
                <div class="chart-card">
                    <div class="chart-header">
                        <div class="chart-title-group">
                            <h3 style="font-size: 16px; font-weight: 800; color: #1e293b;">Cơ cấu doanh thu</h3>
                        </div>
                    </div>
                    <div class="doughnut-wrapper" style="width: 200px; height: 200px; margin: 40px auto;">
                        <svg class="doughnut-svg" width="200" height="200" viewBox="0 0 100 100">
                             <!-- Dark Blue: Room (68%) -->
                             <circle class="donut-ring" cx="50" cy="50" r="40" fill="transparent" stroke="#1e2e6b" stroke-width="14" stroke-dasharray="170.8 251.2" stroke-dashoffset="0"/>
                             <!-- Bright Blue: Service (25%) -->
                             <circle class="donut-ring" cx="50" cy="50" r="40" fill="transparent" stroke="#3b82f6" stroke-width="14" stroke-dasharray="62.8 251.2" stroke-dashoffset="-170.8"/>
                             <!-- Light Blue: Surcharge (7%) -->
                             <circle class="donut-ring" cx="50" cy="50" r="40" fill="transparent" stroke="#93c5fd" stroke-width="14" stroke-dasharray="17.6 251.2" stroke-dashoffset="-233.6"/>
                        </svg>
                    </div>
                    <div class="revenue-mix-list" style="margin-top: 32px;">
                        <div class="mix-item">
                            <div class="mix-label-group"><span class="legend-dot" style="background:#1e2e6b; width:10px; height:10px; border-radius:3px;"></span> Tiền phòng</div>
                            <div class="mix-val">68%</div>
                        </div>
                        <div class="mix-item">
                            <div class="mix-label-group"><span class="legend-dot" style="background:#3b82f6; width:10px; height:10px; border-radius:3px;"></span> Dịch vụ</div>
                            <div class="mix-val">25%</div>
                        </div>
                        <div class="mix-item">
                            <div class="mix-label-group"><span class="legend-dot" style="background:#93c5fd; width:10px; height:10px; border-radius:3px;"></span> Phụ thu</div>
                            <div class="mix-val">7%</div>
                        </div>
                    </div>
                </div>
            </div>

             {{-- FOOTER --}}
            @include('admin.layouts.footer')

        </div>

    </main>
</div>
@endsection
