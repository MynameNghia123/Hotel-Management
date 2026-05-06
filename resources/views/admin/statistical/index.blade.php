@extends('admin.layouts.master')

@section('title', 'Thống kê tổng quan | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/statistical.css')
    @vite('resources/css/admin/statisical-revenue.css')
@endpush

@section('content')
@php
    $summary = $report['summary'];
    $range = $report['range'];
    $money = fn ($value) => number_format((float) $value, 0, ',', '.') . 'đ';
    $compactMoney = fn ($value) => (float) $value >= 1000000000
        ? round($value / 1000000000, 1) . 'B'
        : round($value / 1000000, 1) . 'M';
    $trend = fn ($value) => ($value >= 0 ? '+' : '') . $value . '%';
    $labelStep = max(1, (int) floor(max(1, $report['daily_revenue']->count()) / 5));
@endphp

<div class="admin-layout">
    @include('admin.layouts.sidebar')

    <main class="admin-main">
        @include('admin.layouts.header')

        <div class="admin-content">
            <div class="stats-title-group">
                <h1 class="stats-title">Thống kê Tổng quan</h1>
                <p class="stats-date">{{ $report['generated_at'] }} · {{ $range['label'] }}</p>
            </div>

            <nav class="stats-tabs">
                <a href="{{ route('admin.statistical.index') }}" class="stats-tab {{ request()->routeIs('admin.statistical.index') ? 'active' : '' }}" style="text-decoration: none;">Tổng quan</a>
                <a href="{{ route('admin.statistical.revenue') }}" class="stats-tab {{ request()->routeIs('admin.statistical.revenue') ? 'active' : '' }}" style="text-decoration: none;">Doanh thu</a>
                <a href="{{ route('admin.statistical.room-efficiency') }}" class="stats-tab {{ request()->routeIs('admin.statistical.room-efficiency') ? 'active' : '' }}" style="text-decoration: none;">Hiệu suất phòng</a>
                <a href="{{ route('admin.statistical.customers') }}" class="stats-tab {{ request()->routeIs('admin.statistical.customers') ? 'active' : '' }}" style="text-decoration: none;">Khách hàng</a>
            </nav>

            <form method="GET" action="{{ route('admin.statistical.index') }}" class="filters-card" style="margin-bottom:20px;">
                <div class="filter-group">
                    <span class="filter-label">Từ ngày</span>
                    <input type="date" class="filter-select" name="start_date" value="{{ $range['start_date'] }}">
                </div>
                <div class="filter-group">
                    <span class="filter-label">Đến ngày</span>
                    <input type="date" class="filter-select" name="end_date" value="{{ $range['end_date'] }}">
                </div>
                <button class="btn-apply" type="submit">Áp dụng</button>
            </form>

            <div class="stats-grid">
                <div class="stat-card revenue">
                    <div class="stat-label">Tổng doanh thu</div>
                    <div class="stat-value-group">
                        <div class="stat-value">{{ $compactMoney($summary['revenue']) }} VNĐ</div>
                        <div class="stat-trending {{ $summary['revenue_growth'] >= 0 ? 'up' : 'down' }}">{{ $trend($summary['revenue_growth']) }}</div>
                    </div>
                </div>

                <div class="stat-card occupancy">
                    <div class="stat-label">Công suất phòng TB</div>
                    <div class="stat-value-group">
                        <div class="stat-value">{{ $summary['occupancy_rate'] }}%</div>
                        <div class="stat-trending {{ $summary['occupancy_growth'] >= 0 ? 'up' : 'down' }}">{{ $trend($summary['occupancy_growth']) }}</div>
                    </div>
                </div>

                <div class="stat-card guests">
                    <div class="stat-label">Tổng lượt khách</div>
                    <div class="stat-value-group">
                        <div class="stat-value">{{ number_format($summary['guest_visits']) }}</div>
                        <div class="stat-trending {{ $summary['guest_growth'] >= 0 ? 'up' : 'down' }}">{{ $trend($summary['guest_growth']) }}</div>
                    </div>
                </div>

                <div class="stat-card rating">
                    <div class="stat-label">Tổng đặt phòng</div>
                    <div class="stat-value-group">
                        <div class="stat-value">{{ number_format($summary['bookings_count']) }}</div>
                        <div class="stat-trending up">Live</div>
                    </div>
                </div>
            </div>

            <div class="charts-row">
                <div class="chart-card">
                    <div class="chart-header">
                        <div class="chart-title-group">
                            <h3>Doanh thu theo ngày</h3>
                            <p>Dữ liệu thực tế trong khoảng lọc</p>
                        </div>
                        <div class="chart-legend">
                            <div class="legend-item"><span class="legend-dot" style="background:#f0642f;"></span> Doanh thu</div>
                        </div>
                    </div>
                    <div class="chart-mock" style="height: 250px; position:relative; margin-top:20px;">
                        <svg width="100%" height="100%" viewBox="0 0 600 200" preserveAspectRatio="none">
                            <defs>
                                <linearGradient id="gradRevenue" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" style="stop-color:#f0642f;stop-opacity:0.2" />
                                    <stop offset="100%" style="stop-color:#f0642f;stop-opacity:0" />
                                </linearGradient>
                            </defs>
                            <path d="{{ $report['line_chart']['area_path'] }}" fill="url(#gradRevenue)" />
                            <path d="{{ $report['line_chart']['path'] }}" fill="transparent" stroke="#f0642f" stroke-width="3" />
                        </svg>
                        <div style="display:flex; justify-content:space-between; margin-top:10px; font-size:11px; color:#94a3b8;">
                            @foreach($report['daily_revenue']->values() as $point)
                                @if($loop->first || $loop->last || $loop->index % $labelStep === 0)
                                    <span>{{ $point['label'] }}</span>
                                @endif
                            @endforeach
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
                            @foreach($report['revenue_mix'] as $item)
                                <circle class="donut-ring" cx="50" cy="50" r="40" fill="transparent" stroke="{{ $item['color'] }}" stroke-width="12" stroke-dasharray="{{ $item['dasharray'] }}" stroke-dashoffset="{{ $item['dashoffset'] }}"/>
                            @endforeach
                        </svg>
                        <div class="doughnut-center">
                            <span class="doughnut-percent">100%</span>
                            <span class="doughnut-label">Total</span>
                        </div>
                    </div>
                    <div class="revenue-mix-list">
                        @foreach($report['revenue_mix'] as $item)
                            <div class="mix-item">
                                <div class="mix-label-group"><span class="legend-dot" style="background:{{ $item['color'] }};"></span> {{ $item['label'] }}</div>
                                <div class="mix-val">{{ $item['percent'] }}%</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="activities-card">
                <div class="activities-header">
                    <h3>Hoạt động gần đây</h3>
                    <a href="{{ route('admin.bookings.index') }}" class="btn-view-all">Xem tất cả</a>
                </div>
                <div class="activities-list">
                    @forelse($report['activities'] as $activity)
                        <div class="activity-item">
                            <div class="activity-icon" style="background:{{ $activity['color'] }}1a; color:{{ $activity['color'] }};">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                            </div>
                            <div class="activity-info">
                                <div class="activity-title">{{ $activity['title'] }}</div>
                                <div class="activity-desc">{{ $activity['description'] }}</div>
                            </div>
                            <div class="activity-time">{{ $activity['time'] }}</div>
                        </div>
                    @empty
                        <div class="activity-item">
                            <div class="activity-info">
                                <div class="activity-title">Chưa có hoạt động trong hệ thống</div>
                                <div class="activity-desc">Dữ liệu sẽ xuất hiện khi có đặt phòng.</div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            @include('admin.layouts.footer')
        </div>
    </main>
</div>
@endsection
