@extends('admin.layouts.master')

@section('title', 'Thống kê Doanh thu | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/statistical.css')
    @vite('resources/css/admin/statisical-revenue.css')
@endpush

@section('content')
@php
    $summary = $report['summary'];
    $range = $report['range'];
    $filters = $report['filters'];
    $money = fn ($value) => number_format((float) $value, 0, ',', '.');
    $maxRevenue = max(1, $report['max_monthly_revenue']);
    $yAxis = collect([1, .8, .6, .4, .2, 0])->map(fn ($ratio) => round(($maxRevenue * $ratio) / 1000000) . 'M');
@endphp

<div class="admin-layout">
    @include('admin.layouts.sidebar')

    <main class="admin-main">
        @include('admin.layouts.header')

        <div class="admin-content">
            <div class="stats-title-group">
                <h1 class="stats-title">Thống kê Doanh thu</h1>
                <p class="stats-date">{{ $report['generated_at'] }} · {{ $range['label'] }}</p>
            </div>

            <nav class="stats-tabs">
                <a href="{{ route('admin.statistical.index') }}" class="stats-tab {{ request()->routeIs('admin.statistical.index') ? 'active' : '' }}" style="text-decoration: none;">Tổng quan</a>
                <a href="{{ route('admin.statistical.revenue') }}" class="stats-tab {{ request()->routeIs('admin.statistical.revenue') ? 'active' : '' }}" style="text-decoration: none;">Doanh thu</a>
                <a href="{{ route('admin.statistical.room-efficiency') }}" class="stats-tab {{ request()->routeIs('admin.statistical.room-efficiency') ? 'active' : '' }}" style="text-decoration: none;">Hiệu suất phòng</a>
                <a href="{{ route('admin.statistical.customers') }}" class="stats-tab {{ request()->routeIs('admin.statistical.customers') ? 'active' : '' }}" style="text-decoration: none;">Khách hàng</a>
            </nav>

            <form method="GET" action="{{ route('admin.statistical.revenue') }}" class="filters-card">
                <div class="filter-group">
                    <span class="filter-label">Từ ngày</span>
                    <input type="date" class="filter-select" name="start_date" value="{{ $range['start_date'] }}">
                </div>
                <div class="filter-group">
                    <span class="filter-label">Đến ngày</span>
                    <input type="date" class="filter-select" name="end_date" value="{{ $range['end_date'] }}">
                </div>
                <div class="filter-group">
                    <span class="filter-label">Năm biểu đồ</span>
                    <select class="filter-select" name="year">
                        @for($year = now()->year + 1; $year >= now()->year - 5; $year--)
                            <option value="{{ $year }}" {{ (int) $filters['year'] === $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                </div>
                <div class="filter-group">
                    <span class="filter-label">Trạng thái</span>
                    <select class="filter-select" name="status">
                        <option value="all" {{ $filters['status'] === 'all' ? 'selected' : '' }}>Không tính đã hủy</option>
                        <option value="paid" {{ $filters['status'] === 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                        <option value="occupied" {{ $filters['status'] === 'occupied' ? 'selected' : '' }}>Đang ở</option>
                        <option value="confirmed" {{ $filters['status'] === 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                        <option value="pending" {{ $filters['status'] === 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                    </select>
                </div>
                <button class="btn-apply" type="submit">Áp dụng</button>
            </form>

            <div class="rev-stats-grid">
                <div class="rev-stat-card">
                    <div class="rev-stat-icon icon-blue">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                    </div>
                    <div class="rev-stat-info">
                        <h4>TỔNG DOANH THU</h4>
                        <p>{{ $money($summary['total_revenue']) }}<span class="rev-stat-currency">đ</span></p>
                    </div>
                </div>

                <div class="rev-stat-card">
                    <div class="rev-stat-icon icon-purple">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21v-4a2 2 0 012-2h14a2 2 0 012 2v4"/><path d="M5 7h14a2 2 0 012 2v2H3V9a2 2 0 012-2z"/></svg>
                    </div>
                    <div class="rev-stat-info">
                        <h4>TIỀN PHÒNG</h4>
                        <p>{{ $money($summary['room_revenue']) }}<span class="rev-stat-currency">đ</span></p>
                    </div>
                </div>

                <div class="rev-stat-card">
                    <div class="rev-stat-icon icon-green">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="18 15 12 9 6 15"></polyline></svg>
                    </div>
                    <div class="rev-stat-info">
                        <h4>DỊCH VỤ</h4>
                        <p>{{ $money($summary['service_revenue']) }}<span class="rev-stat-currency">đ</span></p>
                    </div>
                </div>

                <div class="rev-stat-card">
                    <div class="rev-stat-icon icon-orange">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8l4 4-4 4M8 12h8"/></svg>
                    </div>
                    <div class="rev-stat-info">
                        <h4>PHỤ THU</h4>
                        <p>{{ $money($summary['surcharge_revenue']) }}<span class="rev-stat-currency">đ</span></p>
                    </div>
                </div>
            </div>

            <div class="charts-row">
                <div class="chart-card">
                    <div class="chart-header" style="margin-bottom: 20px;">
                        <div class="chart-title-group">
                            <h3 style="font-size: 16px; font-weight: 800; color: #1e293b;">Xu hướng doanh thu</h3>
                        </div>
                        <div class="trend-legend">
                            <div class="legend-dot-group"><span class="dot" style="background:#3b82f6;"></span> Năm {{ $filters['year'] }}</div>
                            <div class="legend-dot-group"><span class="dot" style="background:#cbd5e1;"></span> Năm {{ $filters['year'] - 1 }}</div>
                        </div>
                    </div>

                    <div class="chart-area" style="height: 320px; position:relative; margin-left: 40px; margin-top: 10px;">
                        <div class="y-axis">
                            @foreach($yAxis as $label)
                                <span>{{ $label }}</span>
                            @endforeach
                        </div>
                        <svg width="100%" height="100%" viewBox="0 0 800 300" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="trendGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" style="stop-color:#3b82f6;stop-opacity:0.08" />
                                    <stop offset="100%" style="stop-color:#3b82f6;stop-opacity:0" />
                                </linearGradient>
                            </defs>
                            <path d="{{ $report['previous_year_chart']['path'] }}" fill="transparent" stroke="#cbd5e1" stroke-width="2" stroke-dasharray="6,4" />
                            <path d="{{ $report['current_year_chart']['area_path'] }}" fill="url(#trendGrad)" />
                            <path d="{{ $report['current_year_chart']['path'] }}" fill="transparent" stroke="#3b82f6" stroke-width="3" />
                            @foreach($report['current_year_chart']['points'] as $point)
                                <circle cx="{{ $point[0] }}" cy="{{ $point[1] }}" r="{{ $loop->last ? 6 : 4 }}" fill="#fff" stroke="#3b82f6" stroke-width="{{ $loop->last ? 4 : 2 }}" />
                            @endforeach
                        </svg>
                        <div class="x-axis">
                            @foreach($report['monthly_revenue'] as $month)
                                <span>T{{ $month['month'] }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="chart-card">
                    <div class="chart-header">
                        <div class="chart-title-group">
                            <h3 style="font-size: 16px; font-weight: 800; color: #1e293b;">Cơ cấu doanh thu</h3>
                        </div>
                    </div>
                    <div class="doughnut-wrapper" style="width: 200px; height: 200px; margin: 40px auto;">
                        <svg class="doughnut-svg" width="200" height="200" viewBox="0 0 100 100">
                            @foreach($report['revenue_mix'] as $item)
                                <circle class="donut-ring" cx="50" cy="50" r="40" fill="transparent" stroke="{{ $item['color'] }}" stroke-width="14" stroke-dasharray="{{ $item['dasharray'] }}" stroke-dashoffset="{{ $item['dashoffset'] }}"/>
                            @endforeach
                        </svg>
                    </div>
                    <div class="revenue-mix-list" style="margin-top: 32px;">
                        @foreach($report['revenue_mix'] as $item)
                            <div class="mix-item">
                                <div class="mix-label-group"><span class="legend-dot" style="background:{{ $item['color'] }}; width:10px; height:10px; border-radius:3px;"></span> {{ $item['label'] }}</div>
                                <div class="mix-val">{{ $item['percent'] }}%</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            @include('admin.layouts.footer')
        </div>
    </main>
</div>
@endsection
