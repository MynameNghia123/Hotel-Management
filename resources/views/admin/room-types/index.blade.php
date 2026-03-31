@extends('admin.layouts.master')

@section('title', 'Chi tiết loại phòng: Urban Suite King | Urban Luxe Admin')

@push('styles')
    @vite('resources/css/admin/room-types.css')
@endpush

@section('content')
<div class="admin-layout">
    @include('admin.layouts.sidebar')

    <main class="admin-main">
        {{-- HEADER TOP BAR --}}
        <header class="admin-header">
            <div class="header-left">
                <span class="work-date">NGÀY LÀM VIỆC: <strong>24 Tháng 05, 2024</strong></span>
            </div>
            <div class="header-right">
                <button class="notif-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg>
                    <span class="dot"></span>
                </button>
                <div class="user-profile">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=2a3f8a&color=fff" alt="User">
                </div>
            </div>
        </header>

        {{-- MAIN CONTENT AREA --}}
        <div class="admin-content">
            
            {{-- PAGE HEADER ACTIONS --}}
            <div class="page-actions-header">
                <div class="header-titles">
                    <a href="{{ route('admin.rooms.index') }}" class="back-text">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        Trở lại danh sách
                    </a>
                    <h1 class="main-title">Chi tiết loại phòng: Urban Suite King</h1>
                    <p class="sub-desc">Hệ thống quản trị khách sạn Urban Luxe</p>
                </div>
                <div class="right-badges">
                    <div class="view-only-badge">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        Chế độ xem chi tiết (View Only)
                    </div>
                    <button class="btn-cancel">Quay lại</button>
                    <button class="btn-primary-blue">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        Chỉnh sửa
                    </button>
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
                                <strong>Urban Suite King</strong>
                            </div>
                            <div class="info-block">
                                <label>MÃ LOẠI PHÒNG</label>
                                <strong>USK-590</strong>
                            </div>
                        </div>
                        <div class="info-block" style="margin-top: 15px;">
                            <label>TRẠNG THÁI</label>
                            <span class="status-pill-green">Đang kinh doanh</span>
                        </div>
                        <div class="info-block" style="margin-top: 20px;">
                            <label>MÔ TẢ LOẠI PHÒNG</label>
                            <div class="desc-content-box">
                                Phòng của anh Bộ Pc có 2 giường ngủ lớn, view hướng ra thành phố. Không gian rộng rãi thoáng mát, phù hợp cho gia đình hoặc nhóm bạn đi du lịch nghỉ dưỡng. Được trang bị đầy đủ tiện nghi hiện đại nhất.
                            </div>
                        </div>
                    </div>

                    {{-- KÍCH THƯỚC & GIÁ --}}
                    <div class="details-card">
                        <h3 class="card-section-title">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0110 0v4"></path></svg>
                            KÍCH THƯỚC &amp; GIÁ
                        </h3>
                        <div class="pricing-container">
                            <div class="dimension-box">
                                <label>KÍCH THƯỚC</label>
                                <div class="dim-flex">
                                    <div class="dim-item">
                                        Rộng (Width) <br>
                                        <strong>5.0 m</strong>
                                    </div>
                                    <div class="dim-divider"></div>
                                    <div class="dim-item">
                                        Dài (Length) <br>
                                        <strong>8.0 m</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="price-side">
                                <div class="price-row">
                                    <span>Giá giờ (Hourly)</span>
                                    <div class="price-val">200,000 <small>VNĐ</small></div>
                                </div>
                                <div class="price-row">
                                    <span>Giá ngày (Daily)</span>
                                    <div class="price-val">1,500,000 <small>VNĐ</small></div>
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
                                <strong>2</strong>
                            </div>
                            <div class="cap-card">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path><circle cx="12" cy="7" r="1.5"></circle><circle cx="12" cy="7" r="4"></circle></svg>
                                <span>Trẻ em</span>
                                <strong>1</strong>
                            </div>
                            <div class="cap-card">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 17v-4M17 17v-4M3 8v9M21 8v9M3 11h18M5 8h14a2 2 0 012 2v1h-18v-1a2 2 0 012-2z"/></svg>
                                <span>Giường đơn</span>
                                <strong>0</strong>
                            </div>
                            <div class="cap-card">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="8" rx="2"/><path d="M7 11V7a2 2 0 012-2h6a2 2 0 012 2v4M11 11v4"/></svg>
                                <span>Giường đôi</span>
                                <strong>1</strong>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT: Media & Components --}}
                <div class="details-col-right">
                    
                    {{-- MEDIA --}}
                    <div class="details-card">
                        <div class="card-top-flex">
                            <h3 class="card-section-title">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"></polyline></svg>
                                MEDIA (HÌNH ẢNH)
                            </h3>
                            <a href="#" class="view-all-link">View all photos</a>
                        </div>
                        <div class="media-list">
                            <div class="media-item border-left-active">
                                <img src="https://images.unsplash.com/photo-1590490359683-658d3d23f972?auto=format&fit=crop&q=80&w=300" alt="Main">
                                <div class="media-info">
                                    <strong>urban-suite-main.jpg</strong>
                                    <span>Main View</span>
                                </div>
                            </div>
                            <div class="media-item">
                                <img src="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&q=80&w=300" alt="Bath">
                                <div class="media-info">
                                    <strong>bathroom-detail.jpg</strong>
                                    <span>Bathroom</span>
                                </div>
                            </div>
                        </div>
                        <p class="media-total">Total 5 images available</p>
                    </div>

                    {{-- AMENITIES --}}
                    <div class="details-card">
                        <h3 class="card-section-title">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 21l-8-4.5v-9L12 3l8 4.5v9z"></path><polyline points="12 21 12 12 20 7.5"></polyline><line x1="12" y1="12" x2="4" y2="7.5"></line></svg>
                            TIỆN ÍCH (AMENITIES)
                        </h3>
                        <div class="amenities-flex">
                            <div class="amenity-pill"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 12.55a11 11 0 0114.08 0M1.42 9a16 16 0 0121.16 0M8.59 16a6 6 0 016.82 0M12 20h.01"/></svg> Free WiFi</div>
                            <div class="amenity-pill"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M10.59 19.41a2 2 0 102.82 2.82l.01-.01M2 12V2h10M22 12v10h-10M2 12h20"></path></svg> Điều hòa</div>
                            <div class="amenity-pill"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M19.5 13.5a2 2 0 01-3.41 1.41l-3.59-3.59a2 2 0 112.82-2.82l3.59 3.59a2 2 0 01.59 1.41z"/></svg> Bãi đổ</div>
                            <div class="amenity-pill"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg> Hồ bơi</div>
                        </div>
                    </div>

                    {{-- ROOM EQUIPMENT --}}
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
                                <tr>
                                    <td>Điều hòa Daikin 1.5HP</td>
                                    <td class="qty-num">1</td>
                                </tr>
                                <tr>
                                    <td>Tủ lạnh mini Samsung</td>
                                    <td class="qty-num">1</td>
                                </tr>
                                <tr>
                                    <td>Smart TV 55 inch</td>
                                    <td class="qty-num">1</td>
                                </tr>
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
