@extends('admin.layouts.master')
@section('title', 'Phòng trống | Urban Luxe')

@section('content')
<div style="display:flex; height:100vh; background:#f8f9fb; overflow:hidden;">

    {{-- SIDEBAR --}}
    @include('admin.layouts.sidebar')

    {{-- MAIN CONTENT --}}
    <main style="flex:1; display:flex; flex-direction:column; overflow:hidden;">

        {{-- HEADER CHUNG CỦA ADMIN --}}
        <header style="height:64px; background:#fff; border-bottom:1px solid #f1f3f7; padding:0 32px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <div style="display:flex; align-items:center; gap:8px; font-size:14px; font-weight:600; color:#1e293b;">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 21v-6h6v6"/></svg>
                16819 · Urban Luxe Hotel
            </div>
            <div style="display:flex; align-items:center; gap:18px;">
                <button style="position:relative; width:36px; height:36px; border:none; background:transparent; display:flex; align-items:center; justify-content:center; color:#94a3b8; cursor:pointer;">
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg>
                    <span style="position:absolute; top:6px; right:6px; width:8px; height:8px; background:#ef4444; border-radius:50%; border:2px solid #fff;"></span>
                </button>
                <div style="display:flex; align-items:center; gap:10px;">
                    <div style="text-align:right;">
                        <div style="font-size:13px; font-weight:700; color:#1e293b;">Admin Đức</div>
                        <div style="font-size:11px; color:#94a3b8;">Quản lý cấp cao</div>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=Admin+Duc&background=2a3f8a&color=fff" style="width:36px; height:36px; border-radius:50%;">
                </div>
            </div>
        </header>

        {{-- KHU VỰC CHI TIẾT PHÒNG TRỐNG --}}
        <div class="ra-wrapper">
            
            <a href="{{ route('admin.room-map.index') }}" class="ra-back">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="15" y1="18" x2="9" y2="12"></line><line x1="15" y1="6" x2="9" y2="12"></line></svg>
                Quay lại sơ đồ phòng
            </a>

            <div class="ra-header-box">
                <h1 class="ra-title">Phòng 401 - Deluxe</h1>
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
                        <div class="ra-info-val">35 <span>m²</span></div>
                    </div>
                    <div class="ra-info-box">
                        <div class="ra-info-label">LOẠI GIƯỜNG</div>
                        <div class="ra-info-val">King Size</div>
                    </div>
                </div>

                <div class="ra-price-row">
                    <span>Giá theo giờ</span>
                    <span class="ra-price-val">250.000 đ</span>
                </div>
                <div class="ra-price-row">
                    <span>Giá theo ngày</span>
                    <span class="ra-price-val">1.200.000 đ</span>
                </div>

                <div class="ra-amenities-group">
                    <div class="ra-am-title">TRANG THIẾT BỊ</div>
                    <div class="ra-am-list">
                        
                        {{-- Tiện ích 1 --}}
                        <div class="ra-am-item">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="15" rx="2" ry="2"/><polyline points="17 2 12 7 7 2"/></svg>
                            Smart TV 4K
                        </div>

                        {{-- Tiện ích 2 --}}
                        <div class="ra-am-item">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="5" y1="10" x2="19" y2="10"/><line x1="9" y1="14" x2="9" y2="14.01"/><line x1="9" y1="6" x2="9" y2="6.01"/></svg>
                            Tủ lạnh mini
                        </div>

                        {{-- Tiện ích 3 --}}
                        <div class="ra-am-item">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="6" width="16" height="6" rx="2" ry="2"/><path d="M7 16v3"/><path d="M11 16v3"/><path d="M15 16v3"/><path d="M12 2A4 4 0 0 0 8 6"/></svg>
                            Điều hòa 2 chiều
                        </div>

                        {{-- Tiện ích 4 --}}
                        <div class="ra-am-item">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/></svg>
                            High Speed WiFi
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </main>
</div>

@vite('resources/css/admin/room-available.css')

@endsection
