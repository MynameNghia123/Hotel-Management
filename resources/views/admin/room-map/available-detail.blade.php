@extends('admin.layouts.master')
@section('title', 'Phòng trống | Urban Luxe')

@section('content')
<div style="display:flex; height:100vh; background:#f8f9fb; overflow:hidden;">

    {{-- SIDEBAR --}}
    @include('admin.layouts.sidebar')

    {{-- MAIN CONTENT --}}
    <main style="flex:1; display:flex; flex-direction:column; overflow:hidden;">

        {{-- HEADER CHUNG CỦA ADMIN --}}
        @include('admin.layouts.header')

        {{-- KHU VỰC CHI TIẾT PHÒNG TRỐNG --}}
        <div class="ra-wrapper">
            
            <a href="{{ route('admin.room-map.index') }}" class="ra-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="15" y1="18" x2="9" y2="12"></line><line x1="15" y1="6" x2="9" y2="12"></line></svg>
                Quay lại sơ đồ phòng
            </a>

            <div class="ra-header-box">
                <h1 class="ra-title">
                    Phòng {{ $room->name ?? '--' }} - {{ $roomType->name ?? 'N/A' }}
                </h1>
                <div class="ra-subtitle">Cung cấp thông tin chi tiết để quản lý phòng Urban Luxe hiệu quả hơn.</div>
            </div>

            <div class="ra-panel">
                
                <div class="ra-status-row">
                    <span class="ra-status-title">TÌNH TRẠNG PHÒNG</span>
                    <span class="ra-status-badge">Available</span>
                </div>

                <div class="ra-info-grid">
                    <div class="ra-info-box">
                        <div class="ra-info-label">DIỆN TÍCH</div>
                        <div class="ra-info-val">{{ number_format((float) (($roomType->width ?? 0) * ($roomType->height ?? 0)), 2) }} <span>m²</span></div>
                    </div>
                    <div class="ra-info-box">
                        <div class="ra-info-label">LOẠI GIƯỜNG</div>
                        <div class="ra-info-val">{{ $bedDescription }}</div>
                    </div>
                </div>

                <div class="ra-price-row">
                    <span>Giá theo giờ</span>
                    <span class="ra-price-val">{{ number_format((float) ($roomType->hourly_price ?? 0), 0, ',', '.') }} đ</span>
                </div>
                <div class="ra-price-row">
                    <span>Giá theo ngày</span>
                    <span class="ra-price-val">{{ number_format((float) ($roomType->daily_price ?? 0), 0, ',', '.') }} đ</span>
                </div>

                <div class="ra-amenities-group">
                    <div class="ra-am-title">TRANG THIẾT BỊ</div>
                    <div class="ra-am-list">
                        @forelse($facilityNames as $facilityName)
                            <div class="ra-am-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="15" rx="2" ry="2"/></svg>
                                {{ $facilityName }}
                            </div>
                        @empty
                            <div class="ra-am-item">Chưa có dữ liệu trang thiết bị</div>
                        @endforelse

                    </div>
                </div>

            </div>

        </div>
    </main>
</div>

@vite('resources/css/admin/room-available.css')

@endsection
