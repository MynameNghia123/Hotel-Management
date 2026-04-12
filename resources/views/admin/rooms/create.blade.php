@extends('admin.layouts.master')

@section('title', 'Thêm loại phòng mới | Urban Luxe Admin')

@push('styles')
    @vite(['resources/css/admin/room-types.css', 'resources/css/admin/room-types-edit.css'])
    <style>
        .create-form-container {
            max-width: 800px;
            margin: 0 auto;
        }
    </style>
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

        <div class="admin-content">

            {{-- PAGE HEADER ACTIONS --}}
            <div class="page-actions-header">
                <div class="header-titles">
                    <a href="{{ route('admin.rooms.index') }}" class="back-text">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        Trở lại danh sách
                    </a>
                    <h1 class="main-title">Thêm Loại Phòng Mới</h1>
                    <p class="sub-desc">Hệ thống quản trị khách sạn Urban Luxe</p>
                </div>
                <div class="right-badges">
                    <button class="btn-cancel" onclick="history.back()">Quay lại</button>
                    <button class="btn-primary-blue" type="submit" form="roomTypeCreateForm">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Lưu loại phòng
                    </button>
                </div>
            </div>

            <form id="roomTypeCreateForm" action="{{ route('admin.rooms.store') }}" method="POST">
                @csrf
                
                <div class="create-form-container">
                    <div class="details-col-left" style="width: 100%;">
                        
                        {{-- THÔNG TIN CHUNG --}}
                        <div class="details-card">
                            <h3 class="card-section-title">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                THÔNG TIN CHUNG
                            </h3>

                            <div class="info-split" style="margin-bottom: 24px;">
                                <div class="rte-form-group">
                                    <label class="rte-label">Tên loại phòng</label>
                                    <input type="text" name="name" class="rte-input" value="{{ old('name') }}" placeholder="Nhập tên loại phòng..." required>
                                </div>
                                <div class="rte-form-group">
                                    <label class="rte-label">Mã loại phòng</label>
                                    <input type="text" name="code" class="rte-input" value="{{ old('code') }}" placeholder="VD: USK-001" required>
                                </div>
                            </div>

                            <div class="rte-form-group">
                                <label class="rte-label">Mô tả loại phòng</label>
                                <textarea name="description" class="rte-input rte-textarea" rows="6" placeholder="Nhập mô tả chi tiết về loại phòng...">{{ old('description') }}</textarea>
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
                                            <input type="number" name="width" class="rte-input" value="{{ old('width') }}" step="0.1" style="text-align:center; font-size:18px; font-weight:800;" required>
                                        </div>
                                        <div class="dim-divider" style="margin: 0 16px;"></div>
                                        <div class="rte-form-group" style="flex:1;">
                                            <label class="rte-label" style="font-size:10px; color:#94a3b8;">Dài (m)</label>
                                            <input type="number" name="height" class="rte-input" value="{{ old('height') }}" step="0.1" style="text-align:center; font-size:18px; font-weight:800;" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="price-side">
                                    <div class="rte-form-group">
                                        <label class="rte-label">Giá giờ (hourly)</label>
                                        <div style="position:relative;">
                                            <input type="number" name="hourly_price" class="rte-input" value="{{ old('hourly_price') }}" style="font-size:20px; font-weight:850; color:#2a3f8a; padding-right:50px;" required>
                                            <span style="position:absolute; right:16px; top:50%; transform:translateY(-50%); font-size:12px; font-weight:800; color:#94a3b8;">VNĐ</span>
                                        </div>
                                    </div>
                                    <div class="rte-form-group" style="margin-top:16px;">
                                        <label class="rte-label">Giá ngày (daily)</label>
                                        <div style="position:relative;">
                                            <input type="number" name="daily_price" class="rte-input" value="{{ old('daily_price') }}" style="font-size:20px; font-weight:850; color:#2a3f8a; padding-right:50px;" required>
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
                                    <input type="number" name="adult_quantity" value="{{ old('adult_quantity', 2) }}" class="rte-input" style="border:none; background:transparent; font-size:24px; font-weight:850; text-align:center; padding:0; width:40px;" required>
                                </div>
                                <div class="cap-card">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path><circle cx="12" cy="7" r="1.5"></circle><circle cx="12" cy="7" r="4"></circle></svg>
                                    <span>Trẻ em</span>
                                    <input type="number" name="child_quantity" value="{{ old('child_quantity', 1) }}" class="rte-input" style="border:none; background:transparent; font-size:24px; font-weight:850; text-align:center; padding:0; width:40px;" required>
                                </div>
                                <div class="cap-card">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 17v-4M17 17v-4M3 8v9M21 8v9M3 11h18M5 8h14a2 2 0 012 2v1h-18v-1a2 2 0 012-2z"/></svg>
                                    <span>Giường đơn</span>
                                    <input type="number" name="single_bed_quantity" value="{{ old('single_bed_quantity', 0) }}" class="rte-input" style="border:none; background:transparent; font-size:24px; font-weight:850; text-align:center; padding:0; width:40px;" required>
                                </div>
                                <div class="cap-card">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="8" rx="2"/><path d="M7 11V7a2 2 0 012-2h6a2 2 0 012 2v4M11 11v4"/></svg>
                                    <span>Giường đôi</span>
                                    <input type="number" name="double_bed_quantity" value="{{ old('double_bed_quantity', 1) }}" class="rte-input" style="border:none; background:transparent; font-size:24px; font-weight:850; text-align:center; padding:0; width:40px;" required>
                                </div>
                            </div>
                        </div>

                        <div class="details-card" style="background: #f8fafc; border: 1px dashed #cbd5e1; text-align: center; padding: 32px;">
                            <p style="color: #64748b; font-weight: 500; font-size: 14px;">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-bottom: 8px; display: block; margin-left: auto; margin-right: auto;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                Sau khi thêm Loại phòng thành công, bạn có thể Tải ảnh, Thêm Tiện ích và Thiết bị ở trang <strong>Chỉnh sửa</strong>.
                            </p>
                        </div>

                    </div>
                </div>
            </form>
        </div>

        @include('admin.layouts.footer')
    </main>
</div>
@endsection