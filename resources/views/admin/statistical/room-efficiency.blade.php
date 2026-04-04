@extends('admin.layouts.master')

@section('title', 'Thống kê Hiệu suất phòng | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/statistical.css')
    @vite('resources/css/admin/statisical-room-efficiency.css')
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
                <h1 class="stats-title">Thống kê Hiệu suất phòng</h1>
                <p class="stats-date">Dữ liệu tính đến 24 tháng 03, 2024</p>
            </div>

            {{-- NAV TABS --}}
            <nav class="stats-tabs">
                <a href="{{ route('admin.statistical.index') }}" class="stats-tab {{ request()->routeIs('admin.statistical.index') ? 'active' : '' }}" style="text-decoration: none;">Tổng quan</a>
                <a href="{{ route('admin.statistical.revenue') }}" class="stats-tab {{ request()->routeIs('admin.statistical.revenue') ? 'active' : '' }}" style="text-decoration: none;">Doanh thu</a>
                <a href="{{ route('admin.statistical.room-efficiency') }}" class="stats-tab {{ request()->routeIs('admin.statistical.room-efficiency') ? 'active' : '' }}" style="text-decoration: none;">Hiệu suất phòng</a>
                <a href="{{ route('admin.statistical.customers') }}" class="stats-tab {{ request()->routeIs('admin.statistical.customers') ? 'active' : '' }}" style="text-decoration: none;">Khách hàng</a>
            </nav>

            {{-- FILTERS --}}
            <div class="eff-filters">
                <div class="eff-filter-group">
                    <span class="eff-label">Khoảng thời gian</span>
                    <select class="eff-select">
                        <option>20/03 - 26/03</option>
                        <option>Tháng này</option>
                    </select>
                </div>
                <div class="eff-filter-group">
                    <span class="eff-label">Loại phòng</span>
                    <select class="eff-select">
                        <option>Tất cả loại phòng</option>
                        <option>Standard</option>
                        <option>Deluxe</option>
                    </select>
                </div>
                <div class="eff-filter-group">
                    <span class="eff-label">Trạng thái đặt phòng</span>
                    <select class="eff-select">
                        <option>Tất cả trạng thái</option>
                        <option>Đã hoàn thành</option>
                        <option>Đang sử dụng</option>
                    </select>
                </div>
                <button class="eff-btn-filter">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    Lọc dữ liệu
                </button>
            </div>

            {{-- STATS CARDS --}}
            <div class="eff-stats-grid">
                <div class="eff-card">
                    <div class="eff-card-title">Hiệu suất phòng (%)</div>
                    <div class="eff-card-val-row">
                        <div class="eff-card-val">84.5%</div>
                        <div class="eff-card-plus">+2%</div>
                    </div>
                    <div class="eff-progress-container">
                        <div class="eff-progress-bar" style="width: 84.5%"></div>
                    </div>
                </div>

                <div class="eff-card">
                    <div class="eff-card-title">Tổng số đặt phòng</div>
                    <div class="eff-card-val-row">
                        <div class="eff-card-val">1,248</div>
                    </div>
                    <div class="eff-card-footer">
                        <span>Tháng này</span>
                        <span style="color:#10b981;">Tăng trưởng tốt</span>
                    </div>
                </div>

                <div class="eff-card">
                    <div class="eff-card-title">Số lượng đặt phòng</div>
                    <div class="eff-card-val-row">
                        <div class="eff-card-val">42</div>
                        <div class="eff-card-minus">-5%</div>
                    </div>
                    <div class="eff-card-footer">
                        <span>Hôm nay vs PQ</span>
                    </div>
                </div>

                <div class="eff-card">
                    <div class="eff-card-title">Doanh thu dự kiến (Tháng)</div>
                    <div class="eff-card-val-row">
                        <div class="eff-card-val">450.2M</div>
                        <span style="font-size:11px; font-weight:700; color:#94a3b8; margin-left:4px;">VNĐ</span>
                    </div>
                    <div class="eff-card-footer">
                        <span>Cần lưu ý thu hồi</span>
                    </div>
                </div>
            </div>

            {{-- ROW STATUS --}}
            <div class="eff-row">
                {{-- LEFT STATUS CHART --}}
                <div class="eff-status-card">
                    <div class="eff-status-header">
                        <h3>Trạng thái phòng hiện tại</h3>
                        <a href="#" style="font-size: 13px; font-weight: 700; color: #2a3f8a; text-decoration: none;">Xem chi tiết</a>
                    </div>
                    <div style="display:flex; align-items:center; justify-content:space-around; padding: 20px 0;">
                        <div class="doughnut-wrapper" style="width: 220px; height: 220px; margin: 0;">
                            <svg class="doughnut-svg" width="220" height="220" viewBox="0 0 100 100">
                                 <!-- Maintenance: Red (12%) -->
                                 <circle class="donut-ring" cx="50" cy="50" r="40" fill="transparent" stroke="#ef4444" stroke-width="12" stroke-dasharray="30.1 221" stroke-dashoffset="-221"/>
                                 <!-- Empty: Blue (19%) -->
                                 <circle class="donut-ring" cx="50" cy="50" r="40" fill="transparent" stroke="#93c5fd" stroke-width="12" stroke-dasharray="47.7 203.5" stroke-dashoffset="-173.3"/>
                                 <!-- In-house: Dark Blue (69%) -->
                                 <circle class="donut-ring" cx="50" cy="50" r="40" fill="transparent" stroke="#1e2e6b" stroke-width="12" stroke-dasharray="173.3 77.9" stroke-dashoffset="0"/>
                            </svg>
                            <div class="doughnut-center" style="transform: translate(-50%, -60%);">
                                <span class="doughnut-percent" style="font-size: 28px;">250</span>
                                <span class="doughnut-label" style="font-size: 9px; opacity:0.7;">TỔNG SỐ PHÒNG</span>
                            </div>
                        </div>
                        <div style="display:flex; flex-direction:column; gap:16px;">
                            <div style="display:flex; align-items:center; gap:12px;">
                                <span style="width:10px; height:10px; border-radius:3px; background:#1e2e6b;"></span>
                                <span style="font-size: 13px; font-weight: 700; color:#64748b; width:100px;">Đang ở:</span>
                                <span style="font-size: 14px; font-weight: 800; color:#1e293b;">185</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:12px;">
                                <span style="width:10px; height:10px; border-radius:3px; background:#93c5fd;"></span>
                                <span style="font-size: 13px; font-weight: 700; color:#64748b; width:100px;">Phòng trống:</span>
                                <span style="font-size: 14px; font-weight: 800; color:#1e293b;">42</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:12px;">
                                <span style="width:10px; height:10px; border-radius:3px; background:#ef4444;"></span>
                                <span style="font-size: 13px; font-weight: 700; color:#64748b; width:100px;">Bảo trì:</span>
                                <span style="font-size: 14px; font-weight: 800; color:#1e293b;">23</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT PROGRESS LIST --}}
                <div class="eff-status-card">
                    <div class="eff-status-header">
                        <h3>Loại phòng được đặt nhiều nhất</h3>
                        <div class="filter-btns" style="padding: 2px;">
                            <button class="filter-btn-sub" style="font-size: 11px; padding: 4px 12px; height:auto;">Tuần này</button>
                        </div>
                    </div>
                    <div class="progress-list">
                        <div class="progress-item">
                            <div class="progress-label-row">
                                <span>SUITE (SUI)</span>
                                <span>98 <span class="progress-unit">Lượt</span></span>
                            </div>
                            <div class="eff-progress-container" style="height: 10px;">
                                <div class="eff-progress-bar" style="width: 90%; background:#1e2e6b;"></div>
                            </div>
                        </div>
                        <div class="progress-item">
                            <div class="progress-label-row">
                                <span>DELUXE (DLX)</span>
                                <span>75 <span class="progress-unit">Lượt</span></span>
                            </div>
                            <div class="eff-progress-container" style="height: 10px;">
                                <div class="eff-progress-bar" style="width: 70%; background:#3b82f6;"></div>
                            </div>
                        </div>
                        <div class="progress-item">
                            <div class="progress-label-row">
                                <span>STANDARD (STD)</span>
                                <span>53 <span class="progress-unit">Lượt</span></span>
                            </div>
                            <div class="eff-progress-container" style="height: 10px;">
                                <div class="eff-progress-bar" style="width: 50%; background:#6366f1;"></div>
                            </div>
                        </div>
                        <div class="progress-item">
                            <div class="progress-label-row">
                                <span>SUPERIOR (SUP)</span>
                                <span>21 <span class="progress-unit">Lượt</span></span>
                            </div>
                            <div class="eff-progress-container" style="height: 10px;">
                                <div class="eff-progress-bar" style="width: 30%; background:#94a3b8;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- DETAIL TABLE --}}
            <div class="eff-table-card">
                <div class="table-header-group">
                    <h3 class="table-title">Chi tiết trạng thái phòng</h3>
                    <div class="table-actions">
                        <button class="btn-export">Xuất Excel</button>
                        <button class="btn-export">In báo cáo</button>
                    </div>
                </div>
                <table class="eff-table">
                    <thead>
                        <tr>
                            <th>Mã phòng</th>
                            <th>Loại phòng</th>
                            <th>Tầng</th>
                            <th>Tỉ lệ lấp đầy (7 ngày)</th>
                            <th>Trạng thái hiện tại</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>P-101</td>
                            <td>Standard</td>
                            <td>Tầng 1</td>
                            <td>
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <span style="font-size:12px; color:#64748b; font-weight:700; width:30px;">92%</span>
                                    <div class="eff-progress-container" style="flex:1;">
                                        <div class="eff-progress-bar" style="width: 92%; background:#10b981;"></div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="eff-badge badge-green">ĐANG Ở</span></td>
                        </tr>
                        <tr>
                            <td>P-205</td>
                            <td>Deluxe</td>
                            <td>Tầng 2</td>
                            <td>
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <span style="font-size:12px; color:#64748b; font-weight:700; width:30px;">45%</span>
                                    <div class="eff-progress-container" style="flex:1;">
                                        <div class="eff-progress-bar" style="width: 45%; background:#f59e0b;"></div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="eff-badge badge-blue">TRỐNG</span></td>
                        </tr>
                        <tr>
                            <td>P-403</td>
                            <td>Suite</td>
                            <td>Tầng 4</td>
                            <td>
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <span style="font-size:12px; color:#64748b; font-weight:700; width:30px;">12%</span>
                                    <div class="eff-progress-container" style="flex:1;">
                                        <div class="eff-progress-bar" style="width: 12%; background:#ef4444;"></div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="eff-badge badge-orange">BẢO TRÌ</span></td>
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
