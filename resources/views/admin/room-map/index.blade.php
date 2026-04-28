@extends('admin.layouts.master')
@section('title', 'Sơ đồ phòng | Urban Luxe')

@section('content')
    <div style="display:flex; height:100vh; background:#f5f6fa;">

        {{-- SIDEBAR --}}
        @include('admin.layouts.sidebar')

        {{-- MAIN CONTENT --}}
        <main style="flex:1; display:flex; flex-direction:column; overflow:hidden;">

            {{-- HEADER --}}
            @include('admin.layouts.header')

            {{-- ROOM MAP WRAPPER --}}
            <div class="rm-wrapper">

                {{-- TRẠNG THÁI (FILTERS) --}}
                <div class="rm-filters">
                    @foreach ($statusMeta as $statusValue => $meta)
                        @php
                            $queryFilters = array_merge($filters, ['status' => $statusValue]);
                            $isActive = $activeStatus === $statusValue;
                        @endphp
                        <a
                            href="{{ route('admin.room-map.index', ['filters' => $queryFilters]) }}"
                            class="rm-filter-btn {{ $meta['badge'] }} {{ $isActive ? 'active' : '' }}"
                            style="text-decoration:none;"
                        >
                            <span class="rm-dot"></span> {{ $meta['label'] }} ({{ $roomStatusCounts[$statusValue] ?? 0 }})
                        </a>
                    @endforeach
                    <a
                        href="{{ route('admin.room-map.index', ['filters' => $filtersWithoutStatus]) }}"
                        class="rm-filter-btn"
                        style="border: 1px solid #cbd5e1; color: #475569; text-decoration:none;"
                    >
                        Tất cả ({{ $totalRooms }})
                    </a>
                </div>

                {{-- TOOLBAR --}}
                <div class="rm-toolbar">
                    <div class="rm-toolbar-left">
                        <div class="rm-toggle-group">
                            <a
                                href="{{ route('admin.room-map.index', ['filters' => array_merge($filters, ['group_by' => 'room_type'])]) }}"
                                class="rm-toggle-btn {{ $groupBy === 'room_type' ? 'active' : '' }}"
                                style="text-decoration:none;"
                            >
                                Loại phòng
                            </a>
                            <a
                                href="{{ route('admin.room-map.index', ['filters' => array_merge($filters, ['group_by' => 'floor'])]) }}"
                                class="rm-toggle-btn {{ $groupBy === 'floor' ? 'active' : '' }}"
                                style="text-decoration:none;"
                            >
                                Tầng
                            </a>
                        </div>
                        <form method="GET" action="{{ route('admin.room-map.index') }}" class="rm-date-picker">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            @foreach ($filtersWithoutDate as $filterKey => $filterValue)
                                <input type="hidden" name="filters[{{ $filterKey }}]" value="{{ $filterValue }}">
                            @endforeach
                            <input type="date" name="filters[date_from]" value="{{ $filters['date_from'] ?? '' }}" aria-label="Ngày bắt đầu">
                            <input type="date" name="filters[date_to]" value="{{ $filters['date_to'] ?? '' }}" aria-label="Ngày kết thúc">
                            <button type="submit" class="rm-toggle-btn" style="height:32px;">Lọc</button>
                            <a
                                href="{{ route('admin.room-map.index', ['filters' => ['group_by' => $groupBy]]) }}"
                                class="rm-toggle-btn"
                                style="height:32px; text-decoration:none; display:inline-flex; align-items:center;"
                            >
                                Xóa bộ lọc
                            </a>
                        </form>
                    </div>
                    <div class="rm-search">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <form method="GET" action="{{ route('admin.room-map.index') }}">
                            @foreach ($filtersWithoutSearch as $filterKey => $filterValue)
                                <input type="hidden" name="filters[{{ $filterKey }}]" value="{{ $filterValue }}">
                            @endforeach
                            <input type="text" name="filters[search]" value="{{ $filters['search'] ?? '' }}" placeholder="Tìm tên/phòng...">
                        </form>
                    </div>
                </div>

                @forelse ($groups as $groupItem)
                    <div class="rm-group">
                        <div class="rm-group-header">
                            <span class="rm-group-title">{{ $groupItem['name'] }}</span>
                            <span class="rm-group-count">{{ $groupItem['count'] }}</span>
                        </div>

                        <div class="rm-grid">
                            @foreach ($groupItem['rooms'] as $roomCard)
                                <a href="{{ route($roomCard['route_name'], ['id' => $roomCard['id']]) }}" style="text-decoration:none; color:inherit;">
                                    <div class="rm-card {{ $roomCard['card_class'] }}" style="cursor:pointer;">
                                        <div class="rm-card-header" style="margin-bottom:0;">
                                            <div>
                                                <span class="rm-card-room">{{ $roomCard['name'] }}</span>
                                                <span class="rm-card-type">{{ $roomCard['room_type_code'] }}</span>
                                            </div>
                                            @if ($roomCard['show_indicator'])
                                                <span class="rm-card-indicator"></span>
                                            @endif
                                        </div>

                                        @if ($roomCard['is_empty'])
                                            <div class="rm-card-body">
                                                <div class="check-circle">
                                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                                </div>
                                                <div class="status-text">TRỐNG</div>
                                            </div>
                                        @else
                                            <div class="rm-guest-name">{{ $roomCard['guest_name'] ?: $roomCard['status_label'] }}</div>
                                            @if ($roomCard['is_confirmed'] ?? false)
                                                <div class="rm-confirmed-pill">
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                                    <span>{{ $roomCard['status_label'] }}</span>
                                                </div>
                                            @endif
                                            @if (in_array($roomCard['status'], ['booked', 'confirmed', 'incoming']) && ($roomCard['checkin_at'] || $roomCard['checkout_at']))
                                                <div class="rm-time-row">
                                                    <span>CI: {{ $roomCard['checkin_at'] ?? '--' }}</span>
                                                    <span>CO: {{ $roomCard['checkout_at'] ?? '--' }}</span>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="rm-group">
                        <div class="rm-group-header">
                            <span class="rm-group-title">KHÔNG CÓ DỮ LIỆU</span>
                            <span class="rm-group-count">0</span>
                        </div>
                    </div>
                @endforelse

            </div>

                @include('admin.layouts.footer') 
        </main>
    </div>

    @vite('resources/css/admin/room-map.css')

@endsection
