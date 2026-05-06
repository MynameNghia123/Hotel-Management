@extends('admin.layouts.master')

@section('title', 'Thống kê Hiệu suất phòng | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/statistical.css')
    @vite('resources/css/admin/statisical-room-efficiency.css')
@endpush

@section('content')
@php
    $range = $report['range'];
    $metrics = $report['metrics'];
    $moneyCompact = fn ($value) => round((float) $value / 1000000, 1) . 'M';
@endphp

<div class="admin-layout">
    @include('admin.layouts.sidebar')

    <main class="admin-main">
        @include('admin.layouts.header')

        <div class="admin-content">
            <div class="stats-title-group">
                <h1 class="stats-title">Thống kê Hiệu suất phòng</h1>
                <p class="stats-date">{{ $report['generated_at'] }} · {{ $range['label'] }}</p>
            </div>

            <nav class="stats-tabs">
                <a href="{{ route('admin.statistical.index') }}" class="stats-tab {{ request()->routeIs('admin.statistical.index') ? 'active' : '' }}" style="text-decoration: none;">Tổng quan</a>
                <a href="{{ route('admin.statistical.revenue') }}" class="stats-tab {{ request()->routeIs('admin.statistical.revenue') ? 'active' : '' }}" style="text-decoration: none;">Doanh thu</a>
                <a href="{{ route('admin.statistical.room-efficiency') }}" class="stats-tab {{ request()->routeIs('admin.statistical.room-efficiency') ? 'active' : '' }}" style="text-decoration: none;">Hiệu suất phòng</a>
                <a href="{{ route('admin.statistical.customers') }}" class="stats-tab {{ request()->routeIs('admin.statistical.customers') ? 'active' : '' }}" style="text-decoration: none;">Khách hàng</a>
            </nav>

            <form method="GET" action="{{ route('admin.statistical.room-efficiency') }}" class="eff-filters">
                <div class="eff-filter-group">
                    <span class="eff-label">Từ ngày</span>
                    <input type="date" class="eff-date-input" name="start_date" value="{{ $range['start_date'] }}">
                </div>
                <div class="eff-filter-group">
                    <span class="eff-label">Đến ngày</span>
                    <input type="date" class="eff-date-input" name="end_date" value="{{ $range['end_date'] }}">
                </div>
                <div class="eff-filter-group">
                    <span class="eff-label">Loại phòng</span>
                    <select class="eff-select" name="room_type_id">
                        <option value="">Tất cả loại phòng</option>
                        @foreach($report['room_types'] as $roomType)
                            <option value="{{ $roomType->id }}" {{ $report['filters']['room_type_id'] === $roomType->id ? 'selected' : '' }}>
                                {{ $roomType->name }} ({{ $roomType->code }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <button class="eff-btn-filter" type="submit">Lọc dữ liệu</button>
            </form>

            <div class="eff-stats-grid">
                <div class="eff-card">
                    <div class="eff-card-title">Hiệu suất phòng (%)</div>
                    <div class="eff-card-val-row">
                        <div class="eff-card-val">{{ $metrics['occupancy_rate'] }}%</div>
                        <div class="{{ $metrics['occupancy_growth'] >= 0 ? 'eff-card-plus' : 'eff-card-minus' }}">{{ $metrics['occupancy_growth'] >= 0 ? '+' : '' }}{{ $metrics['occupancy_growth'] }}%</div>
                    </div>
                    <div class="eff-progress-container">
                        <div class="eff-progress-bar" style="width: {{ min(100, $metrics['occupancy_rate']) }}%"></div>
                    </div>
                </div>

                <div class="eff-card">
                    <div class="eff-card-title">Tổng số đặt phòng</div>
                    <div class="eff-card-val-row">
                        <div class="eff-card-val">{{ number_format($metrics['booking_count']) }}</div>
                    </div>
                    <div class="eff-card-footer">
                        <span>{{ $range['label'] }}</span>
                    </div>
                </div>

                <div class="eff-card">
                    <div class="eff-card-title">Đêm phòng đã bán</div>
                    <div class="eff-card-val-row">
                        <div class="eff-card-val">{{ number_format($metrics['occupied_room_nights']) }}</div>
                    </div>
                    <div class="eff-card-footer">
                        <span>/ {{ number_format($metrics['available_room_nights']) }} đêm phòng khả dụng</span>
                    </div>
                </div>

                <div class="eff-card">
                    <div class="eff-card-title">Doanh thu dự kiến</div>
                    <div class="eff-card-val-row">
                        <div class="eff-card-val">{{ $moneyCompact($metrics['estimated_revenue']) }}</div>
                        <span style="font-size:11px; font-weight:700; color:#94a3b8; margin-left:4px;">VNĐ</span>
                    </div>
                    <div class="eff-card-footer">
                        <span>Theo khoảng lọc</span>
                    </div>
                </div>
            </div>

            <div class="eff-row">
                <div class="eff-status-card">
                    <div class="eff-status-header">
                        <h3>Trạng thái phòng hiện tại</h3>
                        <a href="{{ route('admin.room-map.index') }}" style="font-size: 13px; font-weight: 700; color: #2a3f8a; text-decoration: none;">Xem chi tiết</a>
                    </div>
                    <div style="display:flex; align-items:center; justify-content:space-around; padding: 20px 0;">
                        <div class="doughnut-wrapper" style="width: 220px; height: 220px; margin: 0;">
                            <svg class="doughnut-svg" width="220" height="220" viewBox="0 0 100 100">
                                @php $offset = 0; $circumference = 251.2; @endphp
                                @foreach($report['room_status']['items'] as $item)
                                    @php
                                        $length = $report['room_status']['total'] > 0 ? round(($item['count'] / $report['room_status']['total']) * $circumference, 1) : 0;
                                        $dash = $length . ' ' . round($circumference - $length, 1);
                                    @endphp
                                    <circle class="donut-ring" cx="50" cy="50" r="40" fill="transparent" stroke="{{ $item['color'] }}" stroke-width="12" stroke-dasharray="{{ $dash }}" stroke-dashoffset="{{ -$offset }}"/>
                                    @php $offset += $length; @endphp
                                @endforeach
                            </svg>
                            <div class="doughnut-center" style="transform: translate(-50%, -60%);">
                                <span class="doughnut-percent" style="font-size: 28px;">{{ $report['room_status']['total'] }}</span>
                                <span class="doughnut-label" style="font-size: 9px; opacity:0.7;">TỔNG SỐ PHÒNG</span>
                            </div>
                        </div>
                        <div style="display:flex; flex-direction:column; gap:16px;">
                            @foreach($report['room_status']['items'] as $item)
                                <div style="display:flex; align-items:center; gap:12px;">
                                    <span style="width:10px; height:10px; border-radius:3px; background:{{ $item['color'] }};"></span>
                                    <span style="font-size: 13px; font-weight: 700; color:#64748b; width:100px;">{{ $item['label'] }}:</span>
                                    <span style="font-size: 14px; font-weight: 800; color:#1e293b;">{{ $item['count'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="eff-status-card">
                    <div class="eff-status-header">
                        <h3>Loại phòng được đặt nhiều nhất</h3>
                    </div>
                    <div class="progress-list">
                        @forelse($report['top_room_types'] as $roomType)
                            <div class="progress-item">
                                <div class="progress-label-row">
                                    <span>{{ strtoupper($roomType['name']) }} ({{ $roomType['code'] }})</span>
                                    <span>{{ $roomType['bookings_count'] }} <span class="progress-unit">Lượt</span></span>
                                </div>
                                <div class="eff-progress-container" style="height: 10px;">
                                    <div class="eff-progress-bar" style="width: {{ $roomType['percent'] }}%; background:{{ $roomType['color'] }};"></div>
                                </div>
                            </div>
                        @empty
                            <div class="progress-item">
                                <div class="progress-label-row">
                                    <span>Chưa có dữ liệu đặt phòng</span>
                                    <span>0 <span class="progress-unit">Lượt</span></span>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="eff-table-card">
                <div class="table-header-group">
                    <h3 class="table-title">Chi tiết trạng thái phòng</h3>
                </div>
                <table class="eff-table">
                    <thead>
                        <tr>
                            <th>Mã phòng</th>
                            <th>Loại phòng</th>
                            <th>Tầng</th>
                            <th>Tỉ lệ lấp đầy</th>
                            <th>Trạng thái hiện tại</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($report['room_rows'] as $room)
                            <tr>
                                <td>{{ $room['room_name'] }}</td>
                                <td>{{ $room['room_type'] }}</td>
                                <td>{{ $room['floor'] }}</td>
                                <td>
                                    <div style="display:flex; align-items:center; gap:10px;">
                                        <span style="font-size:12px; color:#64748b; font-weight:700; width:40px;">{{ $room['occupancy_rate'] }}%</span>
                                        <div class="eff-progress-container" style="flex:1;">
                                            <div class="eff-progress-bar" style="width: {{ $room['occupancy_rate'] }}%; background:{{ $room['progress_color'] }};"></div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="eff-badge {{ $room['badge_class'] }}">{{ $room['status_label'] }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center; color:#94a3b8;">Không có phòng phù hợp với bộ lọc.</td>
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
