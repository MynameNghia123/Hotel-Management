@extends('admin.layouts.master')

@section('title', 'Chi tiết loại phòng: {{ $roomType->name }} | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/room-types.css')
@endpush

@section('content')
<div class="admin-layout">
    @include('admin.layouts.sidebar')

    <main class="admin-main">
        @include('admin.layouts.header')

        {{-- MAIN CONTENT AREA --}}
        <div class="admin-content">
            
            {{-- PAGE HEADER ACTIONS --}}
            <div class="page-actions-header">
                <div class="header-titles">
                    <a href="{{ route('admin.rooms.index') }}" class="back-text">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        Trở lại danh sách
                    </a>
                    <h1 class="main-title">Chi tiết loại phòng: {{ $roomType->name }}</h1>
                    <p class="sub-desc">Mã phòng: <strong>{{ $roomType->code }}</strong> &mdash; Hệ thống quản trị khách sạn Urban Luxe</p>
                </div>
                <div class="right-badges">
                    <div class="view-only-badge">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        Chế độ xem chi tiết (View Only)
                    </div>
                    <a href="{{ route('admin.rooms.edit', $roomType->id) }}" class="btn-primary-blue" style="text-decoration:none;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        Chỉnh sửa
                    </a>
                </div>
            </div>

            <div class="details-grid-layout">
                {{-- LEFT: Main Information --}}
                <div class="details-col-left">
                    
                    {{-- THÔNG TIN CHUNG --}}
                    <div class="details-card">
                        <h3 class="card-section-title">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                            THÔNG TIN CHUNG
                        </h3>
                        <div class="info-split">
                            <div class="info-block">
                                <label>TÊN LOẠI PHÒNG</label>
                                <strong>{{ $roomType->name }}</strong>
                            </div>
                            <div class="info-block">
                                <label>MÃ LOẠI PHÒNG</label>
                                <strong>{{ $roomType->code }}</strong>
                            </div>
                        </div>
                        <div class="info-block" style="margin-top: 15px;">
                            <label>TRẠNG THÁI</label>
                            @if($roomType->is_active)
                                <span class="status-pill-green">Đang kinh doanh</span>
                            @else
                                <span class="status-pill-red">Ngừng kinh doanh</span>
                            @endif
                        </div>
                        <div class="info-block" style="margin-top: 20px;">
                            <label>MÔ TẢ LOẠI PHÒNG</label>
                            <div class="desc-content-box">
                                {{ $roomType->description ?? 'Chưa có mô tả.' }}
                            </div>
                        </div>
                    </div>

                    {{-- KÍCH THƯỚC & GIÁ --}}
                    <div class="details-card">
                        <h3 class="card-section-title">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0110 0v4"></path></svg>
                            KÍCH THƯỚC & GIÁ
                        </h3>
                        <div class="pricing-container">
                            <div class="dimension-box">
                                <label>KÍCH THƯỚC</label>
                                <div class="dim-flex">
                                    <div class="dim-item">
                                        Rộng (Width) <br>
                                        <strong>{{ $roomType->width }} m</strong>
                                    </div>
                                    <div class="dim-divider"></div>
                                    <div class="dim-item">
                                        Dài (Length) <br>
                                        <strong>{{ $roomType->height }} m</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="price-side">
                                <div class="price-row">
                                    <span>Giá giờ (Hourly)</span>
                                    <div class="price-val">{{ number_format($roomType->hourly_price, 0, ',', '.') }} <small>VNĐ</small></div>
                                </div>
                                <div class="price-row">
                                    <span>Giá ngày (Daily)</span>
                                    <div class="price-val">{{ number_format($roomType->daily_price, 0, ',', '.') }} <small>VNĐ</small></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SỨC CHỨA --}}
                    <div class="details-card">
                        <h3 class="card-section-title">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                            SỨC CHỨA
                        </h3>
                        <div class="capacity-cards-grid">
                            <div class="cap-card">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <span>Người lớn</span>
                                <strong>{{ $roomType->adult_quantity }}</strong>
                            </div>
                            <div class="cap-card">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path><circle cx="12" cy="7" r="1.5"></circle><circle cx="12" cy="7" r="4"></circle></svg>
                                <span>Trẻ em</span>
                                <strong>{{ $roomType->child_quantity }}</strong>
                            </div>
                            <div class="cap-card">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 17v-4M17 17v-4M3 8v9M21 8v9M3 11h18M5 8h14a2 2 0 012 2v1h-18v-1a2 2 0 012-2z"/></svg>
                                <span>Giường đơn</span>
                                <strong>{{ $roomType->single_bed_quantity }}</strong>
                            </div>
                            <div class="cap-card">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="8" rx="2"/><path d="M7 11V7a2 2 0 012-2h6a2 2 0 012 2v4M11 11v4"/></svg>
                                <span>Giường đôi</span>
                                <strong>{{ $roomType->double_bed_quantity }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT: Media & Components --}}
                <div class="details-col-right">
                    
                    {{-- MEDIA (HÌNH ẢNH) --}}
                    <div class="details-card">
                        <div class="card-top-flex">
                            <h3 class="card-section-title">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"></polyline></svg>
                                MEDIA (HÌNH ẢNH)
                            </h3>
                        </div>
                        <div class="media-list">
                            @forelse($roomType->images as $image)
                                <div class="media-item {{ $loop->first ? 'border-left-active' : '' }}">
                                    <img src="{{ $image->image_url }}" alt="Room image {{ $loop->iteration }}">
                                    <div class="media-info">
                                        <strong>Ảnh {{ $loop->iteration }}</strong>
                                        <span>Thứ tự: {{ $image->order }}</span>
                                    </div>
                                </div>
                            @empty
                                <p style="color:#94a3b8; font-size:13px;">Chưa có hình ảnh nào.</p>
                            @endforelse
                        </div>
                        <p class="media-total">Tổng: {{ $roomType->images->count() }} hình ảnh</p>
                    </div>

                    {{-- TIỆN ÍCH (AMENITIES) --}}
                    <div class="details-card">
                        <h3 class="card-section-title">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 21l-8-4.5v-9L12 3l8 4.5v9z"></path><polyline points="12 21 12 12 20 7.5"></polyline><line x1="12" y1="12" x2="4" y2="7.5"></line></svg>
                            TIỆN ÍCH (AMENITIES)
                        </h3>
                        <div class="amenities-flex">
                            @forelse($roomType->amenities as $amenity)
                                <div class="amenity-pill">
                                    <span class="material-symbols-outlined" style="font-size:16px;">{{ strtolower(trim($amenity->icon)) }}</span>
                                    {{ $amenity->name }}
                                </div>
                            @empty
                                <p style="color:#94a3b8; font-size:13px;">Chưa có tiện ích nào.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- THIẾT BỊ (ROOM EQUIPMENT) --}}
                    <div class="details-card">
                        <h3 class="card-section-title">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/></svg>
                            THIẾT BỊ (ROOM EQUIPMENT)
                        </h3>
                        <table class="equip-table">
                            <thead>
                                <tr>
                                    <th>TÊN THIẾT BỊ</th>
                                    <th>SL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roomType->equipments as $equipment)
                                    <tr>
                                        <td>{{ $equipment->name }}</td>
                                        <td class="qty-num">{{ $equipment->pivot->quantity }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" style="text-align:center; color:#94a3b8;">Chưa có thiết bị nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        {{-- FOOTER --}}
        @include('admin.layouts.footer')

    </main>
</div>
@endsection
