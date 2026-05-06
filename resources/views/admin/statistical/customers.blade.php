@extends('admin.layouts.master')

@section('title', 'Thống kê Khách hàng | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/statistical.css')
    @vite('resources/css/admin/statisical-customers.css')
@endpush

@section('content')
@php
    $summary = $report['summary'];
    $range = $report['range'];
    $trend = fn ($value) => ($value >= 0 ? '+' : '') . $value . '%';
    $trendClass = fn ($value) => $value >= 0 ? 'up' : 'stable';
@endphp

<div class="admin-layout">
    @include('admin.layouts.sidebar')

    <main class="admin-main">
        @include('admin.layouts.header')

        <div class="admin-content">
            <div class="stats-title-group" style="display:flex; justify-content:space-between; align-items:flex-end;">
                <div>
                    <h1 class="stats-title">Thống kê Khách hàng</h1>
                    <p class="stats-date" style="text-transform: none; letter-spacing: 0;">{{ $report['generated_at'] }} · {{ $range['label'] }}</p>
                </div>
            </div>

            <nav class="stats-tabs">
                <a href="{{ route('admin.statistical.index') }}" class="stats-tab {{ request()->routeIs('admin.statistical.index') ? 'active' : '' }}" style="text-decoration: none;">Tổng quan</a>
                <a href="{{ route('admin.statistical.revenue') }}" class="stats-tab {{ request()->routeIs('admin.statistical.revenue') ? 'active' : '' }}" style="text-decoration: none;">Doanh thu</a>
                <a href="{{ route('admin.statistical.room-efficiency') }}" class="stats-tab {{ request()->routeIs('admin.statistical.room-efficiency') ? 'active' : '' }}" style="text-decoration: none;">Hiệu suất phòng</a>
                <a href="{{ route('admin.statistical.customers') }}" class="stats-tab {{ request()->routeIs('admin.statistical.customers') ? 'active' : '' }}" style="text-decoration: none;">Khách hàng</a>
            </nav>

            <form method="GET" action="{{ route('admin.statistical.customers') }}" class="cust-filters">
                <input type="date" class="cust-filter-input" name="start_date" value="{{ $range['start_date'] }}">
                <input type="date" class="cust-filter-input" name="end_date" value="{{ $range['end_date'] }}">
                <button class="cust-btn-filter" type="submit">Lọc kết quả</button>
            </form>

            <div class="cust-stats-grid">
                <div class="cust-card">
                    <div class="cust-card-title">Tổng lượt khách</div>
                    <div class="cust-card-val">{{ number_format($summary['total_visits']) }}</div>
                    <div class="cust-card-trend {{ $trendClass($summary['total_visits_growth']) }}">
                        {{ $trend($summary['total_visits_growth']) }} so với kỳ trước
                    </div>
                </div>

                <div class="cust-card">
                    <div class="cust-card-title">Khách hàng mới</div>
                    <div class="cust-card-val">{{ number_format($summary['new_customers']) }}</div>
                    <div class="cust-card-trend {{ $trendClass($summary['new_customers_growth']) }}">
                        {{ $trend($summary['new_customers_growth']) }} so với kỳ trước
                    </div>
                </div>

                <div class="cust-card">
                    <div class="cust-card-title">Tỉ lệ quay lại</div>
                    <div class="cust-card-val">{{ $summary['returning_rate'] }}%</div>
                    <div class="cust-card-trend stable">
                        {{ number_format($summary['total_customers']) }} khách duy nhất
                    </div>
                </div>

                <div class="cust-card">
                    <div class="cust-card-title">Khách thân thiết</div>
                    <div class="cust-card-val">{{ number_format($report['loyal_customers']->count()) }}</div>
                    <div class="cust-card-trend stable">
                        Theo chi tiêu trong kỳ
                    </div>
                </div>
            </div>

            <div class="loyal-card">
                <div class="loyal-header">
                    <h3>Khách hàng Thân thiết (Loyal Customers)</h3>
                    <a href="{{ route('admin.customers.index') }}" style="font-size: 13px; font-weight: 700; color: #2a3f8a; text-decoration: none;">Xem tất cả</a>
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
                        @forelse($report['loyal_customers'] as $customer)
                            @php
                                $fullName = trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? '')) ?: 'Khách hàng';
                            @endphp
                            <tr>
                                <td>
                                    <div class="cust-info-cell">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($fullName) }}&background=0284c7&color=fff" class="cust-avatar" alt="{{ $fullName }}">
                                        <div class="cust-details">
                                            <div class="cust-name">{{ $fullName }}</div>
                                            <div class="cust-email">{{ $customer->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="visit-count">{{ number_format($customer->visits_count) }} lượt</span></td>
                                <td><span class="spending-val">{{ number_format($customer->total_spending, 0, ',', '.') }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align:center; color:#94a3b8;">Chưa có dữ liệu khách hàng trong khoảng lọc.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @include('admin.layouts.footer')
        </div>
    </main>
</div>
@endsection
