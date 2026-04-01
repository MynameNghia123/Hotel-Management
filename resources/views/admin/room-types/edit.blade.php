@extends('admin.layouts.master')

@section('title', 'Chỉnh sửa loại phòng: Urban Suite King | Urban Luxe Admin')

@push('styles')
    @vite(['resources/css/admin/room-types.css', 'resources/css/admin/room-types-edit.css'])
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
                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg>
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
                    <a href="{{ route('admin.room-types.index') }}" class="back-text">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        Trở lại danh sách
                    </a>
                    <h1 class="main-title">Chỉnh sửa loại phòng: Urban Suite King</h1>
                    <p class="sub-desc">Hệ thống quản trị khách sạn Urban Luxe</p>
                </div>
                <div class="right-badges">
                    <button class="btn-cancel" onclick="history.back()">Quay lại</button>
                    <button class="btn-primary-blue" type="submit" form="roomTypeEditForm">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Lưu thay đổi
                    </button>
                </div>
            </div>

            <form id="roomTypeEditForm">
                <div class="details-grid-layout">

                    {{-- LEFT COLUMN --}}
                    <div class="details-col-left">

                        {{-- THÔNG TIN CHUNG --}}
                        <div class="details-card">
                            <h3 class="card-section-title">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                THÔNG TIN CHUNG
                            </h3>

                            <div class="info-split" style="margin-bottom: 24px;">
                                <div class="rte-form-group">
                                    <label class="rte-label">Tên loại phòng</label>
                                    <input type="text" class="rte-input" value="Urban Suite King" placeholder="Nhập tên loại phòng...">
                                </div>
                                <div class="rte-form-group">
                                    <label class="rte-label">Mã loại phòng</label>
                                    <input type="text" class="rte-input" value="USK-590" placeholder="VD: USK-001">
                                </div>
                            </div>

                            <div class="rte-form-group" style="margin-bottom: 24px;">
                                <label class="rte-label">Trạng thái</label>
                                <select class="rte-input rte-select">
                                    <option selected>Đang kinh doanh</option>
                                    <option>Tạm dừng kinh doanh</option>
                                    <option>Ngừng cung cấp</option>
                                </select>
                            </div>

                            <div class="rte-form-group">
                                <label class="rte-label">Mô tả loại phòng</label>
                                <textarea class="rte-input rte-textarea" rows="6" placeholder="Nhập mô tả chi tiết về loại phòng...">Phòng của anh Bộ Pc có 2 giường ngủ lớn, view hướng ra thành phố. Không gian rộng rãi thoáng mát, phù hợp cho gia đình hoặc nhóm bạn đi du lịch nghỉ dưỡng. Được trang bị đầy đủ tiện nghi hiện đại nhất.</textarea>
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
                                    <label class="rte-label" style="margin-bottom: 15px; display: block;">KÍCH THƯỚC PHÒNG</label>
                                    <div class="dim-flex">
                                        <div class="rte-form-group" style="flex:1;">
                                            <label class="rte-label" style="font-size:10px; color:#94a3b8;">Rộng (m)</label>
                                            <input type="number" class="rte-input" value="5.0" step="0.1" style="text-align:center; font-size:18px; font-weight:800;">
                                        </div>
                                        <div class="dim-divider" style="margin: 0 16px;"></div>
                                        <div class="rte-form-group" style="flex:1;">
                                            <label class="rte-label" style="font-size:10px; color:#94a3b8;">Dài (m)</label>
                                            <input type="number" class="rte-input" value="8.0" step="0.1" style="text-align:center; font-size:18px; font-weight:800;">
                                        </div>
                                    </div>
                                </div>
                                <div class="price-side">
                                    <div class="rte-form-group">
                                        <label class="rte-label">Giá giờ (hourly)</label>
                                        <div style="position:relative;">
                                            <input type="number" class="rte-input" value="200000" style="font-size:20px; font-weight:850; color:#2a3f8a; padding-right:50px;">
                                            <span style="position:absolute; right:16px; top:50%; transform:translateY(-50%); font-size:12px; font-weight:800; color:#94a3b8;">VNĐ</span>
                                        </div>
                                    </div>
                                    <div class="rte-form-group" style="margin-top:16px;">
                                        <label class="rte-label">Giá ngày (daily)</label>
                                        <div style="position:relative;">
                                            <input type="number" class="rte-input" value="1500000" style="font-size:20px; font-weight:850; color:#2a3f8a; padding-right:50px;">
                                            <span style="position:absolute; right:16px; top:50%; transform:translateY(-50%); font-size:12px; font-weight:800; color:#94a3b8;">VNĐ</span>
                                        </div>
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
                                    <input type="number" value="2" class="rte-input" style="border:none; background:transparent; font-size:24px; font-weight:850; text-align:center; padding:0; width:40px;">
                                </div>
                                <div class="cap-card">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path><circle cx="12" cy="7" r="1.5"></circle><circle cx="12" cy="7" r="4"></circle></svg>
                                    <span>Trẻ em</span>
                                    <input type="number" value="1" class="rte-input" style="border:none; background:transparent; font-size:24px; font-weight:850; text-align:center; padding:0; width:40px;">
                                </div>
                                <div class="cap-card">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 17v-4M17 17v-4M3 8v9M21 8v9M3 11h18M5 8h14a2 2 0 012 2v1h-18v-1a2 2 0 012-2z"/></svg>
                                    <span>Giường đơn</span>
                                    <input type="number" value="0" class="rte-input" style="border:none; background:transparent; font-size:24px; font-weight:850; text-align:center; padding:0; width:40px;">
                                </div>
                                <div class="cap-card">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="8" rx="2"/><path d="M7 11V7a2 2 0 012-2h6a2 2 0 012 2v4M11 11v4"/></svg>
                                    <span>Giường đôi</span>
                                    <input type="number" value="1" class="rte-input" style="border:none; background:transparent; font-size:24px; font-weight:850; text-align:center; padding:0; width:40px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN --}}
                    <div class="details-col-right">

                        {{-- MEDIA --}}
                        <div class="details-card">
                            <div class="card-top-flex">
                                <h3 class="card-section-title">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"></polyline></svg>
                                    MEDIA (HÌNH ẢNH)
                                </h3>
                                <button type="button" class="rte-upload-btn">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                    Tải ảnh lên
                                </button>
                            </div>

                            <div class="media-list">
                                <div class="media-item border-left-active">
                                    <img src="https://images.unsplash.com/photo-1590490359683-658d3d23f972?auto=format&fit=crop&q=80&w=300" alt="Main">
                                    <div class="media-info" style="flex:1;">
                                        <strong>urban-suite-main.jpg</strong>
                                        <span>Ảnh đại diện chính</span>
                                    </div>
                                    <button type="button" class="rte-media-del">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                                    </button>
                                </div>
                                <div class="media-item">
                                    <img src="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&q=80&w=300" alt="Bath">
                                    <div class="media-info" style="flex:1;">
                                        <strong>bathroom-detail.jpg</strong>
                                        <span>Phòng tắm chi tiết</span>
                                    </div>
                                    <button type="button" class="rte-media-del">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="rte-upload-zone">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                <span>Kéo thả ảnh hoặc <label for="upload" style="color:#2a3f8a; cursor:pointer; font-weight:700;">chọn từ máy</label></span>
                                <input type="file" id="upload" style="display:none;">
                            </div>
                        </div>

                        {{-- TIỆN ÍCH --}}
                        <div class="details-card">
                            <h3 class="card-section-title">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 21l-8-4.5v-9L12 3l8 4.5v9z"></path><polyline points="12 21 12 12 20 7.5"></polyline><line x1="12" y1="12" x2="4" y2="7.5"></line></svg>
                                TIỆN ÍCH (AMENITIES)
                            </h3>
                            <div class="amenities-flex">
                                <label class="amenity-toggle is-on">
                                    <input type="checkbox" checked hidden>
                                    <span>Free WiFi</span>
                                </label>
                                <label class="amenity-toggle is-on">
                                    <input type="checkbox" checked hidden>
                                    <span>Điều hòa</span>
                                </label>
                                <label class="amenity-toggle is-on">
                                    <input type="checkbox" checked hidden>
                                    <span>Bãi đỗ</span>
                                </label>
                                <label class="amenity-toggle is-on">
                                    <input type="checkbox" checked hidden>
                                    <span>Hồ bơi</span>
                                </label>
                                <button type="button" class="amenity-toggle" style="border-style:dashed; border-color:#cbd5e1; background:transparent;">
                                    <span>+ Thêm tiện ích</span>
                                </button>
                            </div>
                        </div>

                        {{-- THIẾT BỊ --}}
                        <div class="details-card">
                            <div class="card-top-flex">
                                <h3 class="card-section-title">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/></svg>
                                    THIẾT BỊ (ROOM EQUIPMENT)
                                </h3>
                            </div>

                            <table class="equip-table">
                                <thead>
                                    <tr>
                                        <th>TÊN THIẾT BỊ</th>
                                        <th style="text-align:center;">SL</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="text" class="rte-table-input" value="Điều hòa Daikin 1.5HP" placeholder="Nhập tên thiết bị...">
                                        </td>
                                        <td style="text-align:center;">
                                            <input type="number" class="rte-table-input rte-qty" value="1" min="1" style="text-align:center;">
                                        </td>
                                        <td style="text-align:right;">
                                            <button type="button" class="rte-del-row">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" class="rte-table-input" value="Tủ lạnh mini Samsung" placeholder="Nhập tên thiết bị...">
                                        </td>
                                        <td style="text-align:center;">
                                            <input type="number" class="rte-table-input rte-qty" value="1" min="1" style="text-align:center;">
                                        </td>
                                        <td style="text-align:right;">
                                            <button type="button" class="rte-del-row">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" class="rte-table-input" value="Smart TV 55 inch" placeholder="Nhập tên thiết bị...">
                                        </td>
                                        <td style="text-align:center;">
                                            <input type="number" class="rte-table-input rte-qty" value="1" min="1" style="text-align:center;">
                                        </td>
                                        <td style="text-align:right;">
                                            <button type="button" class="rte-del-row">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <button type="button" class="rte-upload-zone" style="margin-top:16px; width:100%; padding:10px; border-style:dashed;">
                                <span style="font-size:12px; font-weight:700;">+ Thêm thiết bị mới</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @include('admin.layouts.footer')
    </main>
</div>

<script>
    // Handle toggle amenity
    document.querySelectorAll('.amenity-toggle input').forEach(input => {
        input.addEventListener('change', function() {
            if(this.checked) {
                this.parentElement.classList.add('is-on');
            } else {
                this.parentElement.classList.remove('is-on');
            }
        });
    });
</script>

@endsection
